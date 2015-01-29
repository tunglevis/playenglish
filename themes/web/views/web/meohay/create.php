<script type="text/javascript" src="/files/editors/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="/files/editors/tiny_mce/editor_admin.js"></script>
<script type="text/javascript" src="/files/js/relCopy.jquery.js"></script>
<style>
    .checkbocklist {
        width:100px;
        float:left;
        overflow:hidden;
    }
    .checkbocklist label{
        width: 50px;
    }
    label.required {
        float:left;
    }
    .ui-datepicker {
        width: 232px;
    }
    .upload_method{
        cursor: pointer;
    }
    .upload_method.selected{
        text-decoration: underline;
        font-weight: bold;
    }
    #img_file {
        margin-top: 5px;
    }
    #image_file, #image_url, #img_file, #img_url{
        margin-left: 220px;
    }
    #image_file, #image_url{
        display: none;
    }

</style>
<div class="container clearfix">       
    <div class="da-panel">
        <div id="da-ex-tabs" class="ui-tabs ui-widget ui-widget-content ui-corner-all">
            <?php // $this->renderPartial('_tabs', array('model' => $model))?>
            <div style="padding-bottom: 20px;">

                <?php $this->widget('admin.components.widgets.AlertWidget'); ?>

                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'meohay-form',
                    'enableClientValidation' => true,
                    'clientOptions' => array(
                        'validateOnSubmit' => true,
                    ),
                    //'enableAjaxValidation'=>true,
                    'htmlOptions' => array('class' => 'stdform', 'enctype' => 'multipart/form-data')
                        ));
                ?>
                <h4 class="widgettitle">Nội dung mẹo hay</h4>
                    <?php if (Yii::app()->controller->action->id != 'note') : ?>
                    <div class="par control-group">
                            <?php echo $form->labelEx($model, 'title', array('class' => 'control-label')); ?>
                        <div class="controls">
                        <?php echo $form->textField($model, 'title', array('maxlength' => 64, 'class' => 'input-large')); ?>
                        <?php echo $form->error($model, 'title', array('class' => 'help-inline error')); ?>
                        </div>
                    </div>
                    <div class="par control-group">
                            <?php echo $form->labelEx($model, 'type', array('class' => 'control-label')); ?>
                        <div class="controls">
                        <?php echo $form->dropDownList($model, 'type', Meohay::model()->getTypeData()); ?>
                        <?php echo $form->error($model, 'type', array('class' => 'help-inline error')); ?>
                        </div>
                    </div>
                    <script>
                        $(function(){
                            $("#a_url").click(function(){
                                $('#a_file').removeClass('selected');    
                                $('#a_url').addClass('selected');    
                                $('#image_url').show();    
                                $('#image_file').hide();
                                $("#img_url").show();
                                $('#img_file').hide();
                                $('#Meohay_upload_method').val('url');    
                            });
                            $("#a_file").click(function(){
                                $('#a_url').removeClass('selected');    
                                $('#a_file').addClass('selected');    
                                $('#image_file').show();    
                                $('#image_url').hide();
                                $("#img_url").hide();
                                $('#img_file').show();
                                $('#Meohay_upload_method').val('file');    
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

                            $("#Meohay_image_url").bind('change keyup blur', function(evt){
                                var method = $('#Meohay_upload_method').val();
                                var ext = $(this).val().split('.').pop().toLowerCase(); 
                                if(method == 'url' && $.inArray(ext, [ 'jpg', 'gif', 'png' ] >= 0)){
                                    $('#img_file').hide();
                                    $('#img_url').attr('src', $(this).val()).show();
                                    $('#img_review').show(); 
                                } 
                            });

                                <?php if ($model->upload_method == 'file'): ?>
                                        $('#image_file').show();    
                                        $('#image_url').hide(); 
                                        $('#a_file').addClass('selected'); 
                                <?php else: ?>
                                            $('#image_url').show();    
                                            $('#image_file').hide();
                                            $('#a_url').addClass('selected');
                                <?php if ($model->image_url): ?>
                                                $('#img_url').attr('src', '<?php echo $model->image_url ?>').show();
                                <?php endif ?> 
                            <?php endif ?>
                                });
                    </script>
                    <div class="par control-group">
                        <label>Cover Image <span class="required">*</span> </label>
                        <div class="controls">
                            <div style="float: left;">
                                <a id="a_file" class="upload_method">Từ máy tính</a> &nbsp;|&nbsp; 
                                <a id="a_url" class="upload_method">Từ URL</a>
                            <?php echo $form->hiddenField($model, 'upload_method'); ?>
                            </div> 
                            <div style="clear: both;"></div>

                            <div id="image_file">
                                <?php echo $form->fileField($model, 'image_file', array('class' => 'da-custom-file', 'name' => 'browse_file')); ?>
                            </div>
                            <div id="image_url">
                            <?php echo $form->textField($model, 'image_url', array('placeholder' => 'http://domain.com/path/image.jpg')); ?>
                            </div>
                            <?php echo $form->error($model, 'image_file'); ?>
                            <?php echo $form->error($model, 'upload_method'); ?>
                        </div>
                        <div class="controls">
                            <?php if ($this->action->id == 'update'): ?>
                                <img id="img_file" style="display: none; height: 60px; width: auto; margin-left: 220px;" /> 
                                <img id="img_url" style="height: 60px; width: auto; margin-left: 220px;" src="<?php echo Meohay::model()->getImageUrl($model->id, '160'); ?>"/>
                                <!--<img style="height: 60px; width: auto;margin-left: 220px;" src="<?php // echo Meohay::model()->getImgUrl($model->id, $model->image.'_small.jpg'); ?>" />-->
                            <?php else: ?> 
                                <img id="img_file" style="display: none; height: 60px; width: auto; margin-left: 220px;" /> 
                                <img id="img_url" style="display: none; height: 60px; width: auto; margin-left: 220px;" />
                            <?php endif ?> 
                        </div>
                    </div>
                    <div class="par control-group">
                            <?php echo $form->labelEx($model, 'desc', array('class' => 'control-label')); ?>
                        <div class="controls">
                        <?php echo $form->textArea($model, 'desc', array('maxlength' => 160, 'style' => 'height: 80px;width: 625px;', 'class' => 'input-large')); ?>
                        <?php echo $form->error($model, 'desc', array('class' => 'help-inline error')); ?>
                        </div>
                        <small class="desc">Description should be 130-160 chars <span id="desc_char_count"></span></small>
                    </div>
                    <div class="has-step">
                    <?php if(!($model->isNewRecord)):?>
                        <ul>
                        <?php foreach ($model->stepCreateContents as $key => $value) : ?>
                            <li>
                                <a href="<?php echo $value->getUrlUpdate(true)?>"><img src="<?php echo $value->getImageUrl()?>"></a>
                                <a href="<?php echo $value->getUrlUpdate(true)?>">Bước :<?php echo $value->step?></a>
                                <a href="<?php echo $value->getUrlUpdate(true)?>"><strong><?php echo $value->desc?></strong></a>
                            </li>
                        <?php endforeach;?>
                        </ul>
                    <?php endif;?>
                </div>
                    <?php endif; ?>
                    <?php if (!$model->isNewRecord) : ?>
                    <div class="par control-group">
                            <?php echo $form->labelEx($model, 'tip', array('class' => 'control-label')); ?>
                        <div class="controls">
                        <?php echo $form->textArea($model, 'tip', array('maxlength' => 500, 'style' => 'height: 80px;width: 625px;', 'class' => 'input-large')); ?>
                        <?php echo $form->error($model, 'tip', array('class' => 'help-inline error')); ?>
                        </div>
                        <small class="desc">Tip should be 130-500 chars <span id="desc_char_count"></span></small>
                    </div>
                    <div class="par control-group">
                            <?php echo $form->labelEx($model, 'note', array('class' => 'control-label')); ?>
                        <div class="controls">
                        <?php echo $form->textArea($model, 'note', array('maxlength' => 500, 'style' => 'height: 80px;width: 625px;', 'class' => 'input-large')); ?>
                        <?php echo $form->error($model, 'note', array('class' => 'help-inline error')); ?>
                        </div>
                        <small class="desc">Note should be 130-500 chars <span id="desc_char_count"></span></small>
                    </div>
                    <?php endif; ?>
                <p class="stdformbutton">
                <?php echo CHtml::submitButton($model->isNewRecord ? 'Bước tiếp' : 'Hoàn thành', array('class' => 'btn btn-info')); ?>
                </p>
                <?php $this->endWidget(); ?>
            </div>
        </div>
    </div>
    <?php
    /*
     * To change this template, choose Tools | Templates
     * and open the template in the editor.
     */
    ?>
