<?php
$this->breadcrumbs=array(
	'Http Users'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'Create HttpUser', 'url'=>array('create')),
);

?>

<h1>Manage Http Users</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'http-user-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'username',
		'password',
		array(
			'name'	=>	'black_ips',
			'type'	=>	'raw',
			'value'	=>	'"<pre>".$data->black_ips."</pre>"',
		),
		array(
			'name'	=>	'white_ips',
			'type'	=>	'raw',
			'value'	=>	'"<pre>".$data->white_ips."</pre>"',
		),
		'create_time',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
