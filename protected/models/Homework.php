<?php

/**
 * This is the model class for table "homework".
 *
 * The followings are the available columns in table 'homework':
 * @property string $id
 * @property string $name
 * @property string $desc
 * @property string $link
 * @property integer $id_user
 * @property string $name_user
 * @property integer $created
 */
class Homework extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Homework the static model class
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
		return 'homework';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('link, id_user, name_user, id_course', 'required'),
			array('id_user, created, id_course', 'numerical', 'integerOnly'=>true),
			array('name, link, name_user', 'length', 'max'=>255),
			array('desc', 'length', 'max'=>1000),

            array('link', 'checkUpload'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, desc, link, id_user, name_user, created', 'safe', 'on'=>'search'),
		);
	}

    public function checkUpload($attribute, $params){
        if(isset($_FILES['homework']['name']) && $_FILES['homework']['size']){
            $fileType = pathinfo($_FILES['homework']['name'], PATHINFO_EXTENSION);

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
			'name' => 'Name',
			'desc' => 'Desc',
			'link' => 'Link',
			'id_user' => 'Id User',
			'name_user' => 'Name User',
			'created' => 'Created',
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
		$criteria->compare('desc',$this->desc,true);
		$criteria->compare('link',$this->link,true);
		$criteria->compare('id_user',$this->id_user);
		$criteria->compare('name_user',$this->name_user,true);
		$criteria->compare('created',$this->created);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    public function getUrl($id = null,$link = null){
        $id = $id ? $id : $this->id;
        $link = $link ? $link : $this->link;
        return Yii::app()->createUrl("/upload/homework/{$id}/{$link}");
    }
}