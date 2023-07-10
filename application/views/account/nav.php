    


    <!-- Topbar Start -->
    <div class="navbar-custom topnav-navbar topnav-navbar-light">
        <div class="container-fluid">

            <!-- LOGO -->
            <a href="<?=base_url();?>" class="topnav-logo cursor-pointer">
                <!-- <span class="topnav-logo-lg">
                    <img src="<?=base_url('assets/images/logo/hh-logo.webp')?>" alt="" height="40">
                </span>
                <span class="topnav-logo-sm">
                    <img src="<?=base_url('assets/images/logo/mm-logo.webp')?>" alt="" height="36">
                </span> -->
            </a>

            <ul class="list-unstyled topbar-menu float-end mb-0">
                <li class="dropdown notification-list">
                    <a class="nav-link dropdown-toggle nav-user arrow-none me-0" data-bs-toggle="dropdown" id="topbar-userdrop" href="#" role="button" aria-haspopup="true"
                        aria-expanded="false">
                        <span class="account-user-avatar"> 
                            <i class="uil uil-user-circle rounded-circle font-40" ></i>
                        </span>
                        <span>
                            <span class="account-user-name"></span>
                            <span class="account-position text-capitalize"><?= ($user_data['user_type'] == 'admin') ? 'System Admin' : str_replace('_',' ',ucwords($user_data['user_type']))?></span>
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated topbar-dropdown-menu profile-dropdown" aria-labelledby="topbar-userdrop">
                        <!-- item-->
                        <div class=" dropdown-header noti-title">
                            <h6 class="text-overflow m-0">Welcome !</h6>
                        </div>

                        <!-- item-->
                        <a href="<?=base_url('account/dashboard')?>" class="dropdown-item notify-item">
                            <i class="mdi mdi-account-circle me-1"></i>
                            <span>My Account</span>
                        </a>

                        <!-- item-->
                        <a href="<?=base_url('account/settings')?>" class="dropdown-item notify-item">
                            <i class="mdi mdi-cog me-1"></i>
                            <span>Settings</span>
                        </a>

                        <!-- item-->
                        <a href="<?=base_url('logout')?>" class="dropdown-item notify-item">
                            <i class="mdi mdi-logout me-1"></i>
                            <span>Logout</span>
                        </a>

                    </div>
                </li>

            </ul>
            <a class="button-menu-mobile disable-btn">
                <div class="lines">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </a>
        
        </div>
    </div>
    <!-- end Topbar -->

    <!-- Start Content-->
    <div class="container-fluid">
        <div class="wrapper">
            <div class="leftside-menu leftside-menu-detached" id="_leftside_menu">
                <span class="float-end padding-right-20 mt-2 cursor-pointer" id="sidenav-left">
                    <i class="uil uil-angle-left-b font-25"></i>
                </span>
                <div class="leftbar-user">
                    <span id="_profile_left_sidebar" class="cursor-pointer">
                        <img src="<?=base_url().$user_data['profile_image']?>" onError="imgError(this);" alt="user-image" height="100" width="100" class="rounded-circle shadow-sm">
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
                        <a onclick="accessURL('account/orders')" class="side-nav-link orders cursor-pointer <?=($state=='orders' || $state == 'view_order')?'active':'';?>">
                            <i class="uil-shopping-cart-alt"></i>
                            <span class=""> Orders </span>
                        </a>
                    </li>
                    <?php if (isset($this->session->admin)) { ?>
                    <li class="side-nav-item">
                        <a onclick="accessURL('account/users-list')" class="side-nav-link users-list cursor-pointer <?=($state =='users_list')?'active':'';?>">
                            <i class="uil-users-alt "></i>
                            <span class=""> User Management </span>
                        </a>
                    </li>
                        <?php } ?>
                    <li class="side-nav-item">
                        <a onclick="accessURL('account/reports')" class="side-nav-link reports cursor-pointer <?=($state =='reports')?'active':'';?>">
                            <i class="uil-chart"></i>
                            <span class=""> Reports </span>
                        </a>
                    </li>
                    <?php if (isset($this->session->admin)) { ?>
                    <li class="side-nav-item">
                        <a onclick="accessURL('account/activity-logs')" class="side-nav-link website-settings cursor-pointer <?=($state =='activity_logs')?'active':'';?>">
                            <i class="uil-setting "></i>
                            <span> Activity Logs </span>
                            <!-- <span class="menu-arrow"></span> -->
                        </a>
                    </li>
                    <?php } ?>
                </ul>
                <div class="clearfix"></div>
            </div>