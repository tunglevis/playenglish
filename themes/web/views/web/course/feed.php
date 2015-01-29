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
    <div class="three columns">
        <?php if(isset($course->document) && count($course->document) > 0) :?>
            <div class="left-box">
                <h2 class="title"><a href="">Tài liệu </a><span class="line"></span></h2>
                <?php foreach($course->document as $_doc_key => $_doc_val):?>
                    <span class="left-box-content" style="display: block;clear: both;<?php if($_doc_key == 0) echo 'margin: 0;border-top: none;padding-top: 0;';?>"><i class="icon-document" style="height: 28px;width: 28px;display: inline-block;float: left;background-size: 100%;background-image: url(<?php echo Yii::app()->baseUrl?>/themes/web/files/images/icons/1418306689_Noun_Project_100Icon_10px_grid-06-32.png)"></i><a style="font-size: 13px;" target="_blank" href="<?php echo $_doc_val->getUrl()?>"><?php echo $_doc_val->title?></a></span>
                <?php endforeach;?>
            </div>
        <?php endif;?>
        <?php if(isset($course->homework) && count($course->homework) >0) :?>
            <div class="left-box" style="margin-top: 30px;">
                <h2 class="title"><a href="">Tập bài </a><span class="line"></span></h2>
                <div id="list-homework" style="max-height: 250px;">
                    <?php foreach($course->homework as $_homework_key => $_homework_val):?>
                        <span  class="left-box-content" style="display: block;clear: both;<?php if($_homework_key == 0) echo 'margin: 0;border-top: none;padding-top: 0;';?>"><i class="icon-document" style="margin-right: 5px;height: 28px;width: 28px;display: inline-block;float: left;background-size: 100%;background-image: url(<?php echo Yii::app()->baseUrl?>/themes/web/files/images/icons/medical_9-32.png)"></i><a style="font-size: 13px;" target="_blank" href="<?php echo $_homework_val->getUrl()?>"><?php echo $_homework_val->link?></a></span>
                    <?php endforeach;?>
                </div>
            </div>
        <?php endif;?>
        <?php if(isset($course->user) && count($course->user) > 0) :?>
            <div class="left-box" style="margin-top: 30px;">
                <h2 class="title"><a href="">Danh sách học viên </a><span class="line"></span></h2>
                <div id="list-member" style="max-height: 250px;">
                    <?php foreach($course->user as $_user_key => $_user_val):?>
                        <span class="left-box-content" style="display: block;clear: both;<?php if($_user_key == 0) echo 'margin: 0;border-top: none;padding-top: 0;';?>"><i class="icon-document" style="margin-right: 5px;height: 28px;width: 28px;display: inline-block;float: left;background-size: 100%;background-image: url(<?php echo Yii::app()->baseUrl?>/themes/web/files/images/icons/photo-48.png)"></i><a style="font-size: 13px;" href="<?php echo Yii::app()->createUrl('/web/user', array('user_name'=>$_user_val->user_name, 'id'=>$_user_val->id))?>"><?php echo $_user_val->name?></a></span>
                    <?php endforeach;?>
                </div>
            </div>
        <?php endif;?>
    </div>
    <!--    center box-->
    <div class="eight columns">
        <!--        content a feed course-->
        <div id="list-feeds">
            <div class="content-feed-course" style="border: 1px solid #ececec;padding: 10px;margin: 15px 0;background-color: #fff">
                <div>
                    <a style="float: left;display: inline-block;"><img src="<?php echo Yii::app()->baseUrl?>/themes/web/files/images/icons/photo-48.png"></a>
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
                    <p><?php echo $feed->feed?></p>
                </div>
                <!--            comment-->
                <div id="comment-feed-<?php echo $feed->id?>" style="clear: both;display: block;padding-bottom: 15px">
                    <?php foreach($feed->comment as $_key => $_val):?>
                        <div class="comment-feed">
                            <img src="<?php echo Yii::app()->baseUrl?>/themes/web/files/images/icons/photo-48.png" style="width: 32px;display: inline-block;float: left;padding-right: 5px;">
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
                <form onsubmit="return add_comment($(this))" comment-id="<?php echo $feed->id?>" method="post" enctype="multipart/form-data" action="<?php echo Yii::app()->createUrl("web/course/commentFeed", array('id'=>$course->id, 'comment_id' => $feed->id))?>">
                    <div>
                        <img src="<?php echo User::model()->getAvatarUrl($this->user->id).'?'.uniqid()?>" style="width: 32px;display: inline-block;float: left;padding-right: 5px;">
                        <textarea class="your-comment" title="Ý kiến của bạn?" name="comment-text" placeholder="Ý kiến của bạn?" autocomplete="off" aria-expanded="false" style="height: 20px;min-height: 20px;resize: none;padding: 5px;display: inline-block;width: 71%;font-size: 13px !important;"></textarea>
                        <button type="submit" style="float: right;margin:7px 0 10px;">Gửi</button>
                        <div style="display: none;">
                            <input type="file" id="feedImageComment-<?php echo $feed->id?>" name="comment-image" onchange="getImgCover('feedImageComment-<?php echo $feed->id?>')">
                        </div>
                        <label for="feedImageComment-<?php echo $feed->id?>"><img style="float: right;padding-right: 5px;" src="<?php echo Yii::app()->baseUrl?>/themes/web/files/images/icons/1418291258_camera-32.png"></label>
                    </div>
                    <img class="img_file_comment" style="clear: both;display: block;margin: 0 auto;max-height: 100px;padding-top: 5px;">
                </form>
            </div>
        </div>
        <!--        end content a feed course-->
    </div>
    <!--    right box-->
    <div class="five columns">
        <div class="right-box" style="box-shadow: 1px 2px 10px #aff">
            <h2 class="title">Thông báo<span class="line"></span></h2>
            <span style="display: block;clear: both"><i class="icon-document" style="margin-right: 5px;height: 28px;width: 28px;display: inline-block;float: left;background-size: 100%;background-image: url(<?php echo Yii::app()->baseUrl?>/themes/web/files/images/icons/1418370168_sound-32.png)"></i><span style="font-size: 13px;">T5, 20-11 Do có việc bận nên lớp được nghỉ</span></span>
        </div>
        <div class="right-box" style="box-shadow: 1px 2px 10px #aff;margin-top: 15px;">
            <h2 class="title">Nội dung trong tuần<span class="line"></span></h2>
            <?php if($this_week):?>
                <span style="padding-bottom: 10px;display: block;clear: both;font-size: 13px;line-height: 24px;border-bottom: 1px dotted #dfdfdf;"><?php echo $this_week->name.' ('.date('D, d/m/Y',$this_week->time_start).') '?> : <?php echo $this_week->content?></span>
            <?php endif;?>
            <h6 style="padding: 15px 0 10px;">Nộp bài tuần này</h6>
            <form id="homework-form" method="post" enctype="multipart/form-data" action="<?php echo Yii::app()->createUrl("web/course/homework", array('id' => $course->id))?>">
                <input type="file" id="do-homework" name="homework">
                <button type="submit" style="float: right;margin:4px 10px 10px;">Gửi</button>
            </form>
            <i style="font-size: 10px;font-style: italic;">(Fomat: Tuần 2: Phát âm - Lê Văn Tùng)</i>
        </div>
        <div class="right-box" style="box-shadow: 1px 2px 10px #aff;margin-top: 15px;">
            <h2 class="title">Lịch trình khóa học<span class="line"></span></h2>
            <div role="tablist" class="ui-accordion ui-widget ui-helper-reset ui-accordion-icons" id="accordion" style="font-size: 13px;">
                <?php foreach($course->lession as $_lession_val):?>
                    <h3 role="tab" class="ui-accordion-header ui-helper-reset ui-state-default ui-corner-all" style="font-size: 13px;"><a href=""><?php echo $_lession_val->name?></a></h3>
                    <div class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom"><p><?php echo $_lession_val->content?></p></div>
                <?php endforeach;?>
            </div><!-- End accordion -->
        </div>
    </div>
