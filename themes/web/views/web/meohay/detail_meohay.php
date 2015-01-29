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
</style>
<div class="container clearfix">
    <div class="two-thirds column">
        <!--catagory makeup-->
        <div class="recent-work gallery clearfix">

            <div role="application" style="overflow: hidden; width: 100.2%;" class="slidewrap">

                <div class="two-thirds column"> <h2 class="title"><?php echo $meohay['title'] ?><span class="line"></span></h2> </div>

                <?php foreach ($meohay['step'] as $step) : ?>
                    <!-- item 2 -->
                    <div class="two-thirds column item">
                        <div class="caption">
                            <span class="step-meohay">Bước <?php echo $step['step'] ?>: <?php echo $step['name'] ?></span>
                            <a href="<?php echo $step['image'] ?>" rel="prettyPhoto[gallery1]">
                                <img src="<?php echo $step['image'] ?>" alt="<?php echo $step['name'] ?>" class="pic">
                                <span class="hover-effect zoom"></span></a>
                        </div><!-- hover effect -->
                        <p class="text-align-left"><?php echo $step['desc'] ?></p>
                    </div>
                    <!-- End -->
                <?php endforeach; ?>

                <p><?php echo $meohay['note'] ?></p>
                <p><?php echo $meohay['tip'] ?></p>

            </div><!-- End slidewrap -->

        </div><!-- End makeup -->

    </div>

    <!--right page-->
    <?php $this->renderPartial('//common/_right_page',array('new_knowledge'=>$new_knowledge, 'new_today'=>$new_today, 'market_price'=>$market_price)); ?>

    <div class="clients clearfix">

        <?php if ($same_meohay) : ?>
            <div class="sixteen columns"> 
                <h2 class="title">Các mẹo tương tự <span class="line"></span></h2> 
                <ul class="items">
                    <?php foreach ($same_meohay as $meohay): ?>
                        <li><a title="<?php echo $meohay['title'] ?>" href="<?php echo $meohay['url'] ?>"><img src="<?php echo $meohay['image']['157'] ?>" alt="<?php echo $meohay['title'] ?>"></a></li>
                    <?php endforeach; ?>
                </ul><!-- End items -->
            </div>
        <?php endif; ?>
    </div><!-- End clients -->

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
    <?php endif; ?>


</div><!-- <<< End Container >>> -->