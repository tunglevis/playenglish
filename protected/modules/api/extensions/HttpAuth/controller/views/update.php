<?php
$this->breadcrumbs=array(
	'Http Users'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'Create HttpUser', 'url'=>array('create')),
	array('label'=>'View HttpUser', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage HttpUser', 'url'=>array('admin')),
);
?>

<h1>Update HttpUser <?php echo $model->username; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>