<?php

    /**
    * Class này cho phép hệ thống xác thực của Yii ứng xử với HttpAuth
    * 
    * @property string $username
    * @property HttpUser $currentUser signed in user, FALSE nếu không có người login
    */
    class HttpWebUser extends CApplicationComponent implements IWebUser
    {
        private $_currentUser;

        private $_username;

        function getUsername()
        {
            if (!isset($this->_username)) $this->login();

            return $this->_username;
        }

        /**
        * Get current user
        * 
        * @return HttpUser FALSE nếu current User không hợp lệ
        */
        function getCurrentUser()
        {
            if (!isset($this->_currentUser)) $this->login();
            return $this->_currentUser;
        }

        /**
        * Returns a value that uniquely represents the identity.
        * @return mixed a value that uniquely represents the identity (e.g. primary key value).
        */
        public function getId()
        {
            return $this->getUsername();
        }
        /**
        * Returns the display name for the identity (e.g. username).
        * @return string the display name for the identity.
        */
        public function getName()
        {
            return $this->getUsername();	
        }

        /**
        * Returns a value indicating whether the user is a guest (not authenticated).
        * @return boolean whether the user is a guest (not authenticated)
        */
        public function getIsGuest()
        {
//            $x = $this->getUsername();
//            return empty($x);
            return $this->_username ? TRUE : FALSE;
        }

        /**
        * Performs access check for this user.
        * @param string $operation the name of the operation that need access check.
        * @param array $params name-value pairs that would be passed to business rules associated
        * with the tasks and roles assigned to the user.
        * @return boolean whether the operations can be performed by this user.
        */
        public function checkAccess($operation,$params=array())
        {
            $access=Yii::app()->getAuthManager()->checkAccess($operation,$this->getId(),$params);
            return $access;
        }


        public function loginRequired()
        {
            $realm = Yii::app()->request->requestUri;
            $nonce = rand(100, 999).time();

            header('HTTP/1.1 401 Unauthorized');
            header('WWW-Authenticate: Digest '.
                'realm="'.$realm.'"'.
                ',qop="auth",nonce="'.$nonce.'",opaque="'.sprintf('%x', crc32($realm)).'"');

            header('Content-Type: text/html;charset=utf8');

            echo 'Contact: LE VAN TUNG - tunglevan@admicro.vn';

            Yii::app()->end();

            return false;
        }


        /**
        * Verify Digest
        * @return HttpUser $httpUser or FALSE
        */
        protected function verifyDigest()
        {
            $txt = $_SERVER['PHP_AUTH_DIGEST'];
            // protect against missing data
            $parts = array('realm','nonce','nc', 'cnonce', 'qop','username','uri','response','opaque');
            $data = array();
            $keys = implode('|', $parts);

            preg_match_all('@('.$keys.')=(?:([\'"])([^\2]+?)\2|([^\s,]+))@', $txt, $matches, PREG_SET_ORDER);

            foreach ($matches as $m) {
                $data[$m[1]] = $m[3] ? $m[3] : $m[4];
            }

            if (count($parts) != count($data)) return false;

            if (sprintf('%x', crc32($data['realm'])) != $data['opaque']) return false;

            $username = $data['username'];

            Yii::import('api.extensions.HttpAuth.models.HttpUser');
            $httpUser = HttpUser::model()->findByAttributes(array('username'=>$username));


            if ($httpUser === false) return false;

            if (is_null($httpUser)) return false;
            $password = $httpUser->password;

            $h1 = md5($username . ':' . $data['realm'] . ':' . $password);
            $h2 = md5($_SERVER['REQUEST_METHOD'].':'.$data['uri']);
            $validResponse = md5($h1.':'.$data['nonce'].':'.$data['nc'].':'.$data['cnonce'].':'.$data['qop'].':'.$h2);

            if ($validResponse != $data['response']) return false;

            return $httpUser;
        }

        /**
        * Is an IP matches a rule?
        * 
        * @param string $ip ip
        * @param string $rule rule in wildcard formation
        * 
        * @return boolean
        */
        protected function ipMatchesRule($ip, $rule)
        {
            $rule = trim($rule, " \r\n\t");

            $rule = preg_quote($rule, '.:/');

            $rule = str_replace('\*', '.*', $rule);
            $rule = str_replace('\?', '.', $rule);

            $rule = '|^'.$rule.'$|s';

            return preg_match($rule, $ip);
        }

        protected function verifyIP()
        {
            $clientIp = isset($_SERVER["HTTP_X_FORWARDED_FOR"]) ? $_SERVER["HTTP_X_FORWARDED_FOR"] :
            (
                isset($_SERVER["REMOTE_ADDR"]) ? $_SERVER["REMOTE_ADDR"] :
                (
                    isset($_SERVER["HTTP_CLIENT_IP"]) ? $_SERVER["HTTP_CLIENT_IP"] : '127.0.0.1'
                )
            );

            $httpUser = $this->currentUser;			
            if (!$httpUser) return $this->loginRequired();

            $whiteIps = explode("\n", $httpUser->white_ips);
            $blackIps = explode("\n", $httpUser->black_ips);

            $blocked = false;
            foreach ($blackIps as $rule) {
                if ($blocked) break;
                if ($this->ipMatchesRule($clientIp, $rule)) $blocked = true;
            }		

            if ($blocked){
                header('HTTP/1.1 403 ForBidden');
                echo 'You came from a disallowed IP';
                Yii::app()->end();
            } 	

            foreach ($whiteIps as $rule){
                if ($this->ipMatchesRule($clientIp, $rule)) break;
            }
        }

        /**
        * Xác thực người dùng
        * 
        */
        function login()
        {
            if (!isset($_SERVER['PHP_AUTH_DIGEST']) || empty($_SERVER['PHP_AUTH_DIGEST']))
                return $this->loginRequired();

            if (!$this->_currentUser = $this->verifyDigest())
                return $this->loginRequired(); 

            $this->_username = $this->_currentUser->username;

            $this->verifyIP();

            return true;
        }
}