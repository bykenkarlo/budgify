    


    <!-- Topbar Start -->
    <div class="navbar-custom topnav-navbar topnav-navbar-light">
        <div class="container-fluid">
            <a class="button-menu-mobile disable-btn">
                <span class="uil uil-bars"></span>
            </a>
        </div>
    </div>
    <!-- end Topbar -->

    <!-- Start Content-->
    <div class="container-fluid">
        <div class="wrapper">
            <div class="leftside-menu leftside-menu-detached" id="_leftside_menu">
                <div class="leftbar-user">
                    <span id="_profile_left_sidebar" class="cursor-pointer">
                        <img src="<?=base_url().$user_data['profile_image']?>" onError="imgError(this);" alt="user-image" height="60" width="60" class="rounded-circle shadow-sm">
                        <span class="leftbar-user-name"></span>
                    </span>
                </div>
                <ul class="side-nav">
                    <li class="side-nav-title side-nav-item">Navigation</li>
                
                    <li class="side-nav-item">
                        <a onclick="accessURL('account/dashboard')" class="side-nav-link dashboard cursor-pointer <?=($state=='dashboard')?'active':'';?>">
                            <i class="uil-sliders-v-alt"></i>
                            <span class=""> Dashboard </span>
                        </a>
                    </li>
                    <li class="side-nav-item">
                        <a onclick="accessURL('account/settings')" class="side-nav-link orders cursor-pointer <?=($state=='settings' )?'active':'';?>">
                            <i class="uil-cog"></i>
                            <span class=""> Settings </span>
                        </a>
                    </li>
                    <li class="side-nav-item">
                        <a href="<?=base_url('logout')?>" class="side-nav-link orders cursor-pointer">
                            <i class="uil-signout"></i>
                            <span class=""> Logout </span>
                        </a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>