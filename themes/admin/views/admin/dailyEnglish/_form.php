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

</style>
<div class="grid_4">       
    <div class="da-panel">
        <div class="da-panel-header">
            <span class="da-panel-title">
                Khóa học
            </span>
        </div>

        <div id="da-ex-tabs" class="ui-tabs ui-widget ui-widget-content ui-corner-all">
            <?php // $this->renderPartial('_tabs', array('model' => $model))?>
            <div style="padding-bottom: 20px;">

                <?php $this->widget('admin.components.widgets.AlertWidget');?>

                <?php $form=$this->beginWidget('CActiveForm', array(
                        'id'=>'knowledge-form',
                        'enableClientValidation'=>true,
                        'clientOptions'=>array(
                            'validateOnSubmit'=>true,
                        ),
                        //'enableAjaxValidation'=>true,
                        'htmlOptions' => array('class' => 'stdform', 'enctype' => 'multipart/form-data')
                    )); ?>
                <h4 class="widgettitle">Nội dung daily english</h4>
                <div class="par control-group">
                    <?php echo $form->labelEx($model,'feed', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model,'feed',array('maxlength'=>1000, 'class' => 'input-large')); ?>
                        <?php echo $form->error($model,'feed', array('class' => 'help-inline error'));?>
                    </div>
                </div>
                
                <div class="par control-group">
                    <?php echo $form->labelEx($model,'status', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($model,'status', DailyEnglish::model()->getStatusData()); ?>
                        <?php echo $form->error($model,'status', array('class' => 'help-inline error'));?>
                    </div>
                </div>

                <div class="par control-group">
                    <?php echo $form->labelEx($model,'course_id', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($model,'course_id', Course::model()->getData()); ?>
                        <?php echo $form->error($model,'course_id', array('class' => 'help-inline error'));?>
                    </div>
                </div>

                <p class="stdformbutton">
                    <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'btn btn-info')); ?>
                </p>
                <?php $this->endWidget(); ?>
            </div>
        </div>
</div>
<script>
    //alias
        <?php if($model->isNewRecord):?>
        $('#NewKnowledge_title').bind('blur keyup', function() {
                $('#NewKnowledge_alias').val($(this).val().toAlias().replaceAll(' ', '-').toLowerCase());
        });
        <?php endif?>


        $("#NewKnowledge_desc").keyup(function(){
                $('#desc_char_count').text($(this).val().length);
        }).keyup();

        $("#NewKnowledge_title").keyup(function(){
                $('#title_char_count').text($(this).val().length);
        }).keyup();
</script>
