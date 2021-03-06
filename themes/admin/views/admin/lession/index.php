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
            'name' => 'name',
            'type'      =>  'html',
            'value' => '$data->name',
        ),
        array(
            'name' => 'content',
            'type'      =>  'html',
            'value' => '$data->content',
            'filter' => FALSE
        ),
        array(
            'name' => 'time_start',
            'type'      =>  'html',
            'value' => '$data->time_start',
            'filter' => FALSE
        ),
        array(
            'name' => 'time_end',
            'type'      =>  'html',
            'value' => '$data->time_end',
            'filter' => FALSE
        ),
        array(
            'name' => 'id_course',
            'type'      =>  'raw',
            'value' => 'Course::model()->getCourse($data->id_course)',
            'filter' => Course::model()->getData()
        ),
        array(
            'class'=>'CButtonColumn',
            'template'=>'{update} {delete}',
        ),
    ),
)); ?>    
        