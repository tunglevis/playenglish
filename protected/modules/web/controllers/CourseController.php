<?php

class CourseController extends WebController {

    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('error', 'index','feed','feedForm','commentFeed','homework'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionError() {
        $this->layout = '//layouts/main';

        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else {

                $view = 'error';
                if (in_array($error['code'], array(404))) {
                    $view .= $error['code'];
                }
                $this->render($view, $error);
            }
        }
    }

    protected function beforeAction($action) {
        $id = Yii::app()->getRequest()->getQuery('id');
        if(!is_numeric($id)) // $id = how-to-make-pretty-urls
        {
            $this->redirect(Yii::app()->createUrl('/web/user', array('user_name'=>$this->user->user_name, 'id'=>$this->user->id)));
        }
        if(!$user = CourseUser::model()->findByAttributes(array('user_id'=>$this->user->id, 'course_id'=>$id))){
            $this->redirect(Yii::app()->createUrl('/web/user', array('user_name'=>$this->user->user_name, 'id'=>$this->user->id)));
        }
        if(!$course = Course::model()->findByPk($id)){
            $this->redirect(Yii::app()->createUrl('/web/user', array('user_name'=>$this->user->user_name, 'id'=>$this->user->id)));
        }

        return parent::beforeAction($action);
    }

    /**
     * @author tunglv Doe <tunglv.1990@gmail.com>
     *
     * @param
     * @return page home of site
     */
    public function actionIndex($id=null) {
        $this->layout = '//layouts/main';
//        $this->nav_header = 'home';

        $course = Course::model()->with(
            array(
                'user' => array(
                    'select'=>'id, name, image, user_name',
                    'together' => true
                ),
                'document' => array(
                    'select'=>'id, title, link'
                ),
                'homework' => array(
                    'select'=>'id, link'
                ),
                'lession' => array(
                    'select'=>'name, content, time_start, time_end'
                ),
                'notify' => array(
                    'select' => 'time_start, desc'
                )
            )
        )->findByPk($id);

        $this_week = '';
        $day = date('w');
        $week_start = strtotime('-'.$day.' days');
        $week_end = strtotime('+'.(6-$day).' days');

        foreach($course->lession as $key => $val){
            if($val->time_start <= $week_end && $val->time_start >= $week_start){
                $this_week = $val;break;
            }
        }

        $criteria = new CDbCriteria();
        $criteria->compare('t.course_id', $id);
        $criteria->compare('t.status', 'enable');
        $criteria->order = 't.id DESC';

        $total = DailyEnglish::model()->count($criteria);

        $pages = new CPagination($total);
        $pages->pageSize = 2;
        $pages->applyLimit($criteria);

        $posts = DailyEnglish::model()->with('comment')->findAll($criteria);

        $this->render('index', array(
            'course'=>$course,
            'posts' => $posts,
            'pages' => $pages,
            'this_week' => $this_week
        ));
    }

    /**
     * @author tunglv Doe <tunglv.1990@gmail.com>
     *
     * @param $homework_file: file, $id: int( id of course)
     * @do creat feed cho course
     * @return 0 or 1
     */
    public function actionHomework($id = null){
        if(!$_FILES['homework'] || !$_FILES['homework']['size']){
            echo 0;die;
        }

        $imageFileType = pathinfo($_FILES["homework"]["name"],PATHINFO_EXTENSION);
        if($imageFileType == 'php' || $imageFileType == 'phpx'){
            echo 0;die;
        }

        $model = new Homework();
        $model->name_user = $this->user->name;
        $model->id_user = $this->user->id;
        $model->created = time();
        $model->id_course = $id;
        $model->link = 'default';

        if($model->save()) {
            //////////// VIDEO //////////
            $uploaddir = 'upload/homework/' . $model->id . '/';
            if (!file_exists($uploaddir))
                mkdir($uploaddir, 0777, true);
            $max_filesize = 10485760;
            //you should specify the value you want to be maximum of video.

            if (filesize($_FILES['homework']['tmp_name']) > $max_filesize)
                die('File quá lớn.');

            $file = basename($_FILES['homework']['name']);
            $uploadfile = $uploaddir . $file;

            if (move_uploaded_file($_FILES['homework']['tmp_name'], $uploadfile)) {
                $model->link = $file;
            } else {
                echo "ERROR";
            }

            $model->update();

            echo 1;die;
        }

        echo 0;die;
    }

