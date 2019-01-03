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
                    Notifications
                </li>
                <li class="breadcrumb-item">
                   All Notifications
                </li>
            </ol>
            <div class="container-fluid">
                <div class="animated fadeIn">
                    <div class="row">
						<div class="col-md-4">
							<div class="card-body">
								<h4 class="text-theme">Notifications</h4>
								<p><small>Manage Notifications information.</small></p>
							</div>
						</div> 
						<div class="col-md-4 text-center">
							<div class="card-body">
							<?php if($this->session->flashdata('success')){ ?>
								<div class="alert alert-warning alert-dismissible fade show" role="alert">
									<?php echo $this->session->flashdata('success'); ?>
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
										<span aria-hidden="true">×</span>
									</button>
                                </div>
							<?php } ?>
							
							</div>
						</div>
						<div class="col-md-4">
							
						</div> 
					</div>
						<form action="<?php echo site_url('Admin/Notifications/Confirm'); ?>" method="post">
					<div class="row">
                        <div class="col-md-8">
                            <div class="card card-accent-theme">
                                <div class="card-body">
								<?php if(!empty($user_checks)){  ?>
									<div class="alert alert-warning alert-dismissible fade show" role="alert">
										These users will be get notifications. Confirm and send to the users.									
									</div>
								<?php } ?>
                                    <table class="table table-hover table-striped w-full" width="100%">
                                        <thead>
											<tr>
                                                <th>User ID</th>
                                                <th>Name</th>
                                                <th>Gender</th>
                                                <th>Birthyear</th>
                                                <th>LGBTQ</th>
                                                <th><input type="checkbox" id="checkAll" checked ></th>
                                            </tr>
                                        </thead>
                                        <tbody>
											<?php
											if(!empty($user_checks)){ 
											foreach($user_checks as $key=>$user_check){ 
											?>
											<tr>
                                                <td><?php echo $user_check->id; ?></td>
                                                <td><?php echo $user_check->first_name; ?> <?php echo $user_check->last_name; ?></td>
                                                <td><?php echo ucfirst($user_check->gender); ?></td>
                                                <td><?php echo $user_check->birthyear; ?></td>
                                                <td><?php echo $user_check->lgbtq==1?'Yes':'No'; ?></td>
												<td><input type="checkbox" name="checked_user[]" value="<?php echo $user_check->id; ?>" checked></td>
                                            </tr>
											<?php } } ?>
										</tbody>
                                    </table>
									
										<input type="hidden" name="confirm_submit" value="true" >
										<?php if($user_ids) { ?>
										<?php foreach($user_ids as $key=>$user_id){ ?>
										<input type="hidden" name="user_ids[]" value="<?php echo $user_id; ?>" >
										<?php } ?>
										<?php } ?>
										<?php foreach($form_data as $key=>$f_data){ ?>
										<input type="hidden" name="<?php echo $key; ?>" value="<?php echo $f_data; ?>" >
										<?php } ?>
										<button class="btn btn-primary" type="submit">Confirm and send</button>
									
                                </div>
                                <!-- end card-body -->
                            </div>
                            <!-- end card -->
                            <!-- end card -->
                            <!-- end card -->
                        </div>
						<div class="col-md-4">
                            <div class="card card-accent-theme">
                                <div class="card-body">
								<?php if(!empty($filtered_notis)){  ?>
									<div class="alert alert-warning alert-dismissible fade show" role="alert">
										Following notifications will be send								
									</div>
								<?php } ?>
								
                                    <table class="table table-hover table-striped w-full" width="100%">
                                        <thead>
											<tr>
                                                <th>Notification ID</th>
                                                <th>Title</th>
                                                <th>Type</th>
                                            </tr>
                                        </thead>
                                        <tbody>
											<?php
											if(!empty($filtered_notis)){ 
											foreach($filtered_notis as $key=>$filtered_noti){ 
											?>
											<tr>
                                                <td><?php echo $filtered_noti->id; ?></td>
                                                <td><?php echo $filtered_noti->title; ?></td>
                                                <td><?php echo $filtered_noti->type_title; ?></td>
                                            </tr>
											<?php } } ?>
										</tbody>
                                    </table>
									
										<input type="hidden" name="confirm_submit" value="true" >
										<?php if($user_ids) { ?>
										<?php foreach($user_ids as $key=>$user_id){ ?>
										<input type="hidden" name="user_ids[]" value="<?php echo $user_id; ?>" >
										<?php } ?>
										<?php } ?>
										<?php foreach($form_data as $key=>$f_data){ ?>
										<input type="hidden" name="<?php echo $key; ?>" value="<?php echo $f_data; ?>" >
										<?php } ?>
										<button class="btn btn-primary" type="submit">Confirm and send</button>
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
						</form>
                    
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
		$("#checkAll").click(function () {
			 $('input:checkbox').not(this).prop('checked', this.checked);
		});
	});
	</script>