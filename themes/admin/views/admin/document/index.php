<style>
    .ui-helper-hidden-accessible {
        display: none;
    }
</style>
<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'event-grid',
    'dataProvider'=>$dataProvider,
    'filter'=>$model,
    'ajaxUpdate'=> true,
    'template' => "{items} {pager}",
    'itemsCssClass' => 'table table-striped table-bordered',
    'pagerCssClass' => 'pagination pagination-centered',
    'pager'=>array(
        'class'=>'CLinkPager',
        'htmlOptions' => array(
            'class' => '',
        ),
        'hiddenPageCssClass' => 'disabled',
        'selectedPageCssClass' => 'active',
        'maxButtonCount'    =>  8,
        'header'            => FALSE,

    ),
    'loadingCssClass' => '',
    'beforeAjaxUpdate'=>'function(id,options){
        $("#ajax-loading").fadeIn();    
    }',
    'afterAjaxUpdate'=>'function(id,options){
        $("#ajax-loading").fadeOut();    
    }',
    'columns'=>array(
        array(
            'name' => 'id',
            'type'      =>  'html',
            'value' => '$data->id',
            'headerHtmlOptions' => array('style' => 'width: 10px'),
            'filter' => FALSE
        ),
        array(
            'name' => 'title',
            'type'      =>  'html',
            'value' => '$data->title',
        ),
        array(
            'name' => 'link',
            'type'      =>  'html',
            'value' => 'CHtml::link("Link tài liệu", Yii::app()->createUrl("/upload/document/{$data->id}/{$data->link}"))',
            'filter' => FALSE
        ),
        array(
            'name' => 'desc',
            'type'      =>  'html',
            'value' => '$data->desc',
            'filter' => FALSE
        ),
        array(
            'name' => 'course_id',
            'type'      =>  'raw',
            'value' => 'Course::model()->getCourse($data->course_id)',
            'filter' => Course::model()->getData()
        ),
        array(
            'class'=>'CButtonColumn',
            'template'=>'{update} {delete}',
        ),
    ),
)); ?>    