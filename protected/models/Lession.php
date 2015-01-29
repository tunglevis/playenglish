<?php

/**
 * This is the model class for table "lession".
 *
 * The followings are the available columns in table 'lession':
 * @property string $id
 * @property string $name
 * @property string $content
 * @property integer $id_course
 * @property integer $time_start
 * @property integer $time_end
 */
class Lession extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Lession the static model class
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
		return 'lession';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, id_course, time_start', 'required'),
			array('id_course', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>255),
			array('content', 'length', 'max'=>1000),

            array('time_start','checkDate'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, content, id_course, time_start, time_end', 'safe', 'on'=>'search'),
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
			'content' => 'Content',
			'id_course' => 'Id Course',
			'time_start' => 'Time Start',
			'time_end' => 'Time End',
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
		$criteria->compare('content',$this->content,true);
		$criteria->compare('id_course',$this->id_course);
		$criteria->compare('time_start',$this->time_start);
		$criteria->compare('time_end',$this->time_end);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}