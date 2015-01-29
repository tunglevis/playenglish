<?php

class ApiModule extends CWebModule
{
	public function init()
	{
        $this->setImport(array(
            'api.extensions.RESTful.RESTController',
            'api.extensions.HttpApiLog.models.HttpApiLog',
            'api.components.*',
//            'application.vendors.phpseclib.Crypt.*',
//            'application.vendors.phpseclib.Math.*',
        )); 
        
//        Yii::app()->setComponents(array(
//            'user'=>array(
//                'class'=>'api.extensions.HttpAuth.HttpWebUser',
//            ),
//        ));
        
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}
}
