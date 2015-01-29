<style>
    .step-meohay {
        position: absolute; 
        color: rgb(255, 255, 255); 
        background-color: rgba(0, 18, 13, 0.65); 
        padding: 10px; 
        text-shadow: none; 
        border-bottom-right-radius: 10px; 
        font-size: 18px; 
        font-weight: lighter;
    }
    .text-align-left {
        text-align: justify;
        font-size: 14px;
    }
    p {
        text-align: justify;
    }
</style>
<div class="container clearfix">
    <div class="two-thirds column">
        <!--catagory makeup-->
        <div class="recent-work gallery clearfix">

            <div role="application" class="slidewrap">

                <div class="two-thirds column"> <h2 class="title"><?php echo $today['title']?><span class="line"></span></h2> </div>
                <div class="two-thirds column" style="line-height: 25px">
                    <strong><?php echo $today['desc']?></strong><br/><br/>
                    <p><?php echo $today['content']?></p>
                </div>
            </div><!-- End slidewrap -->

        </div><!-- End makeup -->
      
    </div>

    <!--right page-->
    <?php $this->renderPartial('//common/_right_page',array('new_knowledge'=>$new_knowledge, 'new_today'=>array(), 'market_price'=>$market_price)); ?>

    <?php if ($viewed_meohay) : ?>
    <div class="clients clearfix">
        <div class="sixteen columns">
            <h2 class="title">Các mẹo bạn vừa xem <span class="line"></span></h2>
            <ul class="items">
                <?php foreach ($viewed_meohay as $key => $meohay) : ?>
                    <li><a href="<?php echo $meohay['url'] ?>" title="<?php echo $meohay['title'] ?>"><img src="<?php echo $meohay['image']['157'] ?>" alt="<?php echo $meohay['title'] ?>"></a></li>
                <?php endforeach; ?>
            </ul><!-- End items -->
        </div>
    </div><!-- End clients -->
    <?php endif; ?><!-- End clients -->


</div><!-- <<< End Container >>> -->