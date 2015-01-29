<div class="form-login">
    <i class="arrow"></i>
    <div class="fields-login clearfix">
        <!--form login-->
        <?php $form=$this->beginWidget('CActiveForm', array(
                'id'=>'login-form',
                'action'=> Yii::app()->createUrl('/web/user/login'),
                'enableClientValidation'=>true,
                'clientOptions'=>array(
                    'validateOnSubmit' => true,
                    'validateOnChange' => true,
                ),
                'enableAjaxValidation'=>false,
                'htmlOptions' => array()
            )); ?>

        <?php echo $form->textField($model,'username',array('autocomplete'=>'off','maxlength'=>255,'placeholder'=>'User Name')); ?>
        <?php echo $form->error($model,'username');?>
        <?php echo $form->passwordField($model,'password',array('autocomplete'=>'off','maxlength'=>255,'placeholder'=>'Mật khẩu')); ?>
        <?php echo $form->error($model,'password');?>
        <label class="checkbox">
            <input type="checkbox" value="1" name="LoginForm[rememberMe]" checked="checked" id="remember-account"> Nhớ tài khoản
<!--            <a href="--><?php //echo Yii::app()->createUrl('/web/user/forget')?><!--">Quên mật khẩu</a>-->
        </label>
        <button type="submit" class="btn" class="button-login">Đăng nhập</button>
        <?php $this->endWidget(); ?>

        <div class="clearfix"></div>
        <!--end form login-->
    </div>
</div>