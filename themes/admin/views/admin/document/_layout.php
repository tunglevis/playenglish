<?php $this->beginContent('//layouts/main'); ?>
<div class="pagetitle">
    <h1>Tài liệu</h1> <span>Quản lý tài liệu</span>
</div><!--pagetitle-->

<div class="maincontent">
    <div class="contentinner">
        <div class="tabs2 ui-tabs ui-widget ui-widget-content ui-corner-all">
            <ul class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all">
                <?php if($this->manager->isManager):?>
                <li class="ui-state-default ui-corner-top <?php if($this->menu_sub_selected == 'create'):?> ui-tabs-selected ui-state-active<?php endif?>">
                    <a href="<?php echo $this->createUrl('/admin/document/create')?>">Thêm tài liệu</a></li>
                <li class="ui-state-default ui-corner-top <?php if($this->menu_sub_selected == 'index'):?> ui-tabs-selected ui-state-active<?php endif?>">
                    <a href="<?php echo $this->createUrl('/admin/document/')?>">Danh sách tài liệu</a></li>
                <?php endif?>
                
                <?php if($this->menu_sub_selected == 'update'):?> 
                <li class="ui-state-default ui-corner-top ui-tabs-selected ui-state-active">
                    <a href="<?php echo $this->createUrl('/admin/document/update')?>">Cập nhật tài liệu</a></li>
                <?php endif?>
            </ul>
        
            <div class="ui-tabs-panel ui-widget-content ui-corner-bottom">
                <?php $this->widget('admin.components.widgets.AlertWidget');?>
                <?php echo $content?>
            </div>
        </div>

        <div class="clearfix"></div>
    </div><!--contentinner-->
</div><!--maincontent-->
<?php $this->endContent(); ?>