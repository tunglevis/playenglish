<?php

/**
 * This is the model class for table "course".
 *
 * The followings are the available columns in table 'course':
 * @property string $id
 * @property string $name
 * @property integer $time_start
 * @property integer $time_end
 * @property string $content
 */
class Course extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Course the static model class
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
		return 'course';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, time_end', 'required'),
//			array('time_start, time_end', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>255),
			array('status', 'length', 'max'=>20),
			array('content,time_start, time_end', 'safe'),

            array('time_start','checkDate'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, status, time_start, time_end, content', 'safe', 'on'=>'search'),
		);
	}

    public function checkDate($attribute, $params){
        if($this->time_start && $this->time_end) {
            $start_time = $this->time_start;
            $end_time = $this->time_end;
            if(($start_time > $end_time) || ($end_time < time())) {
                $this->addError('start','Thời gian chọn không hợp lệ');
            }
            else if($end_time - $start_time > 15*86400){
                $this->addError('start','Thời gian áp dụng không được quá 15 ngày');
            }
        }
    }
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
            'dailyEnglish' => array(self::HAS_MANY, 'DailyEnglish','course_id'),
            'document' => array(self::HAS_MANY, 'Document', 'course_id'),
            'homework' => array(self::HAS_MANY, 'Homework', 'id_course'),
            'user' => array(self::MANY_MANY, 'User', 'course_user(course_id, user_id)'),
            'lession' => array(self::HAS_MANY, 'Lession', 'id_course'),
            'notify' => array(self::HAS_MANY, 'Notify', 'id_course')
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
			'time_start' => 'Time Start',
			'time_end' => 'Time End',
			'content' => 'Content',
            'status' => 'Status'
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
		$criteria->compare('time_start',$this->time_start);
		$criteria->compare('time_end',$this->time_end);
		$criteria->compare('content',$this->content,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function getStatusData(){
        return array(
            'enable' => 'Hiển thị',
            'disalbe' => 'Ẩn'
        );
    }

    public function getStatusLabel(){
        return $this->statusData[$this->status];
    }
    public function getAll($cache = true){
        $data = $this->findAll();
        return $data;
    }

    public function getData(){
        return CHtml::listData($this->getAll(), 'id', 'name');
    }

    public function getCourse($id = null){
        $id = $id ? $id : $this->id;

        $course = $this->findByPk($id);

        return $course['name'];
    }
}