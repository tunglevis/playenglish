<div class="container" id="user-main">

<script language="javascript" src="<?php echo Yii::app()->baseUrl?>/themes/web/files/js/jquery.autosize.min.js"></script>
<script language="javascript" src="<?php echo Yii::app()->baseUrl?>/themes/web/files/js/jquery.slimscroll.min.js"></script>
<div id="slider">
    <div class="container clearfix">

        <!--    --><?php //if($array_meohay['meohay']) :?>
        <div class="sixteen columns">
            <div class="flex-container">
                <div class="flexslider">
                    <ul class="slides">
                        <!--                        --><?php //foreach($array_meohay['meohay'] as $meohay) :?>
                        <li style="width: 100%; float: left; margin-right: -100%; display: none;">
                            <a href=""><img src="<?php echo Yii::app()->baseUrl?>/themes/web/files/images/interactive_background.jpg" alt=""></a>
                            <p class="flex-caption"> <span style="font-size: 16px">Học rất nhanh và hay</p>
                        </li>
                        <!--                        --><?php //endforeach;?>
                        <li style="width: 100%; float: left; margin-right: -100%; display: none;">
                            <a href=""><img src="<?php echo Yii::app()->baseUrl?>/themes/web/files/images/parallax_background.jpg" alt=""></a>
                            <p class="flex-caption"> <span style="font-size: 16px">Nói tiếng anh như gió</p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!--    --><?php //endif;?>

    </div><!-- End Container -->
</div><!-- End Slider -->

<div class="container clearfix" style="padding-top: 20px;">
<!--    left box-->
<div class="one-third column">
    <div class="left-box">
        <span style="display: block;clear: both"><i class="icon-document" style="margin-right: 5px;height: 28px;width: 28px;display: inline-block;float: left;background-size: 100%;background-image: url(<?php echo Yii::app()->baseUrl?>/themes/web/files/images/icons/pen-32.png)"></i><a style="font-size: 13px;" href="<?php echo $this->createUrl('/web/user/update')?>">Cập nhập tài khoản</a></span>
        <span style="display: block;clear: both;margin: 20px 0;border-top: 1px dotted #dfdfdf;padding-top: 8px;"><i class="icon-document" style="margin-right: 5px;height: 28px;width: 28px;display: inline-block;float: left;background-size: 100%;background-image: url(<?php echo Yii::app()->baseUrl?>/themes/web/files/images/icons/lock-32.png)"></i><a style="font-size: 13px;" href="<?php echo $this->createUrl('/web/user/password')?>">Thay đổi mật khẩu</a></span>
    </div>
</div>
<!--    center box-->
<div class="two-thirds column">
    <div class="span23 user-update">
        <h4 class="title" style="padding-top: 0;line-height: 25px">Thay đổi mật khẩu<span class="line"></span></h4>
        <?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>'password-form',
            'enableClientValidation'=>true,
            'clientOptions'=>array(
                'validateOnSubmit' => true,
                'validateOnChange' => true,
            ),
            'enableAjaxValidation'=>false,
            'htmlOptions' => array()
        )); ?>


        <?php if($this->user->password):?>
            <div class="control-group">
                <?php echo $form->labelEx($model,'oldPassword', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->passwordField($model,'oldPassword',array('autocomplete'=>'off','maxlength'=>255)); ?>
                    <?php echo $form->error($model,'oldPassword');?>
                </div>
            </div>
        <?php endif?>

        <div class="control-group">
            <?php echo $form->labelEx($model,'newPassword', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->passwordField($model,'newPassword',array('autocomplete'=>'off','maxlength'=>255)); ?>
                <?php echo $form->error($model,'newPassword');?>
            </div>
        </div>

        <div class="control-group">
            <?php echo $form->labelEx($model,'reNewPassword', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->passwordField($model,'reNewPassword',array('autocomplete'=>'off','maxlength'=>255)); ?>
                <?php echo $form->error($model,'reNewPassword');?>
            </div>
        </div>
        <div class="control-group">
            <div class="controls">
                <button style="width: 100px;margin-left: 120%" type="submit" class="btn btn-primary"><i class="icon-ok"></i>
                    <?php echo $passwordActionName?>
                </button>
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>
</div><!-- <<< End Container >>> -->
<style>
    a{
        cursor: pointer;
    }
    .control-label{
        display: inline-block;
        width: 25%;
    }
    .controls{
        display: inline-block;
        width: 50%;
    }
    .controls input{
        width: 100%;
    }
    .control-group {
        clear: both;
        margin: 20px 0;
    }
    .span23.user-update{
        padding: 0 20px;
    }
    #password-form{
        font-size: 13px;
    }
    #password-form input, #password-form select, #password-form button{
        padding: 5px;
        border-radius: 8px;
        box-shadow: none;
        border: 1px solid #ececec;
        cursor: pointer;
    }
</style>
<!--    form-->
</div>

