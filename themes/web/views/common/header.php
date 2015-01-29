<style>
    @media (max-width:979px){
        #menu #nav{
            display: none !important;
        }
    }
</style>
<header>
    <div class="header" style="display: block;background-color: #00aec8;">
        <div class="container clearfix">
            <nav id="menu" class="navigation">
                <ul id="nav" style="width: 100%;">
                    <li style="z-index: 100;"><a style="font-size: 17px !important;border-bottom: none;padding: 0;border-radius: 0;background-color: transparent;" href="http://meonho.net" <?php if($this->nav_header == 'home'):?>class="active"<?php endif;?>><img src="<?php echo Yii::app()->baseUrl?>/themes/web/files/images/logo_E.png" style="border:0;width: 25px"></a></li>
                    <?php if(Yii::app()->user->isGuest):?>
                        <li style="z-index: 99;float: right;line-height: 30px;position: relative;">
                            <a id="user-login" style="font-size: 14px !important;font-family: initial;">Login</a>
                            <?php $this->widget('web.components.widgets.user.LoginSmall') ?>
                        </li>
                    <?php else:?>
                        <li style="z-index: 99;float: right;line-height: 30px;position: relative;margin-right: 40px;">
                            <a id="user-control" style="font-size: 14px !important;font-family: initial;" href="<?php echo Yii::app()->createUrl('/web/user', array('user_name'=>$this->user->user_name, 'id'=>$this->user->id))?>"><img src="<?php echo User::model()->getAvatarUrl($this->user->id, '25').'?'.uniqid()?>" style="position: absolute;right: -30px;top: 6px;border-radius: 12px;"> <?php echo Yii::app()->user->name?></a>
                            <ul class="sub-menu" style="top: 36px !important; visibility: visible; left: -28px; width: 180px; display: none;background-color: #fff;color: #000;">
                                <li><a href="<?php echo Yii::app()->createUrl('/web/user/update')?>">Edit profile</a></li>
                                <li><a href="<?php echo Yii::app()->createUrl('/web/user/logout')?>">Logout</a></li>
                            </ul>
                        </li>
                        <li style="z-index: 100;float: right;margin-right: 25px;line-height: 30px;position: relative;height: 30px;width: 30px;"><a style="font-size: 17px !important;border-bottom: none;padding: 0;border-radius: 0;background-color: transparent;" href="http://meonho.net" class="active"><img src="/themes/web/files/images/message.png" style="border:0;width: 20px;position: absolute;top: 21%;left: 0;height: 20px;"><span style="position: absolute;top: -5px;right: 0;font-size: 10px;">1</span></a></li>
                        <li style="z-index: 100;float: right;margin-right: 10px;line-height: 30px;position: relative;height: 30px;width: 30px;"><a style="font-size: 17px !important;border-bottom: none;padding: 0;border-radius: 0;background-color: transparent;" href="http://meonho.net" class="active"><img src="/themes/web/files/images/notify.png" style="border:0;width: 20px;position: absolute;top: 21%;left: 0;height: 20px;"><span style="position: absolute;top: -5px;right: 0;font-size: 10px;">1</span></a></li>
                    <?php endif;?>
                </ul>
            </nav>
        </div>
    </div>
</header><!-- <<< End Header >>> -->
<style>
    .form-login{
        display: none;
        position: absolute;
        padding: 10px;
        background-color: #fff;
        left: -10px;
        font-size: 12px;
        border-radius: 8px;
        box-shadow: 1px 1px 10px #000;
    }
    .form-login button.btn{
        font-size: 12px;
        width: 50%;
        margin: 0 auto;
        display: block;
        border-radius: 4px;
    }
    .form-login label.checkbox{
        float: right;
        margin: 10px 0;
    }
    #login-form input{
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 5px 0 5px 5px;
    }
    .navigation ul.sub-menu li a{
        color: #888;
        font-size: 12px !important;
    }
</style>
<script>
    $("#user-login").click(function(){
        $('.form-login').toggle('slow');
    });
</script>