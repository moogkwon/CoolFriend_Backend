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
                    Most reported users
                </li>
            </ol>
            <div class="container-fluid">
                <div class="animated fadeIn">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-accent-theme">
                                <div class="card-body">
                                    <h4 class="text-theme">Most Reported Users</h4>
									<p><small>Manage reported users information.</small></p>
                                    <br />
                                    <table class="table table-hover rdataTable table-striped w-full" width="100%">
                                        <thead>
                                            <tr>
												<th>User ID</th>
												<th>Total</th>
												<th>Email</th>
												<th>The person is nude  </th>
												<th>Person is mean</th>
												<th>Inappropriate video profile</th>
												<th>Other</th>
												<th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
											<?php if(!empty($reports)) { 
											?>
												<?php foreach($reports as $key=>$report) { 
												if(!empty($report->screenshot)){
													$reportImage = 'https://s3.amazonaws.com/'.$this->s3Bucket.'/'.$report->screenshot;
													//$reportImage = $report->screenshot;
												}else{
													$reportImage = base_url().'assets/img/img1.jpg';
												}
												if($report->blocked==1){
													$status = 'Unblock';
													$class = 'btn-approve';
												}else{
													$status = 'Block';
													$class 	= 'btn-reject';
												}
												$other = $report->total-($report->person_nude+$report->person_mean+$report->inappropriate);
												?>
													<tr>
														<td>
															<a href="<?php echo site_url('Admin/Users/View/'.$report->suspect); ?>"><?php echo $report->suspect; ?></a>
														</td>
														<td>
															<?php echo $report->total; ?>
														</td>
														<td>
															<?php echo $report->email; ?>
														</td>
														<td>
															<?php echo $report->person_nude; ?>
														</td>
														<td>
															<?php echo $report->person_mean; ?>
														</td>
														<td>
															<?php echo $report->inappropriate; ?>
														</td>
														<td>
															<?php echo $other; ?>
														</td>
														<!--td>
															<a href="<?php echo $reportImage; ?>" class="image-popup-vertical-fit">
															<img src="<?php echo $reportImage; ?>" class="img-fluid" width="50px">
															</a>
														</td-->
														<!--td>
															<?php echo $report->reporterName; ?>
														</td>
														<td>
															<?php echo $report->reporterName; ?>
														</td>
														<td>
															<?php echo $report->reporterlName; ?>
														</td>
														<!--td>
															<?php echo $report->reporterPhone; ?>
														</td-->
														<!--td>
															<?php echo $report->reporterEmail; ?>
														</td>
														<td>
															<?php echo $report->userName;?>
														</td>
														<!--td>
															<?php echo $report->userPhone; ?>
														</td>
														<td>
															<?php echo $report->userEmail; ?>
														</td-->
														<td>
														<a class="<?php echo $class; ?>" href="javascript:void(0);"
														userid = "<?php echo $report->suspect; ?>"
														>
														<?php echo $status; ?>
														</a>
														</td>
														<!--td>
															<?php echo $report->dated; ?>
														</td-->
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
	<script>
		$(document).ready(function(){
			$('.rdataTable').DataTable( {
				"order": [[ 0, "desc" ]],
				 "scrollX": true
			} );
			$(document).on('click','.btn-approve',function(){
                changeStatus(this,$(this).attr("userid"), 0);
                return false;
            });
            $(document).on('click','.btn-reject',function(){
                changeStatus(this,$(this).attr("userid"), 1);
                return false;
            });
		});
		function changeStatus(thisObj,id, status) {
			$.ajax({
				url: "<?php echo base_url(); ?>/Admin/Users/changeStatus/" + id + "/" + status,
				method: "POST",
				success: function(data) {
					if(status == '1'){
						$(thisObj).text('Unblock');
						$(thisObj).removeClass('btn-reject').addClass('btn-approve');
						//console.log(status);
					}else{
						$(thisObj).text('Block');
						$(thisObj).removeClass('btn-approve').addClass('btn-reject');
						//console.log(status);
					}
				}
			});
		}
	</script>