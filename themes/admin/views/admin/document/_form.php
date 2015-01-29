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
<div class="grid_4">       
    <div class="da-panel">
        <div class="da-panel-header">
            <span class="da-panel-title">
                Tài liệu
            </span>
        </div>

        <div id="da-ex-tabs" class="ui-tabs ui-widget ui-widget-content ui-corner-all">
            <?php // $this->renderPartial('_tabs', array('model' => $model))?>
            <div style="padding-bottom: 20px;">

                <?php $this->widget('admin.components.widgets.AlertWidget');?>

                <?php $form=$this->beginWidget('CActiveForm', array(
                        'id'=>'product-form',
                        'enableClientValidation'=>true,
                        'clientOptions'=>array(
                            'validateOnSubmit'=>true,
                        ),
                        //'enableAjaxValidation'=>true,
                        'htmlOptions' => array('class' => 'stdform', 'enctype' => 'multipart/form-data')
                    )); ?>
                <h4 class="widgettitle">Nội dung tài liệu</h4>
                <div class="par control-group">
                    <?php echo $form->labelEx($model,'title', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model,'title',array('maxlength'=>64, 'class' => 'input-large')); ?>
                        <?php echo $form->error($model,'title', array('class' => 'help-inline error'));?>
<!--                        --><?php //echo $form->textField($model,'alias',array('maxlength'=>250, 'class' => 'input-large', 'placeholder' => 'Url Post Name')); ?>
                    </div>
                    <small class="desc">Name should be 50-64 chars <span id="name_char_count"></span></small>
                </div>

                <div class="par control-group">
                    <?php echo $form->labelEx($model,'course_id', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($model,'course_id', Course::model()->getData()); ?>
                        <?php echo $form->error($model,'course_id', array('class' => 'help-inline error'));?>
                    </div>
                </div>

                <label for="video_file">Filename:</label>
                <input type="file" name="video_file" id="video_file"><br>
                <?php if($this->action->id == 'update'):?>
                    <?php echo $model->link?>
                <?php endif;?>
                <?php echo $form->error($model,'link', array('class' => 'help-inline error'));?>

                <div class="par control-group">
                    <?php echo $form->labelEx($model,'desc', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textArea($model,'desc',array('maxlength'=> 255, 'style' => 'height: 80px;width: 625px;', 'class' => 'input-large')); ?>
                        <?php echo $form->error($model,'desc', array('class' => 'help-inline error'));?>
                    </div>
                    <small class="desc">Description should be 130-255 chars <span id="desc_char_count"></span></small>
                </div>


                <p class="stdformbutton">
                    <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'btn btn-info')); ?>
                </p>
                <?php $this->endWidget(); ?>
            </div>
        </div>
</div>
<script>
    $("#Document_catagory_parent").change(function(){
        var value = $("#Document_catagory_parent").val();
        $.post( "getCatagory", { id: value } )
            .done(function( data ) {
                var html = '';
                $.each(jQuery.parseJSON(data), function( index, value ) {
                    html += '<option value="'+index+'">'+value+'</option>';
                });

                $('#Document_catagory_id').html(html);
            });
    })
    $("#Document_name").keyup(function(){
        $('#name_char_count').text($(this).val().length);
    }).keyup();
</script>
