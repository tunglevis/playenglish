<?php
    class UserIdentity extends CUserIdentity
    {
        public function authenticate()
        {
            return true;
        }
}