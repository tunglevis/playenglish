

$(function() {

    $(".info_scroll").mCustomScrollbar({
        autoHideScrollbar:true,        
        scrollInertia:400,
        theme:"dark-thin"        
    });
    //find all form with class jqtransform and apply the plugin
    //$("form#filter-form").jqTransform();
    //    $(".filter-more-select").jqTransform();
    //    $(".filter-popup-body").jqTransform();

    // affix
    $('#filter-block').height($(".filter-block").height());
    $('.filter-block').affix({
        offset: {
            top : 170,          
        }
    });
    $('.tool-utilities').tooltip();
});

// toggle
$('#more-filter a').click(function() {
    $('.filter-items').toggle('fast');
});



// parent checkbox on change
$(".filter_group_item_father input:checkbox").on('change',function(){
    var parent = $(this).parent();
    var name = parent.attr('name');

    // parent checked
    if($(this).is(':checked')){
        // remove all show class of parent and child
        $(".filter_group_item_father").removeClass("show");
        $('.filter-group-sub').removeClass('show');

        // add show class to this father and child
        $(parent).addClass('show');
        $('.filter-group-sub[name='+name+']').addClass('show');

        // update all caret to down
        $('.filter_group_item_father .caret').attr('class', 'caret tab-down').attr('title', 'Mở');
        // update this caret to up
        $('.caret', parent).attr('class', 'caret tab-up').attr('title', 'Đóng');
    }
    // parent unchecked
    else {
        // remove checked of childs
        $('.filter-group-sub[name='+name+']').find('input[type="checkbox"]').attr("checked",false);
    }
})

// caret on click
$(".filter_group_item .caret").on('click', function(){
    var parent = $(this).parent();
    var name = parent.attr('name');

    // caret click down
    if($(this).hasClass('tab-down')){
        // update all caret to down
        $('.filter_group_item_father .caret').attr('class', 'caret tab-down').attr('title', 'Mở');
        // update this caret to up
        $(this).attr('class', 'caret tab-up').attr('title', 'Đóng');

        // remove all show class of father and child 
        $(".filter_group_item_father").removeClass("show");
        $('.filter-group-sub').removeClass('show');

        // add show class to this father and child
        parent.addClass('show');
        $('.filter-group-sub[name='+name+']').addClass('show');

        // caret click up        
    }else{
        // change caret to down
        $(this).removeClass('tab-up').addClass('tab-down');

        // remove show class to this father and child 
        parent.removeClass('show');
        $('.filter-group-sub[name='+name+']').removeClass('show'); 
    }
});


// child checkbox on change
$(".filter-group-sub input").on('change',function(){
    var name = $(this).parent().parent().attr('name');

    // if child is checked then set father is too
    if($(this).is(':checked')){
        $('.filter_group_item_father[name='+name+'] input').attr("checked","checked");
    }
});
