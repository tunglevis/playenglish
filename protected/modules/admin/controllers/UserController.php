<?php

class UserController extends AdminController
{
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
            array('allow',
                'actions'=>array('create','update', 'delete','index'),
                'users'=>array('@'),
            ),
            array('deny',
                'users'=>array('*'),
            ),
        );
    }

    public function init(){
        parent::init();
        $this->layout = '//admin/user/_layout';
        $this->menu_parent_selected = 'user';
    }


    public function actionIndex()
    {
        $this->layout = '//admin/manager/_layout';
        $this->menu_child_selected = 'user';
        $this->menu_sub_selected = 'index';

        $model = new User();
        $model->unsetAttributes();  // clear any default values

        $criteria=new CDbCriteria;
//        $criteria->select = '
//            t.id,
//            t.feed,
//            t.status,
//            t.id_send,
//            t.course_id
//            ';

        if($course = Yii::app()->request->getQuery('User')){
            $model->attributes = $course;
            if(isset($course['course_id']) && $course['course_id']) $criteria->compare('t.course_id', $course['course_id']);
            if(isset($course['is_send']) && $course['is_send']) $criteria->compare('t.is_send', $course['is_send']);
        }


        $dataProvider = new CActiveDataProvider('User', array(
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

    public function actionCreate()
    {
        $this->layout = '//admin/user/_layout';
        $this->menu_child_selected = 'user_create';
        $this->menu_sub_selected = 'create';

        $model = new User();

        if(isset($_POST['User'])) {
            $model->attributes = Yii::app()->request->getPost('User');
            $model->created = time();
            if($model->validate()) {
                $model->password = $model->getHashPassword($model->password);
                $model->insert();
                $model->unsetAttributes();
                Yii::app()->user->setFlash('success', 'Thêm học viên thành công.');
                $this->refresh();
            }
        }

        $this->render('_form', array(
            'model' => $model
        ));
    }

    /**
     * TODO: fix loi tat ca deu cap nhap dc pass cua admin va nguoi khac @@
     *
     */
    public function actionUpdate($id = NULL)
    {
        $this->layout = '//admin/user/_layout';
        $this->menu_child_selected = 'user_update';
        $this->menu_sub_selected = 'update';

        $model= User::model()->findByPk($id);

        $oldPassword = $model->password;
        if(isset($_POST['User'])) {
            $model->attributes = Yii::app()->request->getPost('User');
            $model->reset_time = time();
            if($model->validate()) {
                $model->password = $model->password ? $model->getHashPassword($model->password) : $oldPassword;
                $model->update();
                Yii::app()->user->setFlash('success', 'Cập nhật học viên thành công.');
                $this->refresh();
            }
        }
        $model->password = null;
        $this->render('_form', array(
            'model' => $model
        ));
    }

    /**
     * xoa nhan vien
     *
     * @param mixed $alias
     * @param mixed $id
     */
    public function actionDelete($id) {
        $manager = User::model()->findByPk($id);
        $manager->status = 'DISABLE';
        $manager->update();
        echo "Xóa tài khoản {$manager->email} thành công";

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if(!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
    }

    private function loadModel($id) {
        $model = Manager::model()->findByPk($id);
        if($model === null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }
}