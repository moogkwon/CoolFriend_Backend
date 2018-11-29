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
                    Access History
                </li>
            </ol>
            <div class="container-fluid">
                <div class="animated fadeIn">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-accent-theme">
                                <div class="card-body">
                                    <h4 class="text-theme">
										Access History
									</h4>
									<p><small>Manage access information.</small></p>
                                    <br />
                                    <table class="table table-hover dataTable table-striped w-full" data-plugin="dataTable" width="100%">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Session Id</th>
                                                <th>Username</th>
                                                <th>Phone Number</th>
                                                <th>Access Type</th>
                                                <th>Created at</th>
                                            </tr>
                                        </thead>
                                        <tbody>
											<?php if(!empty($accesses)) { 
											 
											?>
												<?php foreach($accesses as $key=>$access) { ?>
													<tr>
														<td>
															<?php echo $access->id; ?>
														</td>
														<td>
															<?php echo $access->sessionId;?>
														</td>
														<td>
															<?php echo $access->Username; ?>
														</td>
														<td>
															<?php echo $access->phoneNumber; ?>
														</td>
														<td>
															<?php echo $access->type; ?>
														</td>
														<td>
															<?php echo date("Y-m-d H:i:s",strtotime($access->created_at)); ?>
														</td>
														
													</tr>
												<?php } ?>
											<?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- end card-body -->
                            </div>
                            <!-- end card -->
                            <!-- end card -->
                            <!-- end card -->
                        </div>
                        <!-- end col -->
                        <!--/.col-->
                    </div>
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