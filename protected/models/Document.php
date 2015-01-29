<?php

/**
 * This is the model class for table "document".
 *
 * The followings are the available columns in table 'document':
 * @property string $id
 * @property integer $course_id
 * @property string $desc
 * @property string $link
 */
class Document extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Document the static model class
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
		return 'document';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('course_id, desc, title', 'required'),
			array('course_id', 'numerical', 'integerOnly'=>true),
			array('desc', 'length', 'max'=>1000),
			array('link, title', 'length', 'max'=>255),

            array('link', 'checkUpload'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, course_id, desc, link, title', 'safe', 'on'=>'search'),
		);
	}

    public function checkUpload($attribute, $params){
        if(isset($_FILES['video_file']['name']) && $_FILES['video_file']['size']){
            $fileType = pathinfo($_FILES['video_file']['name'], PATHINFO_EXTENSION);

            if($fileType == "php" || $fileType == "phpx" || $fileType == "js"){
                $this->addError('link', 'Bạn cần chọn 1 ảnh để upload');
            }
        }else{
            $this->addError('link', 'Bạn cần chọn 1 ảnh để upload');
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
			'course_id' => 'Course',
			'desc' => 'Desc',
			'link' => 'Link',
            'title' => 'Name'
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
		$criteria->compare('course_id',$this->course_id);
		$criteria->compare('desc',$this->desc,true);
		$criteria->compare('link',$this->link,true);
		$criteria->compare('title',$this->title,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function getUrl($id = null,$link = null){
        $id = $id ? $id : $this->id;
        $link = $link ? $link : $this->link;
        return Yii::app()->createUrl("/upload/document/{$id}/{$link}");
    }
}