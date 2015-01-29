<?php

/**
 * This is the model class for table "message_wall".
 *
 * The followings are the available columns in table 'message_wall':
 * @property string $id
 * @property string $content
 * @property integer $id_send
 * @property integer $id_receive
 * @property integer $is_read
 * @property string $status
 * @property integer $created
 * @property string $name_send
 */
class MessageWall extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MessageWall the static model class
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
		return 'message_wall';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('content, id_send, created, name_send', 'required'),
			array('id_send, id_receive, is_read, created', 'numerical', 'integerOnly'=>true),
			array('content', 'length', 'max'=>1000),
			array('status', 'length', 'max'=>7),
			array('name_send, image', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, content, id_send, id_receive, is_read, status, created, name_send', 'safe', 'on'=>'search'),
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
            'comment' => array(self::HAS_MANY, 'CommentMessage', 'id_message')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'content' => 'Content',
			'id_send' => 'Id Send',
			'id_receive' => 'Id Receive',
			'is_read' => 'Is Read',
			'status' => 'Status',
			'created' => 'Created',
			'name_send' => 'Name Send',
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
		$criteria->compare('content',$this->content,true);
		$criteria->compare('id_send',$this->id_send);
		$criteria->compare('id_receive',$this->id_receive);
		$criteria->compare('is_read',$this->is_read);
		$criteria->compare('status',$this->status,true);
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
    public function getUrlImage($id = null, $size= 'feed-438'){
        $id = $id ? $id : $this->id;

        $imgConf = Yii::app()->params->message;
        $contentPath = $imgConf['path']."{$id}/".$size.'.jpg';
        return Yii::app()->getBaseUrl(TRUE).'/'.$contentPath;
    }
}