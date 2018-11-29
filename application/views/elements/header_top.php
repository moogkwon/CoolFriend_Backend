    <header class="app-header navbar">
        <div class="hamburger hamburger--arrowalt-r navbar-toggler mobile-sidebar-toggler d-lg-none mr-auto">
            <div class="hamburger-box">
                <div class="hamburger-inner"></div>
            </div>
        </div>
        <!-- end hamburger -->
        <a class="navbar-brand" href="<?php echo base_url(); ?>">
            <strong><?php echo SITE_TITLE; ?></strong>
        </a>
        <div class="hamburger hamburger--arrowalt-r navbar-toggler sidebar-toggler d-md-down-none mr-auto">
            <div class="hamburger-box">
                <div class="hamburger-inner"></div>
            </div>
        </div>
        <!-- end hamburger -->
        
        <ul class="nav navbar-nav ">
            
            <!-- end navitem -->
            <li class="nav-item dropdown">
                <a class="btn btn-round btn-theme btn-sm" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <span class="">
						<?php echo $this->session->userdata('username'); ?>
                        <i class="fa fa-arrow-down"></i>
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-right user-menu animated flipInY ">
                    <div class="wrap" style="max-width: 100%;">
                        <div class="dw-user-box">
                            <div class="u-text">
                                <h5><?php echo $this->session->userdata('username'); ?></h5>
                                <p class="text-muted"><?php echo $this->session->userdata('first_name'); ?></p>
                                <a href="<?php echo site_url('Admin/Profile'); ?>" class="btn btn-round btn-theme btn-sm">Change Password</a>
                            </div>
                        </div>
                        <!-- end dw-user-box -->
                        <div class="divider"></div>
                        <a class="dropdown-item" href="<?php echo site_url('Admin/Dashboard/Logout'); ?>">
                            <i class="fa fa-lock"></i> Logout</a>
                    </div>
                    <!-- end wrap -->
                </div>
                <!-- end dropdown-menu -->
            </li>
            <!-- end nav-item -->
        </ul>
    </header>