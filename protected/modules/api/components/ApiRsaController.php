<?php
    class ApiRsaController extends CController
    {
        protected $data;
        
        public function init(){
            Yii::import('ext.Openssl');
            parent::init();
        }

        protected function authorize(){
            $pub_key_id = Yii::app()->request->getPost('pub_key_id');
            $dataEncoded = Yii::app()->request->getPost('data');
            
            if(!$pub_key_id) $this->response(401);
            
            $httpKey = HttpKey::model()->findByAttributes(array('pub_key_id' => $pub_key_id));
            if(!$httpKey) $this->response(401);
            
            $openssl = new Openssl();
            $dataJSON = $openssl->decode($dataEncoded, $httpKey->pri_key, $httpKey->pri_key);
            if(!$dataJSON) $this->response(403);
            
            $data = json_decode($dataJSON, TRUE);
            $data['pub_key_id'] = $pub_key_id;
            
            $this->data = $data;
        }
        
        protected function response($status = 200, $message = NULL, $data = NULL){
            $msgs = array(
                200 => 'OK',
                400 => 'Invalid request',
                401 => 'Unauthorized',
                403 => 'Invalid action',
                404 => 'Object not found',
            );
            $message = $message ? $message : (isset($msgs[$status]) ? $msgs[$status] : NULL);
            
            header(sprintf('HTTP/1.1 %d %s', $status, $message));
            header('Content-Type: application/json');

            if (!is_null($data)) echo json_encode($data);
            Yii::app()->end();
        }

}