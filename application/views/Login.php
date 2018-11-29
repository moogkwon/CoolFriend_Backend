<?php $this->load->view('elements/header'); ?>
<body>
    <section class="container-pages">
        <div class="brand-logo float-left">
			<a class="" href="<?php echo base_url(); ?>">
				<?php echo SITE_TITLE; ?>
			</a>
		</div>
        <div class="pages-tag-line text-white">  
            <div class="h4">Let's Get Started .!</div>
            <small> most powerfull most selling Admin Panel In The World</small>
        </div>
        <div class="card pages-card col-lg-4 col-md-6 col-sm-6">
            <div class="card-body ">
                <div class="h4 text-center text-theme"><strong>Login</strong></div>
                <div class="small text-center text-dark"> Login to Account </div>
					<p>
						<?php echo validation_errors(); ?>
					</p>
					<p>
						<?php if(!empty($error)) { echo $error; } ?>
					</p>
                    <?php echo form_open('/Login');?>
						<input type="hidden" name="user_login" value="user_login" />
                        <div class="form-group">
                            <div class="input-group">
                                 <span class="input-group-addon text-theme"><i class="fa fa-user"></i> 
                                </span>
                                <input type="email" id="email" name="email" class="form-control" placeholder="Email"  autocomplete="new-email" />
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon text-theme"><i class="fa fa-asterisk"></i></span>
                                <input type="password" id="password" name="password" class="form-control" placeholder="Password" />
                            </div>
                        </div>
                        <div class="form-group form-actions">
                            <button type="submit" name="userLogin" class="btn btn-theme login-btn ">
								Login   
							</button>
                        </div>
                    <?php echo form_close(); ?>
            </div>
            <!-- end card-body -->
        </div>
        <!-- end card -->
    </section>
    <!-- end section container -->
    <div class="half-circle"></div>
    <div class="small-circle"></div>
    <div id="mybutton">
	</div>
         <!-- end mybutton -->
	<?php $this->load->view('elements/login_footer'); ?>