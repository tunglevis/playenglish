<?php

/**
 * This is the model class for table "comment_message".
 *
 * The followings are the available columns in table 'comment_message':
 * @property string $id
 * @property integer $id_send
 * @property string $name_send
 * @property string $content
 * @property integer $created
 * @property integer $id_message
 * @property integer $parent_id
 * @property string $status
 */
class CommentMessage extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CommentMessage the static model class
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
		return 'comment_message';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_send, name_send, content, id_message', 'required'),
			array('id_send, created, id_message, parent_id', 'numerical', 'integerOnly'=>true),
			array('name_send, content, image', 'length', 'max'=>255),
			array('status', 'length', 'max'=>7),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, id_send, name_send, content, created, id_message, parent_id, status', 'safe', 'on'=>'search'),
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
			'id_send' => 'Is Send',
			'name_send' => 'Name Send',
			'content' => 'Content',
			'created' => 'Created',
			'id_message' => 'Id Message',
			'parent_id' => 'Parent',
			'status' => 'Status',
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
		$criteria->compare('id_send',$this->id_send);
		$criteria->compare('name_send',$this->name_send,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('created',$this->created);
		$criteria->compare('id_message',$this->id_message);
		$criteria->compare('parent_id',$this->parent_id);
		$criteria->compare('status',$this->status,true);

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

        $imgConf = Yii::app()->params->message_comment;
        $contentPath = $imgConf['path']."{$id}/".$size.'.jpg';
        return Yii::app()->getBaseUrl(TRUE).'/'.$contentPath;
    }
}