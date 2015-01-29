<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'http-user-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'username'); ?>
		<?php echo $form->textField($model,'username',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'username'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->textField($model,'password',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'password'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'black_ips'); ?>
		<?php echo $form->textArea($model,'black_ips',array('rows'=>5	,'cols'=>32)); ?>
		<p class="hint">Mỗi dòng là 1 pattern, theo regular expression. Có độ ưu tiên cao hơn white list</p> 
		<?php echo $form->error($model,'black_ips'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'white_ips'); ?>
		<?php echo $form->textArea($model,'white_ips',array('rows'=>5	,'cols'=>32)); ?>
		<p class="hint">Mỗi dòng là 1 pattern, theo regular expression.</p> 
		<?php echo $form->error($model,'white_ips'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->