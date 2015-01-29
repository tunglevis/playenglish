<?php

Yii::import('api.extensions.RESTful.RESTCaller');

/**
* @property boolean $isNewRecord Whether the record is new and should be inserted when calling {@link save}.
* @property string $restBaseUrl
*/
abstract class RestModel extends CModel
{
	private static $_models=array();			// class name => model
	private $_attributes=array();				// attribute name => attribute value
	private $_new=false;						// whether this instance is new or not
	private $_pk;								// old primary key value

	private $_callerInstances=array();

	protected $_httpUsr = CORE_API_HTTP_USR;
	protected $_httpPwd = CORE_API_HTTP_PWD;
	protected $_rsaPrvKey = CORE_API_RSA_PRIVATE_KEY;

	protected $_pkArgName='id';
	protected $_orderByArgName='order_by';
	protected $_offsetArgName='offset';
	protected $_limitArgName='limit';



	/**
	* Cần lặp lại đoạn code này cho mọi class kế thừa
	*
	* @var RestModel
	*/
	protected $_modelClassId = __CLASS__;

	/**
	 * Returns the static model of the specified AR class.
	 * The model returned is a static instance of the AR class.
	 * It is provided for invoking class-level methods (something similar to static class methods.)
	 *
	 * EVERY derived AR class must override this method as follows,
	 * <pre>
	 * public static function model($className=__CLASS__)
	 * {
	 *     return parent::model($className);
	 * }
	 * </pre>
	 *
	 * @param string $className active record class name.
	 * @return RestModel active record model instance.
	 */
	public static function model($className=__CLASS__)
	{
		if(!isset(self::$_models[$className])) {
			$model=self::$_models[$className]=new $className(null);
			$model->_modelClassId = $className;
		}

		return self::$_models[$className];
	}

	function restBaseUrl() { assert(false); }

	function __construct()
	{
		$this->setIsNewRecord(true);
		foreach ($this->attributeNames() as $name) $this->_attributes[$name]=null;
	}

	/**
	 * Sets the named attribute value.
	 * You may also use $this->AttributeName to set the attribute value.
	 * @param string $name the attribute name
	 * @param mixed $value the attribute value.
	 * @return boolean whether the attribute exists and the assignment is conducted successfully
	 * @see hasAttribute
	 */
	public function setAttribute($name,$value)
	{
		if(property_exists($this,$name))
			$this->$name=$value;
		else if($this->hasAttribute($name)) $this->_attributes[$name]=$value;
		else return false;

		return true;
	}

	/**
	 * Checks whether this AR has the named attribute
	 * @param string $name attribute name
	 * @return boolean whether this AR has the named attribute (table column).
	 */
	public function hasAttribute($name)
	{
		return in_array($name, $this->attributeNames());
	}

	/**
	 * PHP setter magic method.
	 * This method is overridden so that AR attributes can be accessed like properties.
	 * @param string $name property name
	 * @param mixed $value property value
	 */
	public function __set($name,$value)
	{
		if($this->setAttribute($name,$value)===false)
		{
			parent::__set($name,$value);
		}
	}

	/**
	 * Returns the named attribute value.
	 * If this is a new record and the attribute is not set before,
	 * the default column value will be returned.
	 * If this record is the result of a query and the attribute is not loaded,
	 * null will be returned.
	 * You may also use $this->AttributeName to obtain the attribute value.
	 * @param string $name the attribute name
	 * @return mixed the attribute value. Null if the attribute is not set or does not exist.
	 * @see hasAttribute
	 */
	public function getAttribute($name)
	{
		if(property_exists($this,$name))
			return $this->$name;
		else if(array_key_exists($name, $this->_attributes))
			return $this->_attributes[$name];
	}

	/**
	 * PHP getter magic method.
	 * This method is overridden so that AR attributes can be accessed like properties.
	 * @param string $name property name
	 * @return mixed property value
	 * @see getAttribute
	 */
	public function __get($name)
	{
		if($this->hasAttribute($name))
			return $this->getAttribute($name);
		else
			return parent::__get($name);
	}

	/**
	 * Returns if the current record is new.
	 * @return boolean whether the record is new and should be inserted when calling {@link save}.
	 * This property is automatically set in constructor and {@link populateRecord}.
	 * Defaults to false, but it will be set to true if the instance is created using
	 * the new operator.
	 */
	public function getIsNewRecord()
	{
		return $this->_new;
	}

	/**
	 * Sets if the record is new.
	 * @param boolean $value whether the record is new and should be inserted when calling {@link save}.
	 * @see getIsNewRecord
	 */
	public function setIsNewRecord($value)
	{
		$this->_new=$value;
	}