</div><!-- <<< End Container >>> -->

<style>
    .feed-course a.active{
        color: #00aec8;
    }
    .left-box h2, .right-box h2{
        font-size: 16px;
    }
    .left-box span.left-box-content{
        margin: 20px 0;
        border-top: 1px dotted #dfdfdf;
        padding-top: 8px;
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
                    $('#'+evt).parent().parent().parent().parent().find('.img_file_comment').attr('src', e.target.result).show();
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

        <?php if(isset($course->homework) && count($course->homework) >=5) :?>
        $('#list-homework').slimScroll({
            height: '250px'
        });
        <?php endif;?>
        <?php if(isset($course->user) && count($course->user) >5) :?>
        $('#list-member').slimScroll({
            height: '250px'
        });
        <?php endif;?>
        $('#homework-form').on('submit',(function(e) {
            e.preventDefault();
            var formData = new FormData(this);

            $.ajax({
                type:'POST',
                url: $(this).attr('action'),
                data:formData,
                cache:false,
                contentType: false,
                processData: false,
                success:function(data){
                    if(data == 1){
                        location.reload();
                    }else{

                    }
                },
                error: function(data){
                    console.log("error");
                    console.log(data);
                }
            });
        }));
        $('#feed-form').on('submit',(function(e) {
            e.preventDefault();
            var formData = new FormData(this);

            $.ajax({
                type:'POST',
                url: $(this).attr('action'),
                data:formData,
                cache:false,
                contentType: false,
                processData: false,
                success:function(data){
                    if(data == 1){
                        location.reload();
                    }else{

                    }
                },
                error: function(data){
                    console.log("error");
                    console.log(data);
                }
            });
        }));
    });
</script>