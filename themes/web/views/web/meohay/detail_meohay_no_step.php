<style>
    #fbcomments, .fb_iframe_widget, .fb_iframe_widget[style], .fb_iframe_widget iframe[style], #fbcomments iframe[style], div.pluginSkinLight div, .fb_iframe_widget span {
        width: 100% !important;
    }
</style>
<div class="container clearfix">
    <div class="two-thirds column">
        <!--catagory makeup-->
        <div class="recent-work gallery clearfix" style="display: inline-block">

            <div role="application" style="width: 100.2%;" class="slidewrap">

                <div class="two-thirds column"> <h2 class="title"><?php echo $meohay['title'] ?><span class="line"></span></h2> </div>
                <div id="fb-root"></div>
                <script>(function(d, s, id) {
                        var js, fjs = d.getElementsByTagName(s)[0];
                        if (d.getElementById(id)) return;
                        js = d.createElement(s); js.id = id;
                        js.src = "//connect.facebook.net/en_GB/all.js#xfbml=1&appId=236470773181814";
                        fjs.parentNode.insertBefore(js, fjs);
                    }(document, 'script', 'facebook-jssdk'));</script>
                <div style="padding: 0 0 10px 11px" class="fb-like" data-href="<?php echo 'http://meonho.net'.$meohay['url']?>" data-layout="standard" data-action="like" data-show-faces="true" data-share="true"></div>
                <!-- item 2 -->
                <div class="two-thirds column item" style="text-align:justify;line-height: 25px">
                    <strong style="padding: 0 0 20px;display: block"><?php echo $meohay['desc'] ?></strong>
                    <p class="text-align-left"><?php echo $meohay['content'] ?></p>
                    <p><?php echo $meohay['note'] ?></p>
                    <p><?php echo $meohay['tip'] ?></p>
                </div>
                <!-- End -->
                <div id="fb-root"></div>
                <script>(function(d, s, id) {
                        var js, fjs = d.getElementsByTagName(s)[0];
                        if (d.getElementById(id)) return;
                        js = d.createElement(s); js.id = id;
                        js.src = "//connect.facebook.net/en_GB/all.js#xfbml=1&appId=236470773181814";
                        fjs.parentNode.insertBefore(js, fjs);
                    }(document, 'script', 'facebook-jssdk'));</script>
                <div class="fb-comments" data-href="<?php echo 'http://meonho.net'.$meohay['url']?>" data-numposts="5" data-width="auto"></div>
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

    <div class="clients clearfix">
        <?php if ($new_meohay) : ?>
            <div class="sixteen columns">
                <h2 class="title">Các mẹo mới nhất <span class="line"></span></h2>
                <ul class="items">
                    <?php foreach ($new_meohay as $meohay): ?>
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