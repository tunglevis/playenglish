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
            <h4 class="title" style="padding-top: 0;line-height: 25px">Cập nhập tài khoản<span class="line"></span></h4>
<!--            <div class="nav clearfix nav-tabs user-nav-tab">-->
<!--                --><?php //$this->renderPartial('_tabs')?>
<!--            </div>-->
            <?php $form=$this->beginWidget('CActiveForm', array(
                'id'=>'user-form',
                'enableClientValidation'=>true,
                'clientOptions'=>array(
                    'validateOnSubmit' => true,
                    'validateOnChange' => true,
                ),
                'enableAjaxValidation'=>true,
                'htmlOptions' => array('class' => 'form-horizontal', 'enctype'=>"multipart/form-data")
            )); ?>

            <div class="control-group">
                <?php echo $form->labelEx($model,'name', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
                    <?php echo $form->error($model,'name');?>
                </div>
            </div>


            <style>
                .upload_method{
                    cursor: pointer;
                }
                .upload_method.selected{
                    text-decoration: underline;
                    font-weight: bold;
                }
                #image_file, #image_url{
                    display: none;
                }
            </style>
            <script>
                $(function(){

                    $("#a_url").click(function(){
                        $('#a_file').removeClass('selected');
                        $('#a_url').addClass('selected');
                        $('#image_url').show();

                        if($('#img_url').attr('src')){
                            $('#img_url').show();
                        }

                        $('#image_file, #img_file').hide();
                        $('#User_upload_method').val('url');
                    });

                    $("#a_file").click(function(){
                        $('#a_url').removeClass('selected');
                        $('#a_file').addClass('selected');
                        $('#image_file').show();

                        if($('#img_file').attr('src')){
                            $('#img_file').show();
                        }

                        $('#image_url, #img_url').hide();
                        $('#User_upload_method').val('file');
                    });


                    $("#browse_file").change(function(evt){
                        var files = evt.target.files;
                        var f = files[0];

                        if(!f.type.match('image.*')) {
                            alert('File không hợp lệ. Hãy chọn 1 file ảnh khác.');
                            return false;
                        }

                        var i = document.createElement('input');
                        if('multiple' in i){
                            var reader = new FileReader();
                            reader.readAsDataURL(f);
                            reader.onload = (function(){
                                return function(e){
                                    $('#img_url').hide();
                                    $('#img_file').attr('src', e.target.result).show();
                                };
                            })(f);
                            $('#img_review').show();
                        }
                    });

                    $("#User_image_url").bind('change keyup blur', function(evt){
                        var method = $('#User_upload_method').val();
                        var ext = $(this).val().split('.').pop().toLowerCase();
                        console.log(ext);
                        if(method == 'url' && $.inArray(ext, [ 'jpg', 'gif', 'png' ] >= 0)){
                            $('#img_file').hide();
                            $('#img_url').attr('src', $(this).val()).show();
                            $('#img_review').show();
                        }
                    });

                    <?php if($model->upload_method == 'file'):?>
                    $('#image_file').show();
                    $('#image_url').hide();
                    $('#a_file').addClass('selected');
                    <?php else:?>
                    $('#image_url').show();
                    $('#image_file').hide();
                    $('#a_url').addClass('selected');
                    <?php if($model->image_url):?>
                    $('#img_url').attr('src', '<?php echo $model->image_url?>').show();
                    <?php endif?>
                    <?php endif?>
                });
            </script>
            <div class="da-form-row control-group user-img-upload">
                <div class="da-form-col-4-8">
                    <label class="control-label">Avatar <span class="required">*</span> </label>

                    <div class="da-form-item controls large">
                        <div style="float: left;">
                            <a id="a_file" class="upload_method">From computer</a> &nbsp;|&nbsp;
                            <a id="a_url" class="upload_method">From URL</a>
                            <?php echo $form->hiddenField($model,'upload_method'); ?>
                        </div>
                        <div style="clear: both;"></div>

                        <div id="image_file">
                            <?php echo $form->fileField($model,'image_file', array('class' => 'da-custom-file', 'name' => 'browse_file')); ?>
                        </div>
                        <div id="image_url">
                            <?php echo $form->textField($model,'image_url', array('placeholder' => 'http://domain.com/path/image.jpg')); ?>
                        </div>
                        <?php echo $form->error($model,'image_file');?>
                        <?php echo $form->error($model,'upload_method');?>
                    </div>
                </div>
                <div class="da-form-col-3-8">
                    <div class="da-form-item large" id="div_image_preview">
                        <img id="img_file" style="display: none; height: 50px; width: auto;" />
                        <?php if($model->image):?>
                            <img id="img_url" style="height: 50px; width: auto;" src="<?php echo $model->avatarUrl.'?'.uniqid()?>" />
                        <?php else:?>
                            <img id="img_url" style="display: none; height: 50px; width: auto;" />
                        <?php endif;?>
                    </div>
                </div>
            </div>

            <div class="control-group">
                <?php echo $form->labelEx($model,'address', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($model,'address',array('size'=>60,'maxlength'=>255)); ?>
                    <?php echo $form->error($model,'address');?>
                    <div id="address_full"></div>
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->labelEx($model,'dob', array('class' => 'control-label')); ?>
                <div class="controls">

                    <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                        //'name'=>'User[dob]',
                        'attribute'=>'dob',
                        'model'=>$model,
                        'value' => $model->dob,
                        'language'=>'vi',
                        'options'=>array(
                            'showAnim'=>'fold',
                            'dateFormat'=>'dd-mm-yy',
                            'changeMonth' => 'true',
                            'changeYear' => 'true',
                            'yearRange' => '-90:-10',
                            'defaultDate' => '01-01-1985'
                        ),
                        'htmlOptions'=>array(
                            'style'=>'height:20px;',
                        ),
                    ));?>
                    <?php echo $form->error($model,'dob');?>
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->labelEx($model,'gender', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->dropDownList($model,'gender', User::model()->genderData); ?>
                    <?php echo $form->error($model,'gender');?>
                </div>
            </div>
            <div class="btn-user-update">
                <button type="submit" class="btn btnmy-large" style="width: 100px;margin-left: 54%"><span>Cập nhật</span></button>
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
        width: 20%;
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
    #user-form{
        font-size: 13px;
    }
    #user-form input, #user-form select, #user-form button{
        padding: 5px;
        border-radius: 8px;
        box-shadow: none;
        border: 1px solid #ececec;
        cursor: pointer;
    }
    #div_image_preview {
        margin-left: 40%;
        margin-top: 15px;
    }
</style>
<!--    form-->
</div>