<?php

use yii\helpers\Url;
?>
<div id="sidebar" class="page-sidebar">
    <div class="page-sidebar-scroll">
        <div class="sidebar-section">
            <p>个人设置</p>
            <a href="#" class="sidebar-close"></a>
        </div>
        <div class="sidebar-header">
            <a href="<?= Url::toRoute('/index') ?>" class="sidebar-logo"></a>
            <a href="<?= Url::toRoute('/member/index/index') ?>" class="facebook-sidebar"></a>
        </div>

        <div class="navigation-items">
            <div class="nav-item">
                <a href="<?= Url::toRoute('/member/user/index') ?>" class="home-nav">我的头像<em class="selected-nav"></em></a>
            </div>
            <div class="nav-item">
                <a href="#" class="features-nav submenu-deploy">信息认证<em class="dropdown-nav"></em></a>
                <div class="nav-item-submenu" style="overflow: hidden; display: none;">
                    <a href="<?= Url::toRoute('/member/user/info') ?>">修改信息	 
                        <em class="unselected-sub-nav"></em>
                    </a>
                </div>
            </div>
            <div class="nav-item">
                <a href="<?= Url::toRoute('/public/logout') ?>">退出登录<em class="unselected-nav"></em></a>
            </div> 
            <div class="sidebar-decoration"></div>
        </div>
        <div class="sidebar-section copyright-sidebar">
            <p>版权：寻想网络科技 .<?= date('Y') ?> </p>
        </div>                  
    </div>
</div>