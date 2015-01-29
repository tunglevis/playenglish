<!-- item 1 -->
<div class="one-third column item <?php if($index%2 ==0) echo 'last-child'?>">
    <div class="caption">
        <a href="<?php echo $data->meohay['url']?>"><img src="<?php echo $data->meohay['image']['420']?>" alt="<?php echo $data->meohay['title']?>" class="pic">
            <span class="hover-effect link"></span></a>
    </div><!-- hover effect -->
    <h4><a href="<?php echo $data->meohay['url']?>"><?php echo (count($words = explode(' ', $data->meohay['title'])) > 7) ? implode(' ', array_slice($words, 0, 7)) . '...' : $data->meohay['title'];?></a></h4>
    <p title="<?php echo $data->meohay['desc']?>"><?php echo (count($words = explode(' ', $data->meohay['desc'])) > 8) ? implode(' ', array_slice($words, 0, 8)) . '...' : $data->meohay['desc'];?></p>
</div>
<!-- End -->