    /**
     * @author tunglv Doe <tunglv.1990@gmail.com>
     *
     * @param $comment-text: string, $comment-image: file, $id: int( id of feed)
     * @do creat feed cho course
     * @return 0 or 1
     */
    public function actionCommentFeed($comment_id = null){
        if(!$comment_id){
            echo 0;die;
        }
        $text = Yii::app()->request->getPost('comment-text');
        if(!$text) {
            echo 0;die;
        }

        $comment = new CommentDaily();
        $comment->id_daily = $comment_id;
        $comment->content = htmlentities($text);
        $comment->id_send = $this->user->id;
        $comment->created = time();
        $comment->name_send = $this->user->name;

        if($comment->save()){
            if($_FILES['comment-image'] && $_FILES['comment-image']['size']){

                $imageFileType = pathinfo($_FILES["comment-image"]["name"],PATHINFO_EXTENSION);
                if($imageFileType == 'php' || $imageFileType == 'phpx'){
                    echo 1;die;
                }

                $imgConf = Yii::app()->params->comment;
                $path = $imgConf['path'] . "{$comment->id}/";
                if (!file_exists($path))
                    mkdir($path, 0777, true);

                $source = 'comment-image';

                Yii::import('ext.wideimage.lib.WideImage');
                $img = WideImage::load($source);

                foreach ($imgConf['img'] as $key => $imgInfo) {
                    $img = $img->resize($imgInfo['width'], $imgInfo['height'], 'outside', 'down');
                    $img = $img->resizeCanvas($imgInfo['width'], $imgInfo['height'], 'center', 'center', null, 'down');
                    $img->saveToFile($path . $key . '.jpg', $imgInfo['quality']);
                }

                $comment->image = 'comment-250';
                $comment->update();

                echo $comment->getUrlImage();die;
            }
            echo 1;die;
        }
        echo 0;die;
    }
    /**
     * @author tunglv Doe <tunglv.1990@gmail.com>
     *
     * @param $feed-text: string, $feed-image: file, $feed-type : 1 or 2, $id: int (id of course)
     * @do creat feed cho course
     * @return 0 or 1
     */
    public function actionFeedForm($id = null){
        if(!$id){echo 0;die;}

        $check = Yii::app()->request->getPost('feed-type');

        if($check == 1){
            $text = Yii::app()->request->getPost('feed-text');
            if(!$text){
                echo 0;die;
            }else {
                $model = new DailyEnglish();

                $model->feed = htmlentities($text);
                $model->id_send = $this->user->id;
                $model->name_send = $this->user->name;
                $model->user_read = $this->user->id;
                $model->course_id = $id;
                $model->created = time();

                if ($model->save()) {
                    echo 1;die;
                }else{
                    echo 0;die;
                }
            }
        }elseif($check == 2){
            if(!isset($_FILES['feed-image']) || !$_FILES['feed-image']['size']){
                echo 0;die;
            }else{

                $imageFileType = pathinfo($_FILES["feed-image"]["name"],PATHINFO_EXTENSION);
                if($imageFileType == 'php' || $imageFileType == 'phpx'){
                    echo 0;die;
                }

                $text = Yii::app()->request->getPost('feed-text');
                if(!$text){
                    echo 0;die;
                }else{
                    $model = new DailyEnglish();

                    $imgConf = Yii::app()->params->feed;

                    $model->feed = htmlentities($text);
                    $model->id_send = $this->user->id;
                    $model->name_send = $this->user->name;
                    $model->user_read = $this->user->id;
                    $model->course_id = $id;
                    $model->created = time();

                    if($model->save()){
                        $path = $imgConf['path'] . "{$model->id}/";
                        if (!file_exists($path))
                            mkdir($path, 0777, true);

                        $source = 'feed-image';

                        Yii::import('ext.wideimage.lib.WideImage');
                        $img = WideImage::load($source);

                        foreach ($imgConf['img'] as $key => $imgInfo) {
                            $img = $img->resize($imgInfo['width'], $imgInfo['height'], 'outside', 'down');
                            $img = $img->resizeCanvas($imgInfo['width'], $imgInfo['height'], 'center', 'center', null, 'down');
                            $img->saveToFile($path . $key . '.jpg', $imgInfo['quality']);
                        }

                        $model->image = 'feed-text';
                        $model->update();
                        echo 1;die;
                    }else{
                        echo 0;die;
                    }
                }
            }
        }else{
            echo 0;die;
        }

        $data = $_POST;
    }

    public function actionFeed($id = null) {
        $this->layout = '//layouts/main';
//        $this->nav_header = 'home';

        $feed = DailyEnglish::model()->with('comment')->findByPk($id);

        $course = Course::model()->with(
            array(
                'user' => array(
                    'select'=>'id, name, user_name, image',
                    'together' => true
                ),
                'document' => array(
                    'select'=>'id, title, link'
                ),
                'homework' => array(
                    'select'=>'id, link'
                ),
                'lession' => array(
                    'select'=>'name, content, time_start, time_end'
                ),
                'notify' => array(
                    'select' => 'time_start, desc'
                )
            )
        )->findByPk($feed->course_id);

        $this_week = '';
        $day = date('w');
        $week_start = strtotime('-'.$day.' days');
        $week_end = strtotime('+'.(6-$day).' days');

        foreach($course->lession as $key => $val){
            if($val->time_start <= $week_end && $val->time_start >= $week_start){
                $this_week = $val;break;
            }
        }

        $this->render('feed', array('feed'=>$feed, 'course'=>$course,'this_week'=>$this_week));
    }
}
