<?php

/**
 * This is the model class for table "comment_daily".
 *
 * The followings are the available columns in table 'comment_daily':
 * @property string $id
 * @property integer $id_daily
 * @property integer $parent_id
 * @property string $content
 * @property string $status
 * @property integer $id_send
 * @property integer $created
 * @property string $name_send
 */
class CommentDaily extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CommentDaily the static model class
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
		return 'comment_daily';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_daily, content, id_send, name_send', 'required'),
			array('id_daily, parent_id, id_send, created', 'numerical', 'integerOnly'=>true),
			array('content', 'length', 'max'=>1000),
			array('status', 'length', 'max'=>7),
			array('name_send, image', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, id_daily, parent_id, content, status, id_send, created, name_send, image', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_daily' => 'Id Daily',
			'parent_id' => 'Parent',
			'content' => 'Content',
			'status' => 'Status',
			'id_send' => 'Id Send',
			'created' => 'Created',
			'name_send' => 'Name Send',
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
		$criteria->compare('id_daily',$this->id_daily);
		$criteria->compare('parent_id',$this->parent_id);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('id_send',$this->id_send);
		$criteria->compare('created',$this->created);
		$criteria->compare('name_send',$this->name_send,true);

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

    public function getUrlImage($id = null, $size= 'comment-250'){
        $id = $id ? $id : $this->id;

        $imgConf = Yii::app()->params->comment;
        $contentPath = $imgConf['path']."{$id}/".$size.'.jpg';
        return Yii::app()->getBaseUrl(TRUE).'/'.$contentPath;
    }
}