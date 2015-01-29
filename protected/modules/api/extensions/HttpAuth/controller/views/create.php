<?php
$this->breadcrumbs=array(
	'Http Users'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Manage HttpUser', 'url'=>array('admin')),
);
?>

<h1>Create HttpUser</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>