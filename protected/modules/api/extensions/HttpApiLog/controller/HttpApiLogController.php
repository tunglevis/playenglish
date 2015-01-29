<?php

class HttpApiLogController extends CController
{
	public $defaultAction = 'admin';

	public $logModelClass;

	function init()
	{
		parent::init();

		assert('!empty($this->logModelClass)');
	}

	/**
	* @inheritdoc
	*/
	public function getViewPath()
	{
		return dirname(__FILE__).DIRECTORY_SEPARATOR.'views';
	}
	
	public function cutString($value){
		$arr = str_split($value, 120);
		return implode($arr,"\n");
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new $this->logModelClass('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['CoreRestApiLog']))
			$model->attributes=$_GET['CoreRestApiLog'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=CActiveRecord::model($this->logModelClass)->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
