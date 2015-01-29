<?php

/**
* Class này support việc sử dụng 1 active record thông qua quá trình Rest
*/
class RestActiveRecordController extends RESTController
{
	public $ARClassName;

	public $orderByArgName='orderBy';
	public $limitArgName='limit';
	public $offsetArgName='offset';
	public $pkArgName='id';

    public $defaultOffset=0;
    public $defaultLimit=50;
    public $defaultOrderBy='';

	public $requiredAttrsToFind=array();

	function init()
	{
		parent::init();

		assert('!empty($this->ARClassName)');
	}

	/**
	* Lấy ra 1 AR theo primary keys
	*
	* @param mixed $pk primary key
	*
	* @return array NULL nếu không tìm thấy
	*/
    protected function internalFindByPk($pk)
    {
        $x = CActiveRecord::model($this->ARClassName)->findByPk($pk);

        if (is_null($x)) return $this->response(
        	null,
        	404,
        	Yii::t('message', ':class #:pd not found',
        		array(':class'=>$this->ARClassName,':pk'=>$pk)
        	)
        );

        return $this->response($x->attributes);
    }

    protected function internalFindByAttributes($attrs, $orderBy, $limit, $offset)
    {

    }

    function actionGet()
	{
        $pk = $this->getRequestGet($this->pkArgName, null, false);
        if (!empty($pk)) return $this->internalFindByPk($pk);

        $get = new CMap($_GET);
        $get->mergeWith($this->getDefaultArgs);

		$offset = $get->remove($this->offsetArgName);
        if (empty($offset)) $offset = $this->defaultOffset;

		$limit = $get->remove($this->limitArgName);
        if (empty($limit)) $limit = $this->defaultLimit;

		$orderBy = $get->remove($this->orderByArgName);
        if (empty($orderBy)) $orderBy = $this->defaultOrderBy;

        return $this->internalFindByAttributes($get->toArray(), $orderBy, $limit, $offset);
	}
}
