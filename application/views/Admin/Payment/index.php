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
                                                <th>User ID</th>
                                                <th>Email</th>
                                                <th>Amount</th>
                                                <th>Currency</th>
                                                <th>Package</th>
                                                <th>Duration</th>
                                                <th>Date</th>
                                                <th>Expiry</th>
                                            </tr>
                                        </thead>
                                        <tbody>
											<?php if(!empty($payments)) { 
											 
											?>
												<?php foreach($payments as $key=>$payment) { 
												if($payment->gender == 'male'){
													$style = 'color: blue';
												}else{
													$style = 'color: red';
												}
												?>
													<tr>
														<td>
															<a href='<?php echo site_url('Admin/Users/View/'.$payment->user_id); ?>' style="<?php echo $style; ?>"><?php echo $payment->user_id; ?></a>
														</td>
														<td>
															<?php echo $payment->email;?>
														</td>
														<td>
															<?php echo $payment->amount; ?>
														</td>
														<td>
															<?php echo $payment->currency; ?>
														</td>
														<td>
															<?php echo $payment->package; ?>
														</td>
														<td>
															<?php echo $payment->duration; ?>
														</td>
														<td>
															<?php echo $payment->dated; ?>
														</td>
														<td>
															<?php echo $payment->expire; ?>
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