<script language="javascript" src="<?php echo Yii::app()->baseUrl?>/themes/web/files/js/jquery.autosize.min.js"></script>
<script language="javascript" src="<?php echo Yii::app()->baseUrl?>/themes/web/files/js/jquery.slimscroll.min.js"></script>
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
    <!--    left box-->
    <div class="one-third column">
        <div class="left-box">
            <!--            <h2 class="title"><a href="">Tài liệu </a><span class="line"></span></h2>-->
            <div style="display: inline-block;margin-bottom: 15px;">
                <a style="float: left;display: inline-block;"><img src="<?php echo $user->avatarUrl.'?'.uniqid()?>"></a>
                <div id="your-profile" style="display: inline-block;line-height: 20px;font-size: 12px;padding-left: 10px;">
                    <a style="display: block;color: #00aec8;cursor: pointer;"><?php echo $user->name?></a>
                    <?php if($check):?><a style="display: block;color: #9197a3;cursor: pointer" href="<?php echo $this->createUrl('/web/user/update')?>">Edit Profile</a><?php endif;?>
                </div>
            </div>
            <?php foreach($user->course as $_course_key => $_course_val):?>
                <span class="field-left-box" style="display: block;clear: both;<?php if($_course_key == 0) echo 'margin: 0;border-top: none;padding-top: 0;';?>"><i class="icon-document" style="margin-right: 10px;height: 28px;width: 28px;display: inline-block;float: left;background-size: 100%;background-image: url(<?php echo Yii::app()->baseUrl?>/themes/web/files/images/icons/Lecture-128.png)"></i><a style="font-size: 13px;" href="<?php echo Yii::app()->createUrl('/web/course', array('name'=>$_course_val->name, 'id'=>$_course_val->id))?>"><?php echo $_course_val->name?></a></span>
            <?php endforeach;?>
        </div>
        <div class="left-box" style="margin-top: 30px;">
            <h2 class="title"><a href="">Lịch học tuần này </a><span class="line"></span></h2>
            <span style="padding-bottom: 10px;display: block;clear: both;font-size: 13px;line-height: 24px;border-bottom: 1px dotted #dfdfdf;">T5, 20-11 Bài học Phát âm trọng âm và nối âm trong giao tiếp tiếng anh.</span>
        </div>
        <?php if(isset($user->homework) && count($user->homework) >0):?>
            <div class="left-box" style="margin-top: 30px;">
                <h2 class="title"><a href="">Tập bài </a><span class="line"></span></h2>
                <div id="list-homework" style="height: 250px;overflow-y: scroll">
                    <?php foreach($user->homework as $_homework_key => $_homework_val):?>
                        <span class="field-left-box" style="display: block;clear: both;<?php if($_homework_key == 0) echo 'margin: 0;border-top: none;padding-top: 0;';?>"><i class="icon-document" style="margin-right: 5px;height: 28px;width: 28px;display: inline-block;float: left;background-size: 100%;background-image: url(<?php echo Yii::app()->baseUrl?>/themes/web/files/images/icons/medical_9-32.png)"></i><a style="font-size: 13px;" href="<?php echo $_homework_val->getUrl();?>"><?php echo $_homework_val->link;?></a></span>
                    <?php endforeach;?>
                </div>
            </div>
        <?php endif;?>
    </div>
    <!--    center box-->
    <div class="two-thirds column">

        <!--        content a feed course-->
        <div class="content-feed-course" style="border: 1px solid #ececec;padding: 10px;margin: 15px 0;background-color: #fff">
            <div>
                <a style="float: left;display: inline-block;"><img src="<?php echo User::model()->getAvatarUrl($feed->id_send).'?'.uniqid()?>"></a>
                <div style="display: inline-block;line-height: 20px;font-size: 12px;padding-left: 10px;">
                    <a style="display: block;color: #00aec8" href="<?php echo Yii::app()->createUrl('/web/user', array('user_name'=>str_replace(array(' ', '\\', '/', '-', '+', '*', '!', '@', '#','$','%','^', '&', '(',')', '=', '|'), '_', $feed->name_send), 'id'=>$feed->id_send))?>"><?php echo $feed->name_send?></a>
                    <span style="display: block;color: #9197a3">9 giờ trước</span>
                </div>
                <i class="icon-delete" style="float: right;">x</i>
            </div>
            <div style="clear: both;display: block;text-align: justify;padding: 5px 0 10px;font-size: 13px;">
                <?php if($feed->image):?>
                    <img src="<?php echo $feed->getUrlImage()?>" style="display: block;margin: 0 auto;">
                <?php endif;?>
                <p><?php echo $feed->content?></p>
            </div>
            <!--            comment-->
            <div id="comment-feed-<?php echo $feed->id?>" style="clear: both;display: block;padding-bottom: 15px">
                <?php foreach($feed->comment as $_key => $_val):?>
                    <div class="comment-feed">
                        <img src="<?php echo User::model()->getAvatarUrl($_val->id_send).'?'.uniqid()?>" style="width: 32px;display: inline-block;float: left;padding-right: 5px;">
                        <div style="display: inline-block;width: 90%;line-height: 14px;">
                            <span style="display: inline-block; width: 100%; font-size: 13px !important;"><a style="color: #00aec8;" href="<?php echo Yii::app()->createUrl('/web/user', array('user_name'=>str_replace(array(' ', '\\', '/', '-', '+', '*', '!', '@', '#','$','%','^', '&', '(',')', '=', '|'), '_', $_val->name_send), 'id'=>$_val->id_send))?>"><?php echo $_val->name_send?></a>&nbsp;<?php echo $_val->content;?></span>
                            <span style="display: block;clear: both;color: #9197a3;font-size: 11px;">1 hr</span>
                            <?php if($_val->image):?>
                                <img style="display: block;clear: both;margin: 0 auto;padding-top: 20px;" src="<?php echo $_val->getUrlImage()?>">
                            <?php endif;?>
                        </div>
                    </div>
                <?php endforeach;?>
            </div>
            <!--            end comment-->
            <!--                form comment daily english-->
            <form onsubmit="return add_comment($(this))" comment-id="<?php echo $feed->id?>" method="post" enctype="multipart/form-data" action="<?php echo Yii::app()->createUrl("web/user/commentFeed", array('id' => $feed->id))?>">
                <div>
                    <img src="<?php echo User::model()->getAvatarUrl($this->user->id).'?'.uniqid()?>" style="width: 32px;display: inline-block;float: left;padding-right: 5px;">
                    <textarea class="your-comment" title="Ý kiến của bạn?" name="comment-text" placeholder="Ý kiến của bạn?" autocomplete="off" aria-expanded="false" style="height: 20px;min-height: 20px;resize: none;padding: 5px;display: inline-block;width: 78%;font-size: 13px !important;"></textarea>
                    <button type="submit" style="float: right;margin:7px 0 10px;">Gửi</button>
                    <div style="display: none;">
                        <input type="file" id="feedImageComment-<?php echo $feed->id?>" name="comment-image" onchange="getImgCover('feedImageComment-<?php echo $feed->id?>')">
                    </div>
                    <label for="feedImageComment-<?php echo $feed->id?>"><img style="float: right;padding-right: 5px;" src="<?php echo Yii::app()->baseUrl?>/themes/web/files/images/icons/1418291258_camera-32.png"></label>
                </div>
                <img class="img_file_comment" style="clear: both;display: block;margin: 0 auto;max-height: 100px;padding-top: 5px;">
            </form>
        </div>
        <!--        end content a feed course-->
    </div>
