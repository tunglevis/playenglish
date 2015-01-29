<div class="one-third column">
    <div class="right-box" style="box-shadow: 1px 2px 10px #aff">
<!--        --><?php //if(isset($new_knowledge) && count($new_knowledge) > 0):?>
            <h2 class="title">Các khóa học<span class="line"></span></h2>

            <div role="tablist" class="ui-accordion ui-widget ui-helper-reset ui-accordion-icons" id="accordion">
<!--                --><?php //foreach($new_knowledge as $knowledge):?>
                    <h3 role="tab" class="ui-accordion-header ui-helper-reset ui-state-default ui-corner-all"><a href="">Khóa học Phát âm</a></h3>
                    <div class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom"><p>Phát âm là phát âm, lên nóc nhà là lên nóc nhà <a href="" style="clear: both;display: block;width: 100%;text-align: right;font-size: 12px;">xem thêm &gt;&gt;</a></p></div>

                    <h3 role="tab" class="ui-accordion-header ui-helper-reset ui-state-default ui-corner-all"><a href="">Khóa học Ngữ pháp</a></h3>
                    <div class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom"><p>Ngữ pháp thật là điêu luyện, lợi hại, lợi hại <a href="" style="clear: both;display: block;width: 100%;text-align: right;font-size: 12px;">xem thêm &gt;&gt;</a></p></div>
                <?php //endforeach;?>
            </div><!-- End accordion -->
<!--        --><?php //endif;?>
    </div><!-- End our services -->

    <div class="right-box" style="margin-top: 10px;box-shadow: 1px 2px 10px #aff">
        <h2 class="title">Những học viên suất sắc nói gì<span class="line"></span></h2>
        <iframe width="100%" src="//www.youtube.com/embed/nAgXO-dSrq0" frameborder="0" allowfullscreen></iframe>
    </div>

    <div class="right-box">
        <?php if(isset($new_today) && count($new_today)>0):?>
            <h2 class="title">Làm gì hôm nay<span class="line"></span></h2>
            <ul class="whyus">
                <li>
                    <a href="<?php echo Yii::app()->baseUrl.'/web/othertip/today?id='.$new_today[0]['id']?>"><img width="265" src="<?php echo $new_today[0]['image']['410']?>" alt="<?php echo $new_today[0]['title']?>" class="border"></a>
                    <p><?php echo $new_today[0]['desc']?></p>
                    <span class="more2"><a href="<?php echo Yii::app()->baseUrl.'/goi-y/lam-gi-hom-nay-'.$new_today[0]['id']?>">xem thêm</a></span>
                </li>
            </ul>
        <?php endif;?>
    </div><!-- End choose us -->

    <div class="right-box">
        <div id="fb-root"></div>
        <script>(function(d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) return;
                js = d.createElement(s); js.id = id;
                js.src = "//connect.facebook.net/en_GB/all.js#xfbml=1&appId=419496388179920";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));</script>
        <div class="fb-like-box" data-href="https://www.facebook.com/meonho.net" data-width="282px" data-colorscheme="light" data-show-faces="true" data-header="true" data-stream="false" data-show-border="true"></div>
    </div><!-- End choose us -->

</div>