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
                    Users
                </li>
                <li class="breadcrumb-item">
                   All Users
                </li>
            </ol>
            <div class="container-fluid">
                <div class="animated fadeIn">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-accent-theme">
                                <div class="card-body">
                                    <h4 class="text-theme">User Detail</h4>
									<p><small>User information.</small></p>
                                    <br />
                                  
                                </div>
                                <!-- end card-body -->
                            </div>
                            <!-- end card -->
                            <!-- end card -->
                            <!-- end card -->
                        </div>
                        <div class="col-md-8">
							<div class="card card-property-single">
								<div class="card-body">
									<div class="property-details">
										<div class="clearfix">
											<div class="float-left">Email address</div>
											<div class="float-right h5">
												<div class="float-right h5">
												<?php echo $user->email; ?>
												</div>
											</div>
										</div>
										<hr>
										<!-- end clearfix -->
										<div class="clearfix">
											<div class="float-left">IG username</div>
											<div class="float-right h5">
												<?php echo $user->instagram; ?>
											</div>
										</div>
										<hr>
										<!-- end clearfix -->
										<div class="clearfix">
											<div class="float-left">First Name</div>
											<div class="float-right h5">
												<?php echo $user->first_name; ?>
											</div>
										</div>
										<hr>
										<!-- end clearfix -->
										<div class="clearfix">
											<div class="float-left">Last Name</div>
											<div class="float-right h5">
												<div class="float-right h5">
												<?php echo $user->last_name; ?>
												</div>
											</div>
										</div>
										<hr>
										<!-- end clearfix -->
										<div class="clearfix">
											<div class="float-left">Gender</div>
											<div class="float-right h5">
												<div class="float-right h5">
												<?php echo ucfirst($user->gender); ?>
												</div>
											</div>
										</div>
										<hr>
										<!-- end clearfix -->
										<div class="clearfix">
											<div class="float-left">Birth year</div>
											<div class="float-right h5">
												<div class="float-right h5">
												<?php echo $user->birthyear; ?>
												</div>
											</div>
										</div>
										<hr>
										<!-- end clearfix -->
										<div class="clearfix">
											<div class="float-left">Location</div>
											<div class="float-right h5">
												<?php echo $user->location_city.' '.$user->location_state.' '.$user->location_country; ?>
											</div>
										</div>
										<hr>
										<!-- end clearfix -->
									</div>
								</div>
							</div>
							<div class="card card-property-single">
								<div class="card-body">
									<table class="table-hover table-striped table-bordered" width="100%">
										<thead>
											<tr>
												<td>
													Total attempted calls:          
												</td>
												<td>
													<?php echo count($out_going); ?>
												</td>
												<td>
													Total Received calls               
												</td>
												<td>
													<?php echo count($in_coming); ?>
												</td>
											</tr>
											<tr>
												<td>
													Accepted:          
												</td>
												<td>
													<?php echo count($out_going_conn); ?>
												</td>
												<td>
													Accepted:        
												</td>
												<td>
													<?php echo count($in_coming_conn); ?>
												</td>
											</tr>
											<tr>
												<td>
													Rejected:          
												</td>
												<td>
													<?php echo count($out_going)-count($out_going_conn); ?>
												</td>
												<td>
													Rejected:           
												</td>
												<td>
													<?php echo count($in_coming)-count($in_coming_conn); ?>
												</td>
											</tr>
											<tr>
												<td>
													Selective:          
												</td>
												<td>
													<?php echo count($out_going_s); ?>
												</td>
												<td>
													Selective:           
												</td>
												<td>
													<?php echo count($in_coming_s); ?>
												</td>
											</tr>
											<tr>
												<td>
													Random:          
												</td>
												<td>
													<?php echo count($out_going_r); ?>
												</td>
												<td>
													Random:           
												</td>
												<td>
													<?php echo count($in_coming_r); ?>
												</td>
											</tr>
										</thead>
									</table>
									<hr>
									<div class="clearfix">
										<div class="float-left text-dark">
											<div class="h5">
												<strong>Reasons: </strong>
											</div>
										</div>
									</div>
									<hr>
									<div class="clearfix">
										<div class="float-left">Person is nude</div>
										<div class="float-right h5">
											<?php echo isset($reportee_count->person_nude)?$reportee_count->person_nude:0; ?>
										</div>
									</div>
									<hr>
									<div class="clearfix">
										<div class="float-left">Person is mean</div>
										<div class="float-right h5">
											<?php echo isset($reportee_count->person_mean)?$reportee_count->person_mean:0; ?>
										</div>
									</div>
									<hr>
									<div class="clearfix">
										<div class="float-left">Inappropriate video profile</div>
										<div class="float-right h5">
											<?php echo isset($reportee_count->inappropriate)?$reportee_count->inappropriate:0; ?>
										</div>
									</div>
									<hr>
								</div>
							</div>
                        </div>
						<div class="col-md-4">
							<div class="card card-property-single">
								<div class="card-body text-center">
									<a href="javascript:void(0);" onclick="onShowModal('<?php echo  $video_url; ?>');" class="show_v">
										<img src='<?php echo $video_thumb; ?>' class="img-fluid">
									</a>
								</div>
							</div>
							
                        </div>
						<div class="col-md-12">
							<div class="card card-property-single">
								<div class="card-body">
									<div class="property-details">
										<div class="h5 text-dark">
											<strong>Reportee’s Screenshots</strong>
										</div>
										<div class="html-code grid-of-images">
											<div class="popup-gallery">
												<?php if(!empty($reports)){ ?>
												<?php foreach($reports as $key=>$report) { 
												$screenshot = 'https://s3.amazonaws.com/'.$bucket.'/'.$report->screenshot;
												?>
													<a href='<?php echo $screenshot; ?>' title="Screenshots">
														<img src='<?php echo $screenshot; ?>' class="img-thumbnail" width="23%">
													</a>
												<?php } ?>
												<?php } ?>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="card card-property-single">
								<div class="card-body">
									<div class="property-details">
										<div class="h5 text-dark">
											<strong>
												Access History
											</strong>
										</div>
										<table class="table-hover table-striped callTable" width="100%">
											<thead>
												<tr>
													<td>
														Caller’s email         
													</td>
													<td>
														Callee’s email         
													</td>
													<td>
														Status        
													</td>
													<td>
														Duration        
													</td>
												</tr>
											</thead>
											<tbody>
											<?php if(!empty($all_calls)){ 
											?>
											<?php foreach($all_calls as $key=>$call){ ?>
												<tr>
													<td>
														<?php echo $call->CallerEmail; ?>
													</td>
													<td>
														<?php echo $call->CalleeEmail; ?>
													</td>
													<td>
														-
													</td>
													<td>
														<?php echo $call->duration; ?>
													</td>
												</tr>
											<?php } ?>
											<?php } ?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
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
	<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"  aria-hidden="true" style="display: none;" id="myModal">
		<div class="modal-dialog modal-lg">
		 <div class="modal-content">
		<div class="modal-header">
			<h3 id="myModalLabel">Video Profile</h3>
		</div>
		<div class="modal-body">
			<video autoplay controls width="100%" height="500px"  id="myVideo"  onclick="this.paused ? this.play() : this.pause();">
				<source src="" type="video/mp4" id="mp4_src">
				Your browser does not support the video tag.
			</video>
		</div>
		<div class="modal-footer">
			<button class="btn btn-danger waves-effect text-left" data-dismiss="modal" aria-hidden="true" id="btnClose" onclick="onClose()">Close</button>
		</div>
		</div>
		</div>
	</div>
	<script>
		$(document).ready(function(){
			$('.callTable').DataTable({
				 "pageLength": 25
			});
		});
	</script>
	<script>
		function onShowModal(videoUrl) {
			//console.log(videoUrl);
			document.getElementById("mp4_src").src = videoUrl;
			document.getElementById("myVideo").load();

			$('#myModal').modal('show');
			
			setTimeout(function() {
				$(".modal-backdrop").bind("click", function() {
					$("#btnClose").trigger("click");
				})
			}, 500);
		}

		function onClose() {
			document.getElementById("myVideo").pause();
		}
		$(window).click(function() {
			onClose();
		});
	</script>