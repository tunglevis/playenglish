<style>
    .last-child {
        margin-left: 0 !important;
        margin-right: 0 !important;
    }
    .pagination{
        clear: both;
        height: 24px;
    }
    .pagination a:hover{
        color: #000 !important;
        font-weight: bold;
    }
    .pagination li.active{
        color: #000 !important;
        font-weight: bold;
    }
</style>
<div class="container clearfix">
    <div class="two-thirds column">
        <!--catagory makeup-->
        <div class="recent-work gallery clearfix">

            <div role="application" style="overflow: hidden; width: 100.2%;" class="slidewrap">

                <div class="two-thirds column"> <h2 class="title"><?php echo $title_page?> <span class="line"></span></h2> </div>
                        
                    <?php $this->widget('zii.widgets.CListView', array(
                                        'dataProvider'=>$dataProvider,
                                        'itemView'=>'_item_view',
                                        'template'=>'{items}{pager}',
                                        'enableSorting' => true,
                                    
                                        'pagerCssClass' => 'pagination paging pagination-centered',
                                        'pager' => Array(
                                            'id'=>'',
                                            //'class'=>'',
                                            'internalPageCssClass'=>'',
                                            'cssFile'=>'',
                                            'header'=>'',

                                            'hiddenPageCssClass'=>'hidden',
                                            'selectedPageCssClass'=>'active',
                                            'nextPageLabel'=>'Sau',
                                            'prevPageLabel'=>'Trước',
                                            'maxButtonCount'=>5
                                        ),
                                    'emptyText'=>'Hiện chưa có mẹo hay nào, bạn hãy là người đầu tiên tạo mẹo hay trên meonho.net',    
                                )); ?>
                      
            </div><!-- End slidewrap -->

        </div><!-- End makeup -->
      
    </div>

    <!--right page-->
    <?php $this->renderPartial('//common/_right_page',array('new_knowledge'=>$new_knowledge, 'new_today'=>$new_today, 'market_price'=>$market_price)); ?>

    <?php if($viewed_meohay) :?>
    <div class="clients clearfix">
        <div class="sixteen columns"> 
            <h2 class="title">Các mẹo bạn vừa xem <span class="line"></span></h2> 
            <ul class="items">
                <?php foreach ($viewed_meohay as $key => $meohay) :?>
                    <li><a href="<?php echo $meohay['url']?>" title="<?php echo $meohay['title']?>"><img src="<?php echo $meohay['image']['157']?>" alt="<?php echo $meohay['title']?>"></a></li>
                <?php endforeach;?>
            </ul><!-- End items -->
        </div>
    </div><!-- End clients -->
    <?php endif;?>

</div><!-- <<< End Container >>> -->