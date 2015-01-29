<?php

class CourseController extends AdminController
{
    public function init(){
        parent::init();
        $this->layout = '//admin/course/_layout';
        $this->menu_parent_selected = 'course';

    }

    /**
     * @return array action filters
     */
    public function filters()
    {
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
    public function accessRules()
    {
        return array(
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions'=>array('create', 'index', 'update','delete'),
                'users'=>array('@'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }

    /**
     * Index of page handbook
     * list of handbook
     */
    public function actionIndex() {
        $this->menu_child_selected = 'course';
        $this->menu_sub_selected = 'index';

        $model = new Course();
        $model->unsetAttributes();  // clear any default values

        $criteria=new CDbCriteria;
        $criteria->select = '
            t.id,
            t.name,
            t.time_start,
            t.time_end,
            t.content,
            t.status
            ';

        if($course = Yii::app()->request->getQuery('Course')){
            $model->attributes = $course;
            if(isset($course['name']) && $course['name']) $criteria->compare('t.name', $course['name']);
            if(isset($course['time_start']) && $course['time_start']) $criteria->compare('t.time_start', $course['time_start']);
            if(isset($course['time_end']) && $course['time_end']) $criteria->compare('t.time_end', $course['time_end']);
        }


        $dataProvider = new CActiveDataProvider('Course', array(
            'criteria'=>$criteria,
            'sort'=>array(      // CSort
                'defaultOrder' => 't.id DESC',
            ),

            'pagination' => array(
                'pageSize' => 30,
                //                    'totalItemCount' => 'page',
                'pageVar' => 'page',
            ),
        ));
        $this->render('index', array('model'=>$model, 'dataProvider'=>$dataProvider));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $this->menu_child_selected = 'course_create';
        $this->menu_sub_selected = 'create';

        $model = new Course();

        $imgConf = Yii::app()->params->course;
        $tempPath = "upload/temp/course/".Yii::app()->getSession()->sessionID."/";
        if(!file_exists($tempPath)) mkdir($tempPath,0777,true);

        Yii::app()->session['contentPath'] = realpath($tempPath);

        if(isset($_POST['Course']))
        {
            $post = Yii::app()->request->getPost('Course');
            $model->attributes = $post;

            //tesst
            $model->time_start = strtotime($post['time_start']);
            $model->time_end = strtotime($post['time_end']);

            if($model->validate()) {
                $model->setIsNewRecord(TRUE);
                $model->insert();

                $path = $imgConf['path']."{$model->id}/";
                if(!file_exists($path)) mkdir($path,0777,true);

                if(trim($model->content)){
                    // add baseUrl to temp images
                    Yii::import('ext.simple_html_dom');
                    $html = new simple_html_dom($model->content);
                    foreach($html->find('img') as $i => $img){

                        if(preg_match('{^/upload/temp/course/'.Yii::app()->getSession()->sessionID.'/.+$}', $img->src)){
                            $imgName = substr($img->src, strlen("/upload/temp/course/".Yii::app()->getSession()->sessionID."/"));
                            $image = WideImage::load($this->baseUrl.$img->src);
                            $image->saveToFile($path.$imgName);
                            $img->src = $this->baseUrl."/".$path.$imgName;
                        }
                    }
                    $content = $html->save();
                    // upload content images
                    Yii::import('ext.Myext');
                    $model->content = Myext::saveContentImages($content, $path, array(
                        'image_x' => $imgConf['img']['body']['width'],
                        'image_y' => $imgConf['img']['body']['height'],
                    ));
                }

                // remove temp images
                Myext::deleteDir("upload/temp/course/", FALSE);

                $model->update();

                unset(Yii::app()->session['contentPath']);

                Yii::app()->user->setFlash('success', "Post {$model->name} was added successful!");
                $this->refresh();
            }
        }

        $this->render('_form',array(
            'model'=>$model
        ));
    }


    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $this->menu_child_selected = 'course_update';
        $this->menu_sub_selected = 'update';

        $model= Course::model()->findByPk($id);

        $imgConf = Yii::app()->params->course;
        $tempPath = $imgConf['path']."{$model->id}/";
        if(!file_exists($tempPath)) mkdir($tempPath,0777,true);

        Yii::app()->session['contentPath'] = realpath($tempPath);

        if(isset($_POST['Course']))
        {
            Yii::import('ext.MyDateTime');
            $post = Yii::app()->request->getPost('Course');
            $model->attributes=$post;

            if($post['time_start']) $model->time_start = strtotime($post['time_start']);
            if($post['time_end'])$model->time_end = strtotime($post['time_end']);

            if($model->validate()) {
                $model->setIsNewRecord(FALSE);

                /////// IMAGES ////////
                $path = $imgConf['path']."{$model->id}/";
                if(!file_exists($path)) mkdir($path,0777,true);

                if(trim($model->content)){
                    // upload content images
                    Yii::import('ext.Myext');
                    $model->content = Myext::saveContentImages($model->content, $path, array(
                        'image_x' => $imgConf['img']['body']['width'],
                        'image_y' => $imgConf['img']['body']['height'],
                    ));
                }

                $model->update();

                Yii::app()->user->setFlash('success', "Post {$model->name} was updated successful!");
                $this->refresh();
            }
        }

        $model->time_start = date('Y-m-d h:m:s', $model->time_start);
        $model->time_end = date('Y-m-d h:m:s', $model->time_end);

        $this->render('_form',array(
            'model'=>$model
        ));
    }

    public function actionDelete($id) {
        $knowledge = Course::model()->findByPk($id);
        $knowledge->status = 'disable';
        $knowledge->update();

        //TODO delete file in disk

        echo "Xóa kiến thức mới {$knowledge->name} thành công";

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if(!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
    }
    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id)
    {
        $model = Course::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }
}