	/**
	* Đọc registry của hệ thống
	*
	* @param string $name tên registry muốn đọc
	*
	* @return string
	*/
	protected function readPrivateRegistry($name)
	{
		if (!preg_match('{^reg://}', $name)) return $name;

		$name = substr($name, 6);
		return Yii::app()->registry->getRegistry($this->_modelClassId.'_'.$name);
	}

	/**
	 * Creates an active record instance.
	 * This method is called by {@link populateRecord} and {@link populateRecords}.
	 * You may override this method if the instance being created
	 * depends the attributes that are to be populated to the record.
	 * For example, by creating a record based on the value of a column,
	 * you may implement the so-called single-table inheritance mapping.
	 * @param array $attributes list of attribute values for the active records.
	 * @return RestModel the active record
	 */
	protected function instantiate($attributes)
	{
		$class=get_class($this);
		$model=new $class(null);
		return $model;
	}

	protected function populateRecord($data)
	{
		$model = $this->instantiate($this);
		$model->setIsNewRecord(false);
		foreach ($this->attributeNames() as $attrName){
		 	if (isset($data[$attrName])) $model->$attrName = $data[$attrName];
		}

		return $model;
	}

	/**
	* Từ dữ liệu array đơn thuần tạo ra model
	*
	* @param array $data dữ liệu
	* @param boolean $all lấy tất hay là 1 bản ghi đầu tiên
	* @return RestModel|CArrayDataProvider
	*/
	protected function populateRecords($data, $all=true, $page=0, $pageSize=25)
	{
		assert('isset($data["count"])');
		assert('isset($data["data"])');
		$count = $data['count'];
		$data = $data['data'];

		if (!$all) return empty($data) ? null : $this->populateRecord($data[0]);

        foreach ($data as & $ar) $ar = $this->populateRecord($ar);

        $pagination = new CPagination($count);
        $pagination->currentPage = $page;
        $pagination->pageSize = $pageSize;

        $reindexedData=$page ? array_merge(array_fill(0, $page*$pageSize, null), $data) : $data;

        $dp = new CArrayDataProvider($reindexedData);
        $dp->totalItemCount = $count;
        $dp->pagination = $pagination;

        return $dp;
	}

	/**
	* Hàm này trả về danh sách các callers dùng cho việc tương tác với RESTApi
	*
	* Mỗi phần tử của mảng là cấu hình cho 1 caller theo kiểu Component
	*
	* @return array
	*/
	public function callers()
	{
		$defaultCallConf = array(
			'class'=>'RESTCaller',
            'url'=>$this->restBaseUrl(),
            'httpUsername'=>$this->readPrivateRegistry($this->_httpUsr),
            'httpPassword'=>$this->readPrivateRegistry($this->_httpPwd),
            'rsaPrivateKey'=>$this->readPrivateRegistry($this->_rsaPrvKey),

           // 'logRequest'=>true,
//            'logModelClass'=>'CoreRestApiLog',
        );

        return array(
        	'findByPk'					=>	$defaultCallConf,
        	'findAllByPk'				=>	$defaultCallConf,
        	'findByAttributes'			=>	$defaultCallConf,
        	'findAllByAttributes'		=>	$defaultCallConf,
        	'insert'					=>	$defaultCallConf,
        	'updateByPk'				=>	$defaultCallConf,
        	#'delete'					=>	$defaultCallConf,
        );
	}

	/**
	* Lấy caller cho 1 action cụ thể
	*
	* @param string $name tên action
	* @param array các tham số cần thiết cho việc build URL
	*
	* @return RESTCaller
	*/
	protected function getCaller($name, $params=array())
	{
		if (!isset($this->_callerInstances[$name])) {
			$cfg = $this->callers();
			assert('isset($cfg[$name])');
			$cfg = $cfg[$name];

			$cfg['url'] = strtr($cfg['url'], $params);

			$this->_callerInstances[$name] = Yii::createComponent($cfg);
		}

		return $this->_callerInstances[$name];
	}

	/**
	* Lấy thông tin về 1 Model thông qua khóa chính
	*
	* @param string|integer $pk giá trị của khóa chính
	* @return RestModel null nếu không tìm thấy
	*/
	public function findByPk($pk)
	{
		Yii::trace(get_class($this).'.findByPk()','ext.common.RESTful.RestModel');

		$restCaller = $this->getCaller('findByPk');
		$data = $restCaller->get(array($this->_pkArgName=>$pk));

		$code = $restCaller->getCode();
		if ($code == 200) return $this->populateRecord($data);

		if ($code != 404) throw new RESTException($restCaller);

		return null;
	}

