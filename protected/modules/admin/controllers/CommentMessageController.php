<?php

class CommentMessageController extends AdminController
{
    public function init(){
        parent::init();
        $this->layout = '//admin/commentMessage/_layout';
        $this->menu_parent_selected = 'commentMessage';

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
        $this->menu_child_selected = 'commentMessage';
        $this->menu_sub_selected = 'index';

        $model = new CommentMessage();
        $model->unsetAttributes();  // clear any default values

        $criteria=new CDbCriteria;
//        $criteria->select = '
//            t.id,
//            t.id_daily,
//            t.status,
//            t.id_send,
//            t.course_id
//            ';

        if($course = Yii::app()->request->getQuery('CommentMessage')){
            $model->attributes = $course;
            if(isset($course['id_message']) && $course['id_message']) $criteria->compare('t.id_message', $course['id_message']);
            if(isset($course['parent_id']) && $course['parent_id']) $criteria->compare('t.parent_id', $course['parent_id']);
            if(isset($course['status']) && $course['status']) $criteria->compare('t.status', $course['status']);
            if(isset($course['name_send']) && $course['name_send']) $criteria->compare('t.name_send', $course['name_send'], true);
        }


        $dataProvider = new CActiveDataProvider('CommentMessage', array(
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
        $this->menu_child_selected = 'commentMessage_create';
        $this->menu_sub_selected = 'create';

        $model = new CommentMessage();

        if(isset($_POST['CommentMessage']))
        {
            $post = Yii::app()->request->getPost('CommentMessage');
            $model->attributes = $post;

            if($model->validate()) {
                $model->setIsNewRecord(TRUE);
                $model->insert();

                Yii::app()->user->setFlash('success', "Post {$model->content} was added successful!");
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
        $this->menu_child_selected = 'commentMessage_update';
        $this->menu_sub_selected = 'update';

        $model= CommentMessage::model()->findByPk($id);

        if(isset($_POST['CommentMessage']))
        {
            $post = Yii::app()->request->getPost('CommentMessage');
            $model->attributes=$post;

            if($model->validate()) {
                $model->setIsNewRecord(FALSE);

                $model->update();

                Yii::app()->user->setFlash('success', "Post {$model->content} was updated successful!");
                $this->refresh();
            }
        }


        $this->render('_form',array(
            'model'=>$model
        ));
    }

    public function actionDelete($id) {
        $knowledge = CommentMessage::model()->findByPk($id);
        $knowledge->status = 'disable';
        $knowledge->update();

        //TODO delete file in disk

        echo "Xóa kiến thức mới {$knowledge->content} thành công";

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
        $model = CommentMessage::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }
}