</div><!-- <<< End Container >>> -->
<style>
    .feed-course a.active{
        color: #00aec8;
    }
    .left-box h2, .right-box h2{
        font-size: 16px;
    }
    #your-profile a:hover{
        text-decoration: underline;
    }
    a{
        cursor: pointer;
    }
    .comment-feed{
        display: block;
        clear: both;
        padding: 5px 0;
    }
</style>
<script>
    $('.feed-course a').click(function(){
        $('.feed-course a').removeClass('active');
        $(this).addClass('active');
        if($(this).attr('id') == "feed-image"){
            $(".upload-feed-image").show();
        }else{
            $(".upload-feed-image").hide();
        }
    });

    function getImgCover(evt){
//        var preview = document.querySelector('#'+evt);
        var f    = document.querySelector('#'+evt).files[0];
//        var files = $(evt).target.files;
//        var f = files[0];
        if(!f.type.match('image.*')) {
            alert('File không hợp lệ. Hãy chọn 1 file ảnh khác.');
            return false;
        }
        var i = document.createElement('input');
        if('multiple' in i){
            var reader = new FileReader();
            reader.readAsDataURL(f);
            reader.onload = (function(){
                return function(e){
                    $('#feedImageComment-1').parent().parent().parent().parent().find('.img_file_comment').attr('src', e.target.result).show();
                };
            })(f);
        }
    }

    $("#feedImage").change(function(evt){
        var files = evt.target.files;
        var f = files[0];

        if(!f.type.match('image.*')) {
            alert('File không hợp lệ. Hãy chọn 1 file ảnh khác.');
            return false;
        }
        var i = document.createElement('input');
        if('multiple' in i){
            var reader = new FileReader();
            reader.readAsDataURL(f);
            reader.onload = (function(){
                return function(e){
                    $('#img_file').attr('src', e.target.result).show();
                };
            })(f);
        }
    });

    function add_comment(element) {
        var id = element.attr('comment-id');
        var text_comment = element.find('.your-comment').val();
        var formData = new FormData(element[0]);
        var that = element;
        $.ajax({
            type:'POST',
            url: element.attr('action'),
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
            success:function(data){
                if(parseInt(data) != 1 && parseInt(data) != 0){
                    that.find('.your-comment').val('');
                    that.find('#feedImageComment-'+id).replaceWith(that.find('#feedImageComment-'+id).val('').clone(true));
                    that.find(".img_file_comment").hide();
                    var html = '<div class="comment-feed">'+
                        '<img src="<?php echo User::model()->getAvatarUrl($this->user->id).'?'.uniqid()?>" style="width: 32px;display: inline-block;float: left;padding-right: 5px;">'+
                        '<div style="display: inline-block;width: 90%;line-height: 14px;">'+
                        '<span style="display: inline-block; width: 71%; font-size: 13px !important;"><b style="color: #00aec8;"><?php echo $this->user->name?></b>&nbsp;'+text_comment+'</span>'+
                        '<span style="display: block;clear: both;color: #9197a3;font-size: 11px;">1 hr</span>'+
                        '<img src="'+data+'">'+
                        '</div>'+
                        '</div>';
                    $('#comment-feed-'+id).append(html).show('slow');
                }else if(data == 1){
                    that.find('.your-comment').val('');
                    that.find('#feedImageComment-'+id).replaceWith(that.find('#feedImageComment-'+id).val('').clone(true));
                    that.find(".img_file_comment").hide();
                    var html = '<div class="comment-feed">'+
                        '<img src="<?php echo User::model()->getAvatarUrl($this->user->id).'?'.uniqid()?>" style="width: 32px;display: inline-block;float: left;padding-right: 5px;">'+
                        '<div style="display: inline-block;width: 90%;line-height: 14px;">'+
                        '<span style="display: inline-block; width: 71%; font-size: 13px !important;"><b style="color: #00aec8;"><?php echo $this->user->name?></b>&nbsp;'+text_comment+'</span>'+
                        '<span style="display: block;clear: both;color: #9197a3;font-size: 11px;">1 hr</span>'+
                        '</div>'+
                        '</div>';
                    $('#comment-feed-'+id).append(html).show('slow');
                }else{
                    alert("false");
                }
            },
            error: function(data){
                console.log("error");
                console.log(data);
            }
        });

        return false;
    };

    $(function () {
        $('textarea').autosize();
        $('.your-comment').css('height','20px');
        $('#list-homework').slimScroll({
            height: '250px'
        });
    });
</script>