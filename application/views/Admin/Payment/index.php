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
                    Payment
                </li>
                <li class="breadcrumb-item">
                   All Payment
                </li>
            </ol>
            <div class="container-fluid">
                <div class="animated fadeIn">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-accent-theme">
                                <div class="card-body">
                                    <h4 class="text-theme">Payment</h4>
									<p><small>Manage payment information.</small></p>
                                    <br />
                                    <table class="table table-hover dataTable table-striped w-full" data-plugin="dataTable" width="100%">
                                        <thead>
                                             <tr>
                                                <th>ID</th>
                                                <th>Username</th>
                                                <th>Cup Count</th>
                                                <th>Price</th>
                                                <th>Used</th>
                                                <th>Purchased at</th>
                                            </tr>
                                        </thead>
                                        <tbody>
											<?php if(!empty($payments)) { 
											 
											?>
												<?php foreach($payments as $key=>$payment) { ?>
													<tr>
														
														<td>
															<?php echo $payment->id; ?>
														</td>
														<td>
															<?php echo $payment->Username;?>
														</td>
														<td>
															<?php echo $payment->cup_count; ?>
														</td>
														<td>
															<?php echo $payment->price; ?>
														</td>
														<td>
															<?php echo $payment->used_cup; ?>
														</td>
														<td>
															<?php echo date('Y-m-d H:i:s',strtotime($payment->created_at)); ?>
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