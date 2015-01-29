<?php

class RESTController extends CController
{
    public $user;
	public $logModelClass = 'HttpApiLog';

	public $autoLogRequest = false;
	protected $isLogging = false;


	protected $getDefaultArgs = array(
	);

	protected $postDefaultArgs = array(
	);

	/**
	* @var HttpApiLog
	*/
	protected $HttpApiLog;

	function init()
	{
		parent::init();

		if ($this->autoLogRequest) $this->startLogging();
	}

	protected function startLogging()
	{
		$this->isLogging = true;

		# you have to specify the model class for logging
		assert('!empty($this->logModelClass)');

//        echo '<pre>aaaaaaaaaa';print_r(Yii::app()->user->id);echo '</pre>';die;
        
        $this->HttpApiLog = new $this->logModelClass();

		$this->HttpApiLog->http_username = Yii::app()->user->username;

		$this->HttpApiLog->request_method = Yii::app()->request->getRequestType();
		$this->HttpApiLog->request_url = Yii::app()->request->getHostInfo().Yii::app()->request->getRequestUri();

		# get client IP
		$this->HttpApiLog->src_ip = isset($_SERVER["HTTP_X_FORWARDED_FOR"]) ? $_SERVER["HTTP_X_FORWARDED_FOR"] :
						(
							isset($_SERVER["REMOTE_ADDR"]) ? $_SERVER["REMOTE_ADDR"] :
							(
								isset($_SERVER["HTTP_CLIENT_IP"]) ? $_SERVER["HTTP_CLIENT_IP"] : '127.0.0.1'
							)
						);

		$this->HttpApiLog->request_headers = '';
		foreach ($_SERVER as $k=>$v) {
			if (substr($k, 0, 5) != 'HTTP_') continue;
			$this->HttpApiLog->request_headers .= str_replace(' ', '-', ucwords(str_replace('_', ' ', strtolower(substr($k, 5))))).': '.$v."\n";
		}

		$this->HttpApiLog->post_data = file_get_contents('php://input');

		$this->HttpApiLog->dst_ip = $_SERVER['SERVER_ADDR'];
		$this->HttpApiLog->duration = microtime(true);

	}

	protected function finishLogging($status, $message, $data)
	{
		if (!$this->isLogging) return;

		$this->HttpApiLog->duration = microtime(true) - $this->HttpApiLog->duration;
		$this->HttpApiLog->response_code = $status;
		//$this->HttpApiLog->response_data = print_r($data, true);
		$this->HttpApiLog->response_headers = sprintf('HTTP/1.1 %d %s', $status, $message)."\n".implode("\n", headers_list());

		if (!$this->HttpApiLog->save())
			Yii::log('Can not log RestApiCall'."\n".print_r($this->HttpApiLog->getErrors(), true), CLogger::LEVEL_ERROR, 'application.rest');
	}

	/**
	* Lấy message trả về cho 1 code
	*
	* @param integer $code code trả về
	* @return string
	*/
	protected function getMessageFromCode($code)
	{
		/**
		* pattern thường như sau
		* switch ($code) {
		* 	case xxx: return 'abc';
		* 	case yyy: return 'def';
		* 	default: return parent::getMessageFromCode($code);
		* }
		*/
		switch ($code) {
			case 200: return 'OK';

			case 400: return "Invalid request";
			case 403: return 'Invalid action';
			case 404: return 'Object not found';
			default :
				return null;
		}
	}

	/**
	* Trả dữ liệu về client
	*
	* @param mixed $data dữ liệu sẽ đc trả về. Nếu giá trị là NULL thì sẽ lấy message để thay thế
	* @param integer $status code sẽ được trả về
	* @param string $message thông báo đi kèm code. Nếu là null thì sẽ lấy ra bởi {@link getMessageFromCode}
	*/
	protected function response($status = 200, $message = null, $data = NULL)
	{
		if (!$message) $message = $this->getMessageFromCode($status);

		header(sprintf('HTTP/1.1 %d %s', $status, $message));
		header('Content-Type: application/json');

		//if (!is_null($data)){
            echo json_encode(array(
                'status' => $status,
                'message' => $message,
                'data' => $data,
            ));
        //}

		$this->finishLogging($status, $message, $data);
        Yii::app()->end();
	}

	/**
	* Mặc định call action tùy vào REQUEST METHOD của HTTP
	*
	*/
	public function actionIndex()
	{
		$this->run(strtolower($_SERVER['REQUEST_METHOD']));
	}

	function run($actionId)
	{
		try {
			parent::run($actionId);
		} catch (CHttpException $e) {
			#throw $e;
			$message = $e->getMessage();
			if (empty($message)) $message = $this->getMessageFromCode($e->statusCode);
			$this->response($e->statusCode, $message);
		}
	}

	/**
	* Đọc giá trị của 1 tham số từ $_GET
	*
	* @param string $name tên tham số cần đọc
	* @param mixed $defaultValue giá trị mặc định của tham số cần đọc. Nếu là NULL thì sẽ kiểm tra thêm trong {@link $getDefaultArgs}.
	* @param boolean $required Tham số này có yêu cầu hay không, nếu đc yêu cầu mà client không gửi lên thì sẽ throw HttpException 400
	*
	* @return mixed
	*/
	protected function getRequestGet($name, $defaultValue = null, $required=true)
	{
		$value = Yii::app()->getRequest()->getQuery($name, $defaultValue);

		if (is_null($value)) {
			if ($required) throw new CHttpException(400, Yii::t('message', "Missing ':name' GET argument", array(':name'=>$name)));

			if (isset($this->getDefaultArgs[$name])) $value = $this->getDefaultArgs[$name];
		}

		return $value;
	}

	/**
	* Đọc giá trị của 1 tham số từ $_POST
	*
	* @param string $name tên tham số cần đọc
	* @param mixed $defaultValue giá trị mặc định của tham số cần đọc. Nếu là NULL thì sẽ kiểm tra thêm trong {@link $postDefaultArgs}.
	* @param boolean $required Tham số này có yêu cầu hay không, nếu đc yêu cầu mà client không gửi lên thì sẽ throw HttpException 400
	*
	* @return mixed
	*/
	protected function getRequestPost($name, $defaultValue = null, $required=true)
	{
		$value = Yii::app()->getRequest()->getPost($name, $defaultValue);

		if (is_null($value)) {
			if ($required) throw new CHttpException(400, Yii::t('message', "Missing ':name' POST argument", array(':name'=>$name)));

			if (isset($this->postDefaultArgs[$name])) $value = $this->postDefaultArgs[$name];
		}

		return $value;
	}
}
