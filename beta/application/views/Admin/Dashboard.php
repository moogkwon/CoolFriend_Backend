<?php $this->load->view('elements/header'); ?>
<?php $this->load->view('elements/header_top'); ?>
    <!-- end header -->
    <div class="app-body">
        <?php $this->load->view('elements/left_sidebar_admin'); ?>
        <!-- end sidebar -->
        <main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb bc-colored bg-theme" id="breadcrumb">
                <li class="breadcrumb-item ">
                    <a href="<?php echo base_url(); ?>">Home</a>
                </li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
            <div class="container-fluid">
                <div class="animated fadeIn">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="ecom-widget-chart-full">
                                <div class="chart-full-header">
                                    <div class="header-text">
                                        <div class="heading">Dashboard</div>
                                    </div>
                                   
                                    <canvas class="chart-full-canvas" id="canvas-full-chart-light"></canvas>
                                </div>
                            </div>
                            <!-- end ecom-widget-chart-full -->
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row -->
                    <div class=" row row-margin-up">
                        <div class="col-md-3">
                            <div class="card ecom-widget-sales">
                                <div class="card-body">
                                    <div class="ecom-sales-icon text-center">
                                        <i class="mdi mdi-cart-outline"></i>
                                    </div>
                                    <!-- end ecom-sales-icon -->
                                    <h5 class="text-center">Sales</h5>
                                    <ul>
                                        <li>Completed
                                            <span>276</span>
                                        </li>
                                        <li>Abondoned
                                            <span>276</span>
                                        </li>
                                        <li>Tax(%)
                                            <span>11%</span>
                                        </li>
                                        <li>Pending
                                            <span class="badge badge-theme">5</span>
                                        </li>
                                        <li>Sales
                                            <span>$ 200,125.12</span>
                                        </li>
                                    </ul>
                                    <div class="text-center btn-tool-bar">
                                        <button class="btn btn-theme ">More Details</button>
                                    </div>
                                    <!-- end btn-tool-bar -->
                                </div>
                                <!-- end card-body -->
                            </div>
                            <!-- end ecom-widget-sales -->
                        </div>
                        <!-- end col -->
                        <div class="col-md-3 ">
                            <div class="card ecom-widget-sales">
                                <div class="card-body">
                                    <div class="ecom-sales-icon text-center">
                                        <i class="mdi mdi-currency-usd"></i>
                                    </div>
                                    <!-- end ecom-sales-icon -->
                                    <h5 class="text-center">Orders</h5>
                                    <ul>
                                        <li>Completed
                                            <span>276</span>
                                        </li>
                                        <li>Carts
                                            <span>276</span>
                                        </li>
                                        <li>Tax(%)
                                            <span>11%</span>
                                        </li>
                                        <li>Pending
                                            <span class="badge badge-theme">5</span>
                                        </li>
                                        <li>Sales
                                            <span>$ 200,125.12</span>
                                        </li>
                                    </ul>
                                    <div class="text-center btn-tool-bar">
                                        <button class="btn btn-theme ">More Details</button>
                                    </div>
                                    <!-- end btn-tool-bar -->
                                </div>
                                <!-- end card-body -->
                            </div>
                            <!-- ecom-widget-sales -->
                        </div>
                        <!-- end col -->
                        <div class="col-md-3 ">
                            <div class="card ecom-widget-sales">
                                <div class="card-body">
                                    <div class="ecom-sales-icon text-center">
                                        <i class="mdi mdi-cube-outline"></i>
                                    </div>
                                    <!-- end ecom-sales-icon -->
                                    <h5 class="text-center">Deliver</h5>
                                    <ul>
                                        <li>Orders
                                            <span>276</span>
                                        </li>
                                        <li>Abondoned
                                            <span>276</span>
                                        </li>
                                        <li>Tax(%)
                                            <span>11%</span>
                                        </li>
                                        <li>Pending
                                            <span class="badge badge-theme">5</span>
                                        </li>
                                        <li>Sales
                                            <span>$ 200,125.12</span>
                                        </li>
                                    </ul>
                                    <div class="text-center btn-tool-bar">
                                        <button class="btn btn-theme ">More Details</button>
                                    </div>
                                    <!-- end btn-tool-bar -->
                                </div>
                                <!-- end card-body -->
                            </div>
                            <!-- end ecom-widget-sales  -->
                        </div>
                        <!-- end col -->
                        <div class="col-md-3 ">
                            <div class="card ecom-widget-sales">
                                <div class="card-body">
                                    <div class="ecom-sales-icon text-center">
                                        <i class="mdi mdi-fingerprint"></i>
                                    </div>
                                    <!-- end ecom-sales-icon -->
                                    <h5 class="text-center">Orders</h5>
                                    <ul>
                                        <li>Completed
                                            <span>276</span>
                                        </li>
                                        <li> Carts
                                            <span>276</span>
                                        </li>
                                        <li>Tax(%)
                                            <span>11%</span>
                                        </li>
                                        <li>Pending
                                            <span class="badge badge-theme">5</span>
                                        </li>
                                        <li>Sales
                                            <span>$ 200,125.12</span>
                                        </li>
                                    </ul>
                                    <div class="text-center btn-tool-bar">
                                        <button class="btn btn-theme ">More Details</button>
                                    </div>
                                    <!-- end btn-tool-bar -->
                                </div>
                                <!-- end card-body -->
                            </div>
                            <!-- end  ecom-widget-sales -->
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row -->
                    <div class="row">
                        <div class="col-md-5">
                            <div class="card card-accent-theme users-count">
                                <div class="card-body">
                                    <i class="mdi mdi-account-circle"></i>
                                    <div class="count">2564</div>
                                    <div class="heading">Online</div>
                                    <p class="text-disabled">Number of all Online Users Who have
                                        <br />Logged into the Website at the moment</p>
                                    <div class="row">
                                        <div class="col-md-4  online-users">
                                            <div class="count-small">2564</div>
                                            <div class="heading-small">Online</div>
                                        </div>
                                        <!-- online-users -->
                                        <div class="col-md-4 offline-users">
                                            <div class="count-small">10256</div>
                                            <div class="heading-small">Offline</div>
                                        </div>
                                        <!-- end offline-users -->
                                        <div class="col-md-4 pending-users">
                                            <div class="count-small">100</div>
                                            <div class="heading-small">Pending</div>
                                        </div>
                                        <!-- end pending users -->
                                    </div>
                                    <!-- end inside row -->
                                </div>
                                <!-- end card-body -->
                            </div>
                            <!-- end card users-count -->
                        </div>
                        <!-- end col -->
                        <div class="col-md-7">
                            <div class=" card ecom-widget-chart card-accent-theme">
                                <div class="card-body text-center">
                                    <div class="header-tools">
                                        <button class="btn btn-sm btn-secondary">Pending Users</button>
                                        <button class="btn btn-sm btn-theme">New Users</button>
                                        <button class="btn btn-sm btn-secondary">Online Users</button>
                                    </div>
                                    <div class="ecom-chart-text text-center">2145 new users</div>
                                    <div class="chart-period text-center"> Aug 2017-oct 2017 </div>
                                    <div class="text-center">
                                        <canvas id="chart1" class="chart-canvas"></canvas>
                                    </div>
                                </div>
                                <!-- end card-body -->
                            </div>
                            <!-- end ecom-widget-chart -->
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row -->
                        <!-- end col summery widget -->
                    <!-- end row -->
                </div>
                <!-- end animated fadeIn -->
            </div>
            <!-- end container-fluid -->
        </main>
        <!-- end main -->
    </div>
    <!-- end app-body -->
	<?php $this->load->view('elements/footer'); ?>