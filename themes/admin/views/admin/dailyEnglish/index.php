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
            'name' => 'feed',
            'type'      =>  'raw',
            'value' => '$data->feed',
        ),
        array(
            'name' => 'id_send',
            'type'      =>  'raw',
            'value' => '$data->id_send'
        ),
        array(
            'name' => 'course_id',
            'type'      =>  'raw',
            'value' => '$data->course_id'
        ),
        array(
            'name' => 'status',
            'type'      =>  'raw',
            'value' => '$data->statusLabel',
            'filter' => $model->statusData
        ),
        array(
            'class'=>'CButtonColumn',
            'template'=>'{update} {delete}',
        ),
    ),
)); ?>    
        