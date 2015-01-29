<?php

/**
 * This is the model class for table "widget".
 *
 * The followings are the available columns in table 'widget':
 * @property string $id
 * @property string $name
 * @property string $class
 * @property string $desc
 * @property string $config
 *
 * The followings are the available model relations:
 * @property PageHasWidget[] $pageHasWidgets
 */
class Widget extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Widget the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'widget';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, class', 'required'),
			array('name, class, desc', 'length', 'max'=>255),
			array('config', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, class, desc, config', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'pageHasWidgets' => array(self::HAS_MANY, 'PageHasWidget', 'widget_class'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'class' => 'Class',
			'desc' => 'Desc',
			'config' => 'Config',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('class',$this->class,true);
		$criteria->compare('desc',$this->desc,true);
		$criteria->compare('config',$this->config,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    public function getConfigDecode(){
        $config = json_decode($this->config, TRUE);
        return $config ? $config : array();
    }
    
}
