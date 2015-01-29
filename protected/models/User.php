<?php

    /**
    * This is the model class for table "user".
    *
    * The followings are the available columns in table 'user':
    * @property string $id
    * @property string $password
    * @property string $name
    * @property string $dob
    * @property string $gender
    * @property string $website
    * @property string $image
    * @property string $created
    * @property string $address
    * @property string $city_id
    * @property string $district_id
    * @property string $status
    *
    * The followings are the available model relations:
    * @property Branch[] $branches
    * @property Comment[] $comments
    * @property Event[] $events
    * @property City $city
    * @property District $district
    * @property Post[] $posts
    * @property UserEmail[] $userEmails
    * @property Item[] $items
    * @property UserPhone[] $userPhones
    */
    class User extends CActiveRecord
    {
        //        public $email_main;
        //        public $phone_main;

        public $upload_method = 'file';
        public $image_file;
        public $image_url;

        /**
        * Returns the static model of the specified AR class.
        * @param string $className active record class name.
        * @return User the static model class
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
            return 'user';
        }

        /**
        * @return array validation rules for model attributes.
        */
        public function rules()
        {
            // NOTE: you should only define rules for those attributes that
            // will receive user inputs.
            return array(
                array('password, website, image, email, user_name', 'length', 'max'=>255),
                array('name', 'length', 'max'=>160),
                array('gender', 'length', 'max'=>6),
                array('address', 'length', 'max'=>50),
                array('created, reset_time', 'numerical', 'integerOnly'=>true),
                array('city_id, district_id', 'length', 'max'=>10),
                array('status', 'length', 'max'=>7),
                array('dob', 'safe'),

                array('user_name','unique', 'message'=>'This issue already exists.'),

                array('image_file', 'file', 'allowEmpty' => true),
                array('image_file', 'file', 'types'=>'jpg, gif, png', 'allowEmpty' => true),

                array('image_url', 'url', 'allowEmpty' => true, 'on' => 'update'),
                array('upload_method', 'checkUpload', 'on' => 'create'),

                // The following rule is used by search().
                // Please remove those attributes that should not be searched.
                array('id, password, name, dob, gender, website, image, created, address, city_id, district_id, status', 'safe', 'on'=>'search'),
            );
        }


        public function beforeSave(){
            if($this->isNewRecord){
                $this->created = MyDateTime::getCurrentTime();
            }
            return parent::beforeSave();
        }

        public function checkUpload($attribute, $params)
        {
            $post = $_POST['User'];

            $uv = new CUrlValidator;
            $urlValidate = $uv->validateValue($post['image_url']);

            if($post['upload_method'] == 'url'){
                if(!$post['image_url'] || ($post['image_url'] && !$urlValidate)){
                    $this->addError('upload_method', 'Đường dẫn URl ảnh phải đúng định dạng');    
                }
            } elseif($post['upload_method'] == 'file' && !$_FILES['browse_file']['size']){
                $this->addError('upload_method', 'Bạn cần chọn 1 ảnh để upload');
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
//                'userEmails' => array(self::HAS_MANY, 'UserEmail', 'user_id', 'order' => 'userEmails.id ASC')
                'course' => array(self::MANY_MANY, 'Course', 'course_user(user_id, course_id)'),
                'homework' => array(self::HAS_MANY, 'Homework', 'id_user'),
            );
        }


        /**
        * @return array customized attribute labels (name=>label)
        */
        public function attributeLabels()
        {
            return array(
                'id' => 'ID',
                'password' => 'Password',
                'name' => 'Họ & Tên',
                'dob' => 'Ngày sinh',
                'gender' => 'Giới tính',
                'website' => 'Website',
                'image' => 'Image',
                'created' => 'Created',
                'address' => 'Địa chỉ',
                'city_id' => 'Thành phố/Tỉnh',
                'district_id' => 'Quận/Huyện',
                'status' => 'Status',
                'phone_main' => 'SĐT chính',
                'email_main' => 'Email chính',
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
            $criteria->compare('password',$this->password,true);
            $criteria->compare('name',$this->name,true);
            $criteria->compare('dob',$this->dob,true);
            $criteria->compare('gender',$this->gender,true);
            $criteria->compare('website',$this->website,true);
            $criteria->compare('image',$this->image,true);
            $criteria->compare('created',$this->created,true);
            $criteria->compare('address',$this->address,true);
            $criteria->compare('city_id',$this->city_id,true);
            $criteria->compare('district_id',$this->district_id,true);
            $criteria->compare('status',$this->status,true);

            return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
            ));
        }

        public function checkRemoteFile($url)
        {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,$url);
            // don't download content
            curl_setopt($ch, CURLOPT_NOBODY, 1);
            curl_setopt($ch, CURLOPT_FAILONERROR, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            if(curl_exec($ch)!==FALSE)
            {
                return true;
            }
            else
            {
                return false;
            }
        }

        public function getGenderData(){
            return array(
                'MALE' => 'Nam',
                'FEMALE' => 'Nữ',
            );
        }

        public function getGenderLabel(){
            return $this->gender ? $this->genderData[$this->gender] : NULL;
        }

        public function getAvatarUrl($id = null, $size = '65'){
            $id = $id ? $id : $this->id;
//            echo $id.'  '.file_exists(Yii::app()->getBaseUrl(TRUE).'/'.$this->getAvatarPath($id)."avatar_{$size}.jpg"). ' : '.Yii::app()->getBaseUrl(TRUE).'/'.$this->getAvatarPath($id)."avatar_{$size}.jpg";
            return $this->checkRemoteFile(Yii::app()->getBaseUrl(TRUE).'/'.$this->getAvatarPath($id)."avatar_{$size}.jpg") ? Yii::app()->getBaseUrl(TRUE).'/'.$this->getAvatarPath($id)."avatar_{$size}.jpg" : Yii::app()->baseUrl."/themes/web/files/images/icons/photo-48.png";
        }

        /**
        * Tên thư mục upload cha (đơn vị hàng nghìn) của user
        */
        public function getFolderNum($user_id = NULL){
            $user_id = $user_id ? $user_id : $this->id;
            for($i = 1000; $i < 100000000; $i += 1000){
                if($user_id <= $i) return $i;   
            }   
        }

        /**
        * Đường dẫn thư mục upload ảnh cho user
        */
        public function getImagePath($id = null){
            $id = $id ? $id : $this->id;
            return Yii::app()->params->user_img['path'].$this->folderNum."{$id}/";
        }

        public function getAddressFull(){
            if(!$this->address) return NULL;
            return "{$this->address}, {$this->district->name}, {$this->city->name}";
        }

        public function getAvatarPath($id = null){
            return $this->getImagePath($id)."avatar/";
        }
        public function getAvatarImage($param = '65'){
            return "http://anuong.dev/".$this->imagePath."avatar/avatar_".$param.".jpg";
        }

        public function getHashPassword($password){
            Yii::import('ext.PasswordHash');
            $hasher = new PasswordHash(8, TRUE);
            $hash = $hasher->HashPassword($password);
            return $hash;
        }

        public function checkPassword($password, $hashPassword){
            Yii::import('ext.PasswordHash');
            $hasher = new PasswordHash(8, TRUE);
            $check = $hasher->CheckPassword($password, $hashPassword);
            return $check;
        }

        public function loginAuto($id = null, $name = null){
            $id = $id ? $id : $this->id;
            $name = $name ? $name : $this->name;

            $userIdentity = new CUserIdentity($id, '');
            $userIdentity->setState('id', $id);
            $userIdentity->setState('name', $name);

            Yii::app()->user->login($userIdentity, Yii::app()->params->user['remember']);  
        }


        public function getStatusData(){
            return array(
                'ENABLE' => 'Hiển thị',
                'DISABLE' => 'Ẩn'
            );
        }

        public function getStatusLabel(){
            return $this->statusData[$this->status];
        }





        ///////////////////////////////// FOR API ///////////////////////////

        /**
        * Lấy mảng dữ liệu của user
        * 
        */
        public function getData(){
            $avatar = array();
            if($this->image){
                foreach(array_keys(Yii::app()->params->user_img['img']) as $size){
                    $avatar[$size] = $this->getAvatarUrl($size);   
                }
            }
            $data = array(
                'id' => $this->id,
                'name' => $this->name,
                'dob' => $this->dob,
                'gender' => $this->gender,
                'avatar' => $avatar,
                'city_id' => $this->city_id,
                'district_id' => $this->district_id,
                'address' => $this->address,
                'addressFull' => $this->addressFull,
                'created' => $this->created,
            );

            return $data;
        }                                                                                   
        public function getName(){ 

            return (Yii::app()->user->isGuest) ? null : Yii::app()->user->name ;
        }
        public function getComment_count(){ 

            return Comment::model()->countByAttributes(array('user_id' => Yii::app()->user->id)); 
        }
        public function getEvent_count(){ 

            return UserJoinEvent::model()->countByAttributes(array('user_id' => Yii::app()->user->id)); 
        }
        public function getBranchImageCount(){
            return BranchImage::model()->countByAttributes(array('user_id'=>Yii::app()->user->id));
        }

}