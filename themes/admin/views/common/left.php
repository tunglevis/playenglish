<!-- START OF LEFT PANEL -->
<div class="leftpanel">

    <div class="logopanel">
        <h1><a href="<?php echo $this->createUrl('/admin')?>">Admin Area <span><?php echo $this->domain?></span></a></h1>
    </div><!--logopanel-->

    <div class="datewidget">Today is <?php echo date('l, M d, Y')?></div>

    <div class="leftmenu">        
        <ul class="nav nav-tabs nav-stacked">
            <li class="nav-header">Main Navigation</li>
            
            
            <?php if($this->manager->isStaffOnly):?>
            <li <?php if($this->menu_parent_selected == 'manager'):?> class="active"<?php endif?>>
                <a href="<?php echo $this->createUrl('/admin/manager/update')?>"><span class="icon-user"></span> Tài khoản</a>
            </li>
            <?php else:?>
            <li class="dropdown <?php if($this->menu_parent_selected == 'manager'):?>active<?php endif?>">
                <a href="<?php echo $this->createUrl('/admin/manager')?>">
                    <span class="icon-user"></span> Nhân viên
                </a>
                <ul class="<?php echo ($this->menu_parent_selected == 'manager') ? 'opened':'closed'?>">
                    <li<?php if($this->menu_child_selected == 'manager_create'):?> class="active"<?php endif?>><a href="<?php echo $this->createUrl('/admin/manager/create')?>">Thêm mới</a></li>
                    <li<?php if($this->menu_child_selected == 'manager'):?> class="active"<?php endif?>><a href="<?php echo $this->createUrl('/admin/manager')?>">Quản lý</a></li>
                </ul>
            </li>
            <?php endif?>
            <li class="dropdown <?php if($this->menu_parent_selected == 'course'):?>active<?php endif?>">
                <a href="<?php echo $this->createUrl('/admin/course')?>">
                    <span class="icon-fire"></span> Khóa học
                </a>
                <ul class="<?php echo ($this->menu_parent_selected == 'course') ? 'opened':'closed'?>">
                    <li<?php if($this->menu_child_selected == 'course_create'):?> class="active"<?php endif?>><a href="<?php echo $this->createUrl('/admin/course/create')?>">Thêm khóa học</a></li>
                    <li<?php if($this->menu_child_selected == 'course'):?> class="active"<?php endif?>><a href="<?php echo $this->createUrl('/admin/course')?>">Quản lý khóa học</a></li>
                </ul>
            </li>
            <li class="dropdown <?php if($this->menu_parent_selected == 'lession'):?>active<?php endif?>">
                <a href="<?php echo $this->createUrl('/admin/lession')?>">
                    <span class="icon-fire"></span>Lession
                </a>
                <ul class="<?php echo ($this->menu_parent_selected == 'lession') ? 'opened':'closed'?>">
                    <li<?php if($this->menu_child_selected == 'lession_create'):?> class="active"<?php endif?>><a href="<?php echo $this->createUrl('/admin/lession/create')?>">Thêm Lession</a></li>
                    <li<?php if($this->menu_child_selected == 'lession'):?> class="active"<?php endif?>><a href="<?php echo $this->createUrl('/admin/lession')?>">Quản lý Lession</a></li>
                </ul>
            </li>
            <li class="dropdown <?php if($this->menu_parent_selected == 'document'):?>active<?php endif?>">
                <a href="<?php echo $this->createUrl('/admin/document')?>">
                    <span class="icon-fire"></span> Tài liệu
                </a>
                <ul class="<?php echo ($this->menu_parent_selected == 'document') ? 'opened':'closed'?>">
                    <li<?php if($this->menu_child_selected == 'document_create'):?> class="active"<?php endif?>><a href="<?php echo $this->createUrl('/admin/document/create')?>">Thêm tài liệu</a></li>
                    <li<?php if($this->menu_child_selected == 'document'):?> class="active"<?php endif?>><a href="<?php echo $this->createUrl('/admin/document')?>">Quản lý tài liệu</a></li>
                </ul>
            </li>
            <li class="dropdown <?php if($this->menu_parent_selected == 'dailyEnglish'):?>active<?php endif?>">
                <a href="<?php echo $this->createUrl('/admin/dailyEnglish')?>">
                    <span class="icon-fire"></span> Daily English
                </a>
                <ul class="<?php echo ($this->menu_parent_selected == 'dailyEnglish') ? 'opened':'closed'?>">
                    <li<?php if($this->menu_child_selected == 'dailyEnglish_create'):?> class="active"<?php endif?>><a href="<?php echo $this->createUrl('/admin/dailyEnglish/create')?>">Thêm Daily English</a></li>
                    <li<?php if($this->menu_child_selected == 'dailyEnglish'):?> class="active"<?php endif?>><a href="<?php echo $this->createUrl('/admin/dailyEnglish')?>">Quản lý Daily English</a></li>
                </ul>
            </li>
            <li class="dropdown <?php if($this->menu_parent_selected == 'commentDaily'):?>active<?php endif?>">
                <a href="<?php echo $this->createUrl('/admin/commentDaily')?>">
                    <span class="icon-fire"></span>Comment Daily English
                </a>
                <ul class="<?php echo ($this->menu_parent_selected == 'commentDaily') ? 'opened':'closed'?>">
                    <li<?php if($this->menu_child_selected == 'commentDaily_create'):?> class="active"<?php endif?>><a href="<?php echo $this->createUrl('/admin/commentDaily/create')?>">Thêm Comment Daily English</a></li>
                    <li<?php if($this->menu_child_selected == 'commentDaily'):?> class="active"<?php endif?>><a href="<?php echo $this->createUrl('/admin/commentDaily')?>">Quản lý Comment Daily English</a></li>
                </ul>
            </li>
            <li class="dropdown <?php if($this->menu_parent_selected == 'messageWall'):?>active<?php endif?>">
                <a href="<?php echo $this->createUrl('/admin/messageWall')?>">
                    <span class="icon-fire"></span>Message Wall
                </a>
                <ul class="<?php echo ($this->menu_parent_selected == 'messageWall') ? 'opened':'closed'?>">
                    <li<?php if($this->menu_child_selected == 'messageWall_create'):?> class="active"<?php endif?>><a href="<?php echo $this->createUrl('/admin/messageWall/create')?>">Thêm Message Wall</a></li>
                    <li<?php if($this->menu_child_selected == 'messageWall'):?> class="active"<?php endif?>><a href="<?php echo $this->createUrl('/admin/messageWall')?>">Quản lý Message Wall</a></li>
                </ul>
            </li>
            <li class="dropdown <?php if($this->menu_parent_selected == 'commentMessage'):?>active<?php endif?>">
                <a href="<?php echo $this->createUrl('/admin/commentMessage')?>">
                    <span class="icon-fire"></span>Comment Message
                </a>
                <ul class="<?php echo ($this->menu_parent_selected == 'commentMessage') ? 'opened':'closed'?>">
                    <li<?php if($this->menu_child_selected == 'commentMessage_create'):?> class="active"<?php endif?>><a href="<?php echo $this->createUrl('/admin/commentMessage/create')?>">Thêm Comment Message</a></li>
                    <li<?php if($this->menu_child_selected == 'commentMessage'):?> class="active"<?php endif?>><a href="<?php echo $this->createUrl('/admin/commentMessage')?>">Quản lý Comment Message</a></li>
                </ul>
            </li>
            <li class="dropdown <?php if($this->menu_parent_selected == 'homework'):?>active<?php endif?>">
                <a href="<?php echo $this->createUrl('/admin/homework')?>">
                    <span class="icon-fire"></span>Homework
                </a>
                <ul class="<?php echo ($this->menu_parent_selected == 'homework') ? 'opened':'closed'?>">
                    <li<?php if($this->menu_child_selected == 'homework_create'):?> class="active"<?php endif?>><a href="<?php echo $this->createUrl('/admin/homework/create')?>">Thêm Homework</a></li>
                    <li<?php if($this->menu_child_selected == 'homework'):?> class="active"<?php endif?>><a href="<?php echo $this->createUrl('/admin/homework')?>">Quản lý Homework</a></li>
                </ul>
            </li>
            <li class="dropdown <?php if($this->menu_parent_selected == 'user'):?>active<?php endif?>">
                <a href="<?php echo $this->createUrl('/admin/user')?>">
                    <span class="icon-fire"></span>Học Viên
                </a>
                <ul class="<?php echo ($this->menu_parent_selected == 'user') ? 'opened':'closed'?>">
                    <li<?php if($this->menu_child_selected == 'user_create'):?> class="active"<?php endif?>><a href="<?php echo $this->createUrl('/admin/user/create')?>">Thêm Học Viên</a></li>
                    <li<?php if($this->menu_child_selected == 'user'):?> class="active"<?php endif?>><a href="<?php echo $this->createUrl('/admin/user')?>">Quản lý Học Viên</a></li>
                </ul>
            </li>
            <li class="dropdown <?php if($this->menu_parent_selected == 'notify'):?>active<?php endif?>">
                <a href="<?php echo $this->createUrl('/admin/notify')?>">
                    <span class="icon-fire"></span>Thông báo
                </a>
                <ul class="<?php echo ($this->menu_parent_selected == 'notify') ? 'opened':'closed'?>">
                    <li<?php if($this->menu_child_selected == 'notify_create'):?> class="active"<?php endif?>><a href="<?php echo $this->createUrl('/admin/notify/create')?>">Thêm Thông báo</a></li>
                    <li<?php if($this->menu_child_selected == 'notify'):?> class="active"<?php endif?>><a href="<?php echo $this->createUrl('/admin/notify')?>">Quản lý Thông báo</a></li>
                </ul>
            </li>
        </ul>
    </div><!--leftmenu-->

    </div><!--mainleft-->
    <!-- END OF LEFT PANEL -->