	/**
	 * Tìm kiếm 1 đối tượng thông qua attribute của nó
	 *
	 * @param array $attributes mảng các attribute để tìm kiếm, key là tên attribute, value là giá trị của attribute
	 *
	* @return RestModel null nếu không tìm thấy
	 */
	public function findByAttributes($attributes)
	{
		Yii::trace(get_class($this).'.findByAttributes()','ext.common.RESTful.RestModel');

		$attributes[$this->_offsetArgName] = 0;
		$attributes[$this->_limitArgName] = 1;
		#$attributes

		$restCaller = $this->getCaller('findByAttributes');
		$data = $restCaller->get($attributes);

		$code = $restCaller->getCode();
		if ($code == 200) return $this->populateRecords($data, false);

		if ($code != 404) throw new RESTException($restCaller);

		return null;
	}

	/**
	 * Tìm kiếm các đối tượng thông qua attribute của nó
	 *
	 * @param array $attributes mảng các attribute để tìm kiếm, key là tên attribute, value là giá trị của attribute
	 * @param integer $offset
	 * @param integer $limit
	 *
	* @return CArrayDataProvider
	 */
	public function findAllByAttributes($attributes, $page=1, $pageSize=50, $orderBy='')
	{
		Yii::trace(get_class($this).'.findAllByAttributes()','ext.common.RESTful.RestModel');

		$attributes[$this->_offsetArgName] = ($page-1)*$pageSize;
		$attributes[$this->_limitArgName] = $pageSize;
		$attributes[$this->_orderByArgName] = $orderBy;
		#$attributes

		$restCaller = $this->getCaller('findAllByAttributes');
		$data = $restCaller->get($attributes);

		$code = $restCaller->getCode();
		if ($code == 200) return $this->populateRecords($data, true, $page-1, $pageSize);

		if ($code != 404) throw new RESTException($restCaller);

		return new CArrayDataProvider(array());
	}

	/**
	* Lấy thông tin về 1+ Model thông qua khóa chính
	*
	* @param integer|string|array $pk mảng giá trị của khóa chính
	* @return CArrayDataProvider null nếu không tìm thấy
	*/
	public function findAllByPk($pk)
	{
		Yii::trace(get_class($this).'.findByPk()','ext.common.RESTful.RestModel');

		$restCaller = $this->getCaller('findAllByPk');
		$data = $restCaller->get(array($this->_pkArgName=>$pk));

		$code = $restCaller->getCode();
		if ($code == 200) return $this->populateRecords($data, true, 0, PHP_INT_MAX);

		if ($code != 404) throw new RESTException($restCaller);

		return new CArrayDataProvider(array());
	}

	/**
	 * Returns the old primary key value.
	 * This refers to the primary key value that is populated into the record
	 * after executing a find method (e.g. find(), findAll()).
	 * The value remains unchanged even if the primary key attribute is manually assigned with a different value.
	 * @return mixed the old primary key value. An array (column name=>column value) is returned if the primary key is composite.
	 * If primary key is not defined, null will be returned.
	 * @since 1.1.0
	 */
	public function getOldPrimaryKey()
	{
		return $this->_pk;
	}

	/**
	 * Returns the primary key value.
	 * @return mixed the primary key value. An array (column name=>column value) is returned if the primary key is composite.
	 * If primary key is not defined, null will be returned.
	 */
	public function getPrimaryKey()
	{
		return $this->{$this->_pkArgName};
		/*$table=$this->getMetaData()->tableSchema;
		if(is_string($table->primaryKey))
			return $this->{$table->primaryKey};
		else if(is_array($table->primaryKey))
		{
			$values=array();
			foreach($table->primaryKey as $name)
				$values[$name]=$this->$name;
			return $values;
		}
		else
			return null;
		*/
	}

	/**
	* Import attributes from an array
	*
	* @param array $data the data to import
	* @param array $attributes attributes list to be imported. Empty value make all attributes to be imported.
	*/
	public function importAttributesFromArray($data, $attributes=array())
	{
		if (empty($attributes)) $attributes = $this->attributeNames();

    	foreach ($this->attributeNames() as $name)
        	$this->{$name} = isset($data[$name]) ? $data[$name] : null;
	}

	/**
	 * Repopulates this active record with the latest data.
	 * @return boolean whether the row still exists in the database. If true, the latest data will be populated to this active record.
	 */
	public function refresh()
	{
		Yii::trace(get_class($this).'.refresh()','ext.common.RESTful.RestModel');
		if(!$this->getIsNewRecord() && ($record=$this->findByPk($this->getPrimaryKey()))!==null)
		{
			$this->importAttributesFromArray($record->getAttributes());
			return true;
		}
		else
			return false;
	}

