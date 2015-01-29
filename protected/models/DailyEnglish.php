<?php

/**
 * This is the model class for table "daily_english".
 *
 * The followings are the available columns in table 'daily_english':
 * @property string $id
 * @property string $feed
 * @property string $user_read
 * @property string $status
 * @property integer $id_send
 */
class DailyEnglish extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return DailyEnglish the static model class
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
		return 'daily_english';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('feed, id_send, name_send', 'required'),
			array('id_send, created', 'numerical', 'integerOnly'=>true),
			array('feed, user_read', 'length', 'max'=>1000),
			array('image, name_send', 'length', 'max'=>255),
			array('status', 'length', 'max'=>7),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, feed, user_read, status, id_send, image, created', 'safe', 'on'=>'search'),
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
            'course' => array(self::BELONGS_TO, 'Course', 'course_id'),
            'comment' => array(self::HAS_MANY, 'CommentDaily', 'id_daily')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'feed' => 'Feed',
			'user_read' => 'User Read',
			'status' => 'Status',
			'id_send' => 'Id Send',
            'image' => 'Image'
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
		$criteria->compare('feed',$this->feed,true);
		$criteria->compare('user_read',$this->user_read,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('id_send',$this->id_send);

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
    public function getUrlImage($id = null, $size= 'feed-438'){
        $id = $id ? $id : $this->id;

        $imgConf = Yii::app()->params->feed;
        $contentPath = $imgConf['path']."{$id}/".$size.'.jpg';
        return Yii::app()->getBaseUrl(TRUE).'/'.$contentPath;
    }
}