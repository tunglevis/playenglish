<?php
    // using Yii::app()->params->shop_img['img']
    return array(
        'domain' => 'meonho.net',
        'userRemember' => 3600*24*365,
        'userPhoneEmailExpire' => 3600*24, // Thời gian có thể xác nhận email và phone
        'passwordKey' => '(76@I)',

        'adminEmail'=>'tunglv.1990@gmail.com',

        'user_img' => array(
            'path' => 'upload/user_image/',
            'img' => array(
                '400'       => array('width' => 400, 'height' => 400, 'quality' => 85),
                '200'       => array('width' => 200, 'height' => 200, 'quality' => 80),
                '65'       => array('width' => 65, 'height' => 65, 'quality' => 80),
                '25'       => array('width' => 25, 'height' => 25, 'quality' => 80),
            ),
        ),
        'course' => array(
            'path' => 'upload/course/',
            'img' => array(
                'body' => array('width' => 640, 'height' => 460, 'quality' => 80)
            ),
        ),
        'feed' => array(
            'path' => 'upload/feed/',
            'img' => array(
                'origin' => array('width'=> 960, 'height' => '100%', 'quality' => 100),
                'feed-438' => array('width' => 438, 'height' => '100%', 'quality' => 100)
            ),
        ),
        'message' => array(
            'path' => 'upload/message/',
            'img' => array(
                'origin' => array('width'=> 960, 'height' => '100%', 'quality' => 100),
                'feed-438' => array('width' => 598, 'height' => '100%', 'quality' => 100)
            ),
        ),
        'comment' => array(
            'path' => 'upload/comment/',
            'img' => array(
                'origin' => array('width'=> 960, 'height' => '100%', 'quality' => 100),
                'comment-250' => array('width' => 250, 'height' => '100%', 'quality' => 100)
            ),
        ),
        'message_comment' => array(
            'path' => 'upload/message_comment/',
            'img' => array(
                'origin' => array('width'=> 960, 'height' => '100%', 'quality' => 100),
                'comment-250' => array('width' => 250, 'height' => '100%', 'quality' => 100)
            ),
        ),
        'mail_receiver' => array(
            //'email' => 'noreply@emailnhanh.com',
            'email' => 'noreply@meonho.net',
            'name' => 'Mẹo nhỏ - Noreply',
        ),
        'mail_server' => array(
//            'host'  => 'smtp.gmail.com',
//            'port'  => 587,
//            'port_ssl'  => 465,
//            'username'  => 'free.send.mail.server@gmail.com',
//            'password'  => 'free.send.mail.server',
            
            'host'  => 'bluehealthbook.netfirms.com',
            'port'  => 587,
            //'port_ssl'  => 465,
            'username'  => 'support@meonho.net ',
            'password'  => 'Tunglv_90',
        ),

        'captcha_view'      => array(
            'imageOptions'=>array(
                'alt' => 'Captcha',
                'class' => 'captcha_img',
            ),
            'clickableImage'   => true,
            'buttonType'       => 'link',  // button or link
            'buttonLabel'      => '<i class="icon-refresh"></i> Lấy mã mới',
            'buttonOptions'    => array(
                'title' => 'Lấy mã mới',
                'class' => 'btn btn-small captcha_refresh',
            ),
        ),

        'fb' => array( // tunglv.1990@gmail.com
            'appId' => '175649432610986',
            'secret' => 'f739e06303679f1125da0d17312dd80b',
            'fileUpload' => true,
            'trustForwarded' => false,
        ),   
        'google' => array( // tunglv.1990@gmail.com
            'clientId' => '1026268755724-u9aud8m1lm9ansun5e1ea64ndp7jajil.apps.googleusercontent.com',
            'clientSecret' => 'ijgmguMLUAmkN_HMxN-EQbH9',
        ),
        
        'user' => array(
            'remember' => 3600*24*365,
            'phoneEmailExpire' => 3600*24, // Thời gian có thể xác nhận email và phone
        )
    );