	/**
	 * Updates records with the specified primary key(s).
	 * See {@link find()} for detailed explanation about $condition and $params.
	 * Note, the attributes are not checked for safety and validation is NOT performed.
	 * @param mixed $pk primary key value(s). Use array for multiple primary keys. For composite key, each key value must be an array (column name=>column value).
	 * @param array $attributes list of attributes (name=>$value) to be updated
	 * @param mixed $condition query condition or criteria.
	 * @param array $params parameters to be bound to an SQL statement.
	 * @return integer the number of rows being updated
	 */
	public function updateByPk($pk,$attributes)
	{
		Yii::trace(get_class($this).'.updateByPk()','ext.common.RESTful.RestModel');

		$restCaller = $this->getCaller('updateByPk');

		$data = $restCaller->post($attributes, array($this->_pkArgName=>$pk));
		return $restCaller->getCode() == 200;
	}

	/**
	 * Inserts a row into the table based on this active record attributes.
	 * If the table's primary key is auto-incremental and is null before insertion,
	 * it will be populated with the actual value after insertion.
	 * Note, validation is not performed in this method. You may call {@link validate} to perform the validation.
	 * After the record is inserted to DB successfully, its {@link isNewRecord} property will be set false,
	 * and its {@link scenario} property will be set to be 'update'.
	 * @param array $attributes list of attributes that need to be saved. Defaults to null,
	 * meaning all attributes that are loaded from DB will be saved.
	 * @return boolean whether the attributes are valid and the record is inserted successfully.
	 * @throws CException if the record is not new
	 */
	public function insert($attributes=null)
	{
		if(!$this->getIsNewRecord())
			throw new CDbException(Yii::t('yii','The active record cannot be inserted to database because it is not new.'));
		#if($this->beforeSave())
		{
			Yii::trace(get_class($this).'.insert()','ext.common.RESTful.RestModel');

			$restCaller = $this->getCaller('insert');
			$data = $restCaller->post($this->getAttributes($attributes));

			if($restCaller->getCode() == 200)
			{
                $this->importAttributesFromArray($data);

				$this->_pk=$this->getPrimaryKey();
				#$this->afterSave();
				$this->setIsNewRecord(false);
				#$this->setScenario('update');
				return true;
			}
			else throw new RESTException($restCaller);
		}
		return false;
	}

	/**
	 * Updates the row represented by this active record.
	 * All loaded attributes will be saved to the database.
	 * Note, validation is not performed in this method. You may call {@link validate} to perform the validation.
	 * @param array $attributes list of attributes that need to be saved. Defaults to null,
	 * meaning all attributes that are loaded from DB will be saved.
	 * @return boolean whether the update is successful
	 * @throws CException if the record is new
	 */
	public function update($attributes=null)
	{
		if($this->getIsNewRecord())
			throw new CDbException(Yii::t('yii','The active record cannot be updated because it is new.'));
		#if($this->beforeSave())
		{
			Yii::trace(get_class($this).'.update()','ext.common.RESTful.RestModel');
			if($this->_pk===null)
				$this->_pk=$this->getPrimaryKey();
			$this->updateByPk($this->getOldPrimaryKey(),$this->getAttributes($attributes));
			$this->_pk=$this->getPrimaryKey();
			#$this->afterSave();
			return true;
		}
		#else
			return false;
	}

	/**
	 * Saves the current record.
	 *
	 * The record is inserted as a row into the database table if its {@link isNewRecord}
	 * property is true (usually the case when the record is created using the 'new'
	 * operator). Otherwise, it will be used to update the corresponding row in the table
	 * (usually the case if the record is obtained using one of those 'find' methods.)
	 *
	 * Validation will be performed before saving the record. If the validation fails,
	 * the record will not be saved. You can call {@link getErrors()} to retrieve the
	 * validation errors.
	 *
	 * If the record is saved via insertion, its {@link isNewRecord} property will be
	 * set false, and its {@link scenario} property will be set to be 'update'.
	 * And if its primary key is auto-incremental and is not set before insertion,
	 * the primary key will be populated with the automatically generated key value.
	 *
	 * @param boolean $runValidation whether to perform validation before saving the record.
	 * If the validation fails, the record will not be saved to database.
	 * @param array $attributes list of attributes that need to be saved. Defaults to null,
	 * meaning all attributes that are loaded from DB will be saved.
	 * @return boolean whether the saving succeeds
	 */
	public function save($runValidation=true,$attributes=null)
	{
		if(!$runValidation || $this->validate($attributes))
			return $this->getIsNewRecord() ? $this->insert($attributes) : $this->update($attributes);
		else
			return false;
	}
}