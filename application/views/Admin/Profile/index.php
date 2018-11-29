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
                    <a href="<?php echo site_url('Admin/Profile/'); ?>">Profile</a>
                </li>
                <li class="breadcrumb-item">
                   Profile
                </li>
            </ol>
            <div class="container-fluid">
                <div class="animated fadeIn">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header text-theme">
                                    <strong>View/Edit Profile</strong>
                                </div>
								<?php if(!empty($validation_errors) || !empty($error) || $this->session->flashdata('success_msg')) { ?>
								<div class="card-body">
								<?php } ?>
								<?php if(!empty($validation_errors)) { ?>
									<?php foreach($validation_errors as $validation_error) { ?>
										<div class="alert alert-danger alert-dismissible fade show" role="alert">Warning !</strong> <?php echo $validation_error; ?>
											<button type="button" class="close" data-dismiss="alert" aria-label="Close">
												<span aria-hidden="true">×</span>
											</button>
										</div>
									<?php } ?>
								<?php } ?>
								<?php if(!empty($error)) { ?>
									<div class="alert alert-danger alert-dismissible fade show" role="alert">Warning !</strong><?php echo $error; ?>
										<button type="button" class="close" data-dismiss="alert" aria-label="Close">
											<span aria-hidden="true">×</span>
										</button>
									</div>
								<?php } ?>
								<?php if($this->session->flashdata('success_msg')) { ?>
									<div class="alert alert-success alert-dismissible fade show" role="alert">Success ! </strong><?php echo $this->session->flashdata('success_msg'); ?>
										<button type="button" class="close" data-dismiss="alert" aria-label="Close">
											<span aria-hidden="true">×</span>
										</button>
									</div>
								<?php } ?>
								<?php if($this->session->flashdata('error')) { ?>
									<div class="alert alert-danger alert-dismissible fade show" role="alert">Warning ! </strong><?php echo $this->session->flashdata('error'); ?>
										<button type="button" class="close" data-dismiss="alert" aria-label="Close">
											<span aria-hidden="true">×</span>
										</button>
									</div>
								<?php } ?>
								<?php if(!empty($validation_errors) || !empty($error) || $this->session->flashdata('success_msg')) { ?>
								</div>
								<?php } ?>
							</div>
                                    <form action="<?php echo site_url('Admin/Profile/');  ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
										<input type="hidden" name="profile_update" value="true" />
										<input type="hidden" name="id" value="<?php echo $id; ?>" />
										<div class="card-body">
											<div class="form-group row">
												<label class="col-md-3 form-control-label" for="username">Username</label>
												<div class="col-md-9">
													<input type="text" id="username" name="username" class="form-control" placeholder="username" value="<?php echo set_value('username', $username); ?>" required />
												</div>
											</div>
											<div class="form-group row">
												<label class="col-md-3 form-control-label" for="password">Password</label>
												<div class="col-md-9">
													<input type="password" id="password" name="password" class="form-control" placeholder="Password" required />
												</div>
											</div>
										</div>
										<div class="card-footer">
											<button type="submit" class="btn btn-sm btn-primary">
												<i class="fa fa-dot-circle-o"></i> Update
											</button>
											<button type="reset" class="btn btn-sm btn-danger">
												<i class="fa fa-ban"></i> Reset
											</button>
										</div>
                                    </form>
                            </div>
                            <!-- end card -->
                            <!-- end card -->
                        </div>
                        <!-- end col -->
                        <!--/.col-->
                    </div>
                    <!-- end row -->
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