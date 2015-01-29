<script type="text/javascript" src="/files/editors/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="/files/editors/tiny_mce/editor_admin.js"></script>
<script type="text/javascript" src="/files/js/relCopy.jquery.js"></script>
<link rel="stylesheet" media="all" type="text/css" href="/files/js/jquery.timepicker/jquery-ui-timepicker-addon.css" />
<script type="text/javascript" src="/files/js/jquery.timepicker/jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript" src="/files/js/jquery.timepicker/localization/jquery-ui-timepicker-vi.js"></script>
<script type="text/javascript" src="/files/js/jquery.timepicker/jquery-ui-sliderAccess.js"></script>
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
                <h4 class="widgettitle">Nội dung lession</h4>
                <div class="par control-group">
                    <?php echo $form->labelEx($model,'name', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model,'name',array('maxlength'=>255, 'class' => 'input-large')); ?>
                        <?php echo $form->error($model,'name', array('class' => 'help-inline error'));?>
                    </div>
                </div>

                <div class="par control-group">
                    <label class="control-label required">Thời gian lession<span class="required">*</span> </label>
                    <div class="controls" style="display: inline-block">
<!--                        <span style="float:left;line-height: 32px;">Từ ngày</span>-->
                        <div id="datetimepicker1" class="input-append date">
                            <?php echo $form->textField($model, 'time_start',array('maxlength'=>64, 'class' => 'input-large', 'data-format'=>'yyyy-MM-dd hh:mm:ss')); ?>
                            <?php echo $form->error($model, 'time_start', array('class' => 'help-inline error'));?>
                        </div>
<!--                        <span style="float:left;line-height: 32px;">đến&nbsp;&nbsp;</span>-->
<!--                        <div id="datetimepicker2" class="input-append date">-->
<!--                            --><?php //echo $form->textField($model, 'time_end',array('maxlength'=>64, 'class' => 'input-large', 'data-format'=>'yyyy-MM-dd hh:mm:ss')); ?>
<!--                            --><?php //echo $form->error($model, 'time_end', array('class' => 'help-inline error'));?>
<!--                        </div>-->
                    </div>
                </div>

                <div class="par control-group">
                    <?php echo $form->labelEx($model,'content', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textArea($model,'content',array('maxlength'=> 1000, 'style' => 'height: 80px;width: 625px;', 'class' => 'input-large')); ?>
                        <?php echo $form->error($model,'content', array('class' => 'help-inline error'));?>
                    </div>
                 </div>

                <div class="par control-group">
                    <?php echo $form->labelEx($model,'id_course', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($model,'id_course', Course::model()->getData()); ?>
                        <?php echo $form->error($model,'id_course', array('class' => 'help-inline error'));?>
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
        $(function(){
            $('#Lession_time_start').datetimepicker({});
        })
    </script>
