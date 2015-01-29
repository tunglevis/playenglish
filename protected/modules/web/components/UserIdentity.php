<?php
    class UserIdentity extends CUserIdentity
    {
        public function authenticate()
        {
//            $isEmail = preg_match('{@}', $this->username);
//
//            if($isEmail) $userEmailPhone = UserEmail::model()->findByAttributes(array('email' => $this->username));
//            else         $userEmailPhone = UserPhone::model()->findByAttributes(array('phone' => $this->username));

            $user = User::model()->findByAttributes(array('user_name' => $this->username));

            if(!$user){
                $this->errorMessage='Thông tin đăng nhập không chính xác';
            }else{

                if(!$user->checkPassword($this->password, $user->password))
                {  
                    $this->errorMessage='Thông tin đăng nhập không chính xác';  
                }elseif($user->status == 'DISABLE')
                {
                    $this->errorMessage="Tài khoản {$this->username} đang bị khóa";    
                }else
                {
                    $this->errorCode = self::ERROR_NONE;
                    $this->setState('id', $user->id);
                    $this->setState('name', $user->name);
                }


            }
            return !$this->errorMessage;
        }
}