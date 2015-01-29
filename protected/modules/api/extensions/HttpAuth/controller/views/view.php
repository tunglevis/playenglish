<?php
$this->breadcrumbs=array(
	'Http Users'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'Create HttpUser', 'url'=>array('create')),
	array('label'=>'Update HttpUser', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete HttpUser', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage HttpUser', 'url'=>array('admin')),
);
?>

<h1>View HttpUser #<?php echo $model->username; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'username',
		'password',
		array(
			'name'=>'black_ips',
			'type'=>'raw',
			'value'=>"<pre>".$model->black_ips."</pre>",
		),
		array(
			'name'=>'white_ips',
			'type'=>'raw',
			'value'=>"<pre>".$model->white_ips."</pre>",
		),
		'password',
		'create_time',
	),
)); ?>
