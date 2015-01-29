<div id="slider">
    <div class="container clearfix">

        <!--    --><?php //if($array_meohay['meohay']) :?>
        <div class="sixteen columns">
            <div class="flex-container">
                <div class="flexslider">
                    <ul class="slides">
                        <!--                        --><?php //foreach($array_meohay['meohay'] as $meohay) :?>
                        <li style="width: 100%; float: left; margin-right: -100%; display: none;">
                            <a href=""><img src="<?php echo Yii::app()->baseUrl?>/themes/web/files/images/interactive_background.jpg" alt=""></a>
                            <p class="flex-caption"> <span style="font-size: 16px">Học rất nhanh và hay</p>
                        </li>
                        <!--                        --><?php //endforeach;?>
                        <li style="width: 100%; float: left; margin-right: -100%; display: none;">
                            <a href=""><img src="<?php echo Yii::app()->baseUrl?>/themes/web/files/images/parallax_background.jpg" alt=""></a>
                            <p class="flex-caption"> <span style="font-size: 16px">Nói tiếng anh như gió</p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!--    --><?php //endif;?>

    </div><!-- End Container -->
</div><!-- End Slider -->

<div class="container clearfix" style="padding-top: 20px;">
    <div class="two-thirds column">
        <div class="two-thirds column">
            <h2 class="title"><a href="">Hello World </a><span class="line"></span></h2>
            <p>Today, English is the dominant international language in communications, science, business, and entertainment. A working knowledge of English means better job opportunities worldwide. As a result of the growing need for English skills, VIU’s School of Language Studies provides students with an opportunity to learn English quickly in a safe and friendly environment.

                VIU’s key location in the Washington, DC metro area provides students with the perfect opportunity to practice their English skills as they explore the region.</p>
        </div>

    </div>

    <!--right page-->
    <?php $this->renderPartial('//common/_right_page',array()); ?>


</div><!-- <<< End Container >>> -->