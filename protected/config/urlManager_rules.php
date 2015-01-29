<?php  
$array_base = array(
//    'http://<sub:\w+>.anuong.dev' => '/site/page',  
    'http://<sub:\w+>.anuong.dev<any:.*>' => '/site<any>',
    'http://<sub:\w+>.anuong.hehe.vn<any:.*>' => '/site<any>',
    
    '/<module:(admin|gii)>' => '/<module>',

    '/<city_alias:[\w\-]+>' => '/web/page/index',

    //course
    '/khoa-hoc/<name:[\w\-]+>-<id:\d+>' => '/web/course',
    // user
    '/tai-khoan/dang-nhap' => '/web/user/login',
    '/tai-khoan/cap-nhap-tai-khoan' => '/web/user/update',
    '/tai-khoan/thay-doi-mat-khau' => '/web/user/password',
    '/thanh-vien/<user_name:[\w\-]+>-<id:\d+>' => '/web/user'
);
//$array_domain = require(dirname(__FILE__).'/domain.php');
//$array_base = array_merge($array_domain, $array_base);

return $array_base;