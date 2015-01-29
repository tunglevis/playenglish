<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html class="csstransforms no-csstransforms3d csstransitions js js" lang="en"><!--<![endif]--><head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">

        <!-- Basic Page Needs -->
        <meta charset="utf-8">
        <title><?php echo $this->title ? $this->title : 'Mẹo nhỏ | cuộc sống tươi đẹp'?></title>
        <meta name="description" content="<?php echo $this->desc ? $this->desc : 'mẹo nhỏ, mẹo vặt, mẹo hay, mẹo vui, gia đình, làm đẹp, nấu ăn, phong cách, chăm con, du lịch, địa điểm'?>">
        <meta name="author" content="">

        <!-- Mobile Specific Metas -->
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

        <!-- CSS Style -->
        <link rel="stylesheet" href="<?php echo Yii::app()->baseUrl?>/themes/web/files/css/style.css"> 

        <!-- Color Skins -->
        <link rel="stylesheet" href="<?php echo Yii::app()->baseUrl?>/themes/web/files/css/blue.css" name="skins"> 

        <!-- Layout Style -->
        <link rel="stylesheet" href="<?php echo Yii::app()->baseUrl?>/themes/web/files/css/wide.css" name="layout"> 

        <!-- Small Icons -->
        <link rel="stylesheet" href="<?php echo Yii::app()->baseUrl?>/themes/web/files/css/icons.css">

        <!-- Favicons -->
        <link rel="shortcut icon" href="<?php echo Yii::app()->baseUrl?>/themes/web/files/images/gadu.png">
        <link rel="apple-touch-icon" href="http://themes.jozoor.com/crevision/white/images/favicon/apple-touch-icon.png">
        <link rel="apple-touch-icon" sizes="72x72" href="http://themes.jozoor.com/crevision/white/images/favicon/apple-touch-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="114x114" href="http://themes.jozoor.com/crevision/white/images/favicon/apple-touch-icon-114x114.png">
        <style>
            .contact-us span, .guide-post span, .detail-price li {
                border-bottom: 1px dotted;
                display: list-item;
                line-height: 25px;
                margin-left: 12px;
            }
            .txtwhite {
                color: #E8E8E8;
            }
            .recent-work.gallery li.slide div.item:last-child {
                margin-right: 0;
                margin-left: 0;
            }
            .right-box {
                padding: 0 10px 10px;
                background-color: #FFF;
            }
            .detail-price {
                padding-left: 60px;
            }
            .detail-price span.price {
                float: right;
                font-weight: bold;
            }
        </style>
    </head>
    <body class="wood">

        <div id="wrap" class="boxed">
            <?php $this->renderPartial('//common/header'); ?>
            <?php echo $content ?>
            <?php $this->renderPartial('//common/footer'); ?>
        </div><!-- End wrap -->

        <!-- Start JavaScript -->
        <?php Yii::app()->clientScript->registerCoreScript('jquery.ui');?>
        <script src="<?php echo Yii::app()->baseUrl?>/themes/web/files/js/jquery_003.js"></script> <!-- jQuery Easing -->
        <script src="<?php echo Yii::app()->baseUrl?>/themes/web/files/js/jquery-ui.js"></script> <!-- jQuery Ui -->
        <script src="<?php echo Yii::app()->baseUrl?>/themes/web/files/js/jquery_010.js"></script> <!-- jQuery cookie -->
        <script src="<?php echo Yii::app()->baseUrl?>/themes/web/files/js/jquery_007.js"></script> <!-- jQuery Uniform -->
        <script src="<?php echo Yii::app()->baseUrl?>/themes/web/files/js/ddsmoothmenu.js"></script> <!-- Nav Menu ddsmoothmenu -->
        <script src="<?php echo Yii::app()->baseUrl?>/themes/web/files/js/jquery_005.js"></script> <!-- Flex Slider  -->
        <script src="<?php echo Yii::app()->baseUrl?>/themes/web/files/js/jquery.js"></script> <!-- Elastic Slider  -->
        <script src="<?php echo Yii::app()->baseUrl?>/themes/web/files/js/jquery_006.js"></script> <!-- Sliding Text and Icon Menu Style  -->
        <script src="<?php echo Yii::app()->baseUrl?>/themes/web/files/js/colortip.js"></script> <!-- Colortip Tooltip Plugin  -->
        <script src="<?php echo Yii::app()->baseUrl?>/themes/web/files/js/tytabs.js"></script> <!-- jQuery Plugin tytabs  -->
        <script src="<?php echo Yii::app()->baseUrl?>/themes/web/files/js/carousel.js"></script> <!-- jQuery Carousel  -->
        <script src="<?php echo Yii::app()->baseUrl?>/themes/web/files/js/jquery_008.js"></script> <!-- jQuery Prettyphoto  -->
        <script src="<?php echo Yii::app()->baseUrl?>/themes/web/files/js/jquery_002.js"></script> <!-- Isotope Filtering  -->
        <script src="<?php echo Yii::app()->baseUrl?>/themes/web/files/js/selectnav.js"></script> <!-- Responsive Navigation Menu by SelectNav -->
        <script src="<?php echo Yii::app()->baseUrl?>/themes/web/files/js/jquery_004.js"></script> <!-- UItoTop plugin  -->
        <script src="<?php echo Yii::app()->baseUrl?>/themes/web/files/js/custom.js"></script> <!-- Custom Js file for javascript in html -->
        <script src="<?php echo Yii::app()->baseUrl?>/files/js/openidPopup.js"></script> <!-- Custom Js file for javascript in html -->

        <!-- End JavaScript -->

        <!--[if lt IE 9]>
        <script src="js/html5.js"></script>
        <![endif]-->

    </body>
</html>