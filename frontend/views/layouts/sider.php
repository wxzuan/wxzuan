<?php

use yii\helpers\Url;
?>
<div id="sidebar" class="page-sidebar">
    <div class="page-sidebar-scroll">
        <div class="sidebar-section">
            <p>应用导航</p>
            <a href="#" class="sidebar-close"></a>
        </div>
        <div class="sidebar-header">
            <a href="<?= Url::toRoute('/index') ?>" class="sidebar-logo"></a>
            <a href="<?= Url::toRoute('/member/index/index') ?>" class="facebook-sidebar"></a>
        </div>

        <div class="navigation-items">
            <div class="nav-item">
                <a href="<?= Url::toRoute('/index') ?>" class="home-nav">返回首页<em class="selected-nav"></em></a>
            </div>
            <div class="nav-item">
                <a href="#" class="features-nav submenu-deploy">服务中心<em class="dropdown-nav"></em></a>
                <div class="nav-item-submenu" style="overflow: hidden; display: none;">
                    <a href="<?= Url::toRoute('/product/index') ?>">商品区	 
                        <em class="unselected-sub-nav"></em>
                    </a>
                    <a href="<?= Url::toRoute('/product/index') ?>">物运区		  
                        <em class="unselected-sub-nav"></em>
                    </a>
                    <a href="<?= Url::toRoute('/product/index') ?>">理财区		  
                        <em class="unselected-sub-nav"></em>
                    </a>
                    <a href="<?= Url::toRoute('/product/index') ?>">吐槽区			
                        <em class="unselected-sub-nav"></em>
                    </a>
                </div>
            </div>
            <div class="nav-item">
                <a href="<?= Url::toRoute('/help/index') ?>" class="help-nav">帮助中心<em class="go-right"></em></a>
            </div> 
            <div class="nav-item">
                <a href="<?= Url::toRoute('/help/contact') ?>" class="features-nav">联系我们<em class="go-right"></em></a>
            </div>
            <div class="nav-item">
                <a href="<?= Url::toRoute('/member/index') ?>" class="member-nav">会员中心<em class="go-right"></em></a>
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