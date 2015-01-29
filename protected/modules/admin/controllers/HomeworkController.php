<?php

class HomeworkController extends AdminController {

    public function init() {
        parent::init();
        $this->layout = '//admin/homework/_layout';
        $this->menu_parent_selected = 'homework';
    }

    /**
     * @return array action filters
     */
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
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'index', 'update', 'delete'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Index of page handbook
     * list of handbook
     */
    public function actionIndex() {
        $this->menu_child_selected = 'homework';
        $this->menu_sub_selected = 'index';

        $model = new Homework();
        $model->unsetAttributes();  // clear any default values

        $criteria = new CDbCriteria;

        if ($productFilter = Yii::app()->request->getQuery('Homework')) {
            $model->attributes = $productFilter;
            if (isset($productFilter['name']) && $productFilter['name'])
                $criteria->compare('t.name', $productFilter['name'], true);
        }


        $dataProvider = new CActiveDataProvider('Homework', array(
            'criteria' => $criteria,
            'sort' => array(// CSort
                'defaultOrder' => 't.id DESC',
            ),
            'pagination' => array(
                'pageSize' => 30,
                //                    'totalItemCount' => 'page',
                'pageVar' => 'page',
            ),
        ));
        $this->render('index', array('model' => $model, 'dataProvider' => $dataProvider));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $this->menu_child_selected = 'homework_create';
        $this->menu_sub_selected = 'create';

        $model = new Homework();

        if (isset($_POST['Homework'])) {
//            Yii::import('ext.MyDateTime');
            $post = Yii::app()->request->getPost('Homework');
            $model->attributes = $post;
            $model->link = 'default';
//            Yii::import('ext.TextParser');
//            $model->alias = $model->alias ? $model->alias : $model->name;
//            $model->alias = TextParser::toSEOString($model->alias);

//            var_dump($model->validate());
//            var_dump($model->getErrors());die;

            if ($model->validate()) {
                $model->setIsNewRecord(TRUE);
                $model->insert();

                if(isset($_FILES['homework']['tmp_name']) && filesize($_FILES['homework']['tmp_name'])>0){
                    //////////// VIDEO //////////
                    $uploaddir = 'upload/homeword/'.$model->id.'/';
                    if (!file_exists($uploaddir))
                        mkdir($uploaddir, 0777, true);
                    $max_filesize = 10485760;
                    //you should specify the value you want to be maximum of video.

                    if(filesize($_FILES['homework']['tmp_name']) > $max_filesize)
                        die('File quá lớn.');

                    $file = basename($_FILES['homework']['name']);
                    $uploadfile = $uploaddir . $file;

                    if (move_uploaded_file($_FILES['homework']['tmp_name'], $uploadfile)) {
                        $model->link = $file;
                    }
                    else {
                        echo "ERROR";
                    }
                }

                $model->update();

                Yii::app()->user->setFlash('success', "Post {$model->name} was added successful!");
                $this->refresh();
            }
        }

        $this->render('_form', array(
            'model' => $model
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $this->menu_child_selected = 'homework_update';
        $this->menu_sub_selected = 'update';

        $model = Homework::model()->findByPk($id);

//        $imgConf = Yii::app()->params->product;

        if (isset($_POST['Homework'])) {
//            Yii::import('ext.MyDateTime');
            $post = Yii::app()->request->getPost('Homework');
            //             echo "<pre>";print_r($post);echo "</pre>";die;
            $model->attributes = $post;

//            $model->created = $model->created ? $model->created : MyDateTime::getCurrentTime();
//            $model->update = MyDateTime::getCurrentTime();
            if ($model->validate()) {
//                Yii::import('ext.TextParser');
//                $model->alias = $model->alias ? $model->alias : $model->name;
//                $model->alias = TextParser::toSEOString($model->alias);
                $model->setIsNewRecord(FALSE);

                if(isset($_FILES['homework']['tmp_name']) && filesize($_FILES['homework']['tmp_name'])>0){
                    //////////// VIDEO //////////
                    $uploaddir = 'upload/homework/'.$model->id.'/';
                    if (!file_exists($uploaddir))
                        mkdir($uploaddir, 0777, true);
                    $max_filesize = 10485760;
                    //you should specify the value you want to be maximum of video.

                    if(filesize($_FILES['homework']['tmp_name']) > $max_filesize)
                        die('File quá lớn.');

                    $file = basename($_FILES['homework']['name']);
                    $uploadfile = $uploaddir . $file;

                    if (move_uploaded_file($_FILES['homework']['tmp_name'], $uploadfile)) {
                        $model->link = $file;
                    }
                    else {
                        echo "ERROR";
                    }
                }

                $model->update();

                Yii::app()->user->setFlash('success', "Post {$model->name} was updated successful!");

                $this->refresh();
            }
        }

        $this->render('_form', array(
            'model' => $model
        ));
    }

    /**
     * delete a particular model.
     * If delete is successful, the browser will be reloaded page.
     * @param integer $id the ID of the model to be delete
     */
    public function actionDelete($id) {
        $product = Homework::model()->findByPk($id);
//        $product->status = 'DISABLE';
        $product->delete();

        //TODO delete file in disk

        echo "Xóa sanr phẩm {$product->title} thành công";

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = Homework::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }
}