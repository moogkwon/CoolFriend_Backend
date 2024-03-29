<?php $this->load->view('client/layout/header.php') ?>
<div class="content-wrapper">
	<div class="content-heading">
		<div>Profile
			<small>Profile submits</small>
		</div>
	</div>
	<div class="row">
		<div class="col-md-5 left">
			<!-- START card-->
			<div class="card card-default">
				<div class="card-header profile_content">Update Profile</div>
				<div class="card-body">
				<?php echo form_open_multipart(base_url().'profile_update',array('class' => 'mb-3','id'=>'registerForm','method'=>'post', 'enctype'=>'multipart/form-data')); ?>
						<div class="form-group">
							<label>Eth Address</label>
							<p><a class="block" href="https://etherscan.io/address/<?=$this->session->userdata("user")->eth_address?>" target="_blank">
								<?=$this->session->userdata("user")->eth_address?></a></p>
						</div>
						<div class="form-group">
							<label>Email</label>
							<input name="email" class="form-control" type="text" value=<?= $email ?> disabled>
						</div>
						<div class="form-group">
							<label>User Name</label>
							<input name="username" class="form-control" type="text" value=<?= $username ?>>
						</div>
						<?php
						foreach(C_TABS as $tabId => $tabName) { ?>
						<div class="form-group">
							<label><?=$tabName?> address</label>
							<input name="social_accounts[<?=$tabName?>]" class="form-control" type="text" 
								value="<?= isset($social_accounts [$tabName]) ? $social_accounts [$tabName] : ""?>">
						</div>
						<?php }?>
						<div class="form-group">
							<label><strong>PROFILE PHOTO</strong></label>                                      
							<div class="fileinput fileinput-new" data-provides="fileinput">
								<div class="fileinput-new thumbnail" style="width: 150px;" >
									<?php if ($avatar != '') : ?>
										<img class="avatar" width="100px" height="100px" src="<?php echo base_url().'asset/uploads/'.$avatar; ?>" >	
									<?php else: ?>
										<img src="http://placehold.it/100x100" alt="Please Connect Your Internet">     
									<?php endif; ?>                                 
								</div>
								<div>
									<span class="fileinput-new">
										<input type="file" name="avatar" size="20" />
									</span>
								</div>
								<div id="valid_msg" style="color: #e11221"></div>
							</div>  
						</div>
						<div class="row">
							<button class="offset-md-5 btn btn-oval btn-primary" type="submit">Change Profile</button>
						</div>
					</form>
				</div>
			</div>
			<!-- END card-->
		</div>
		<div class="col-md-5 left">
			<!-- START card-->
			<div class="card card-default">
				<div class="card-header profile_content">Change Password</div>
				<div class="card-body">
				<?php echo form_open(base_url().'change_password',array('method'=>'post')); ?>
						<div class="form-group">
							<label class="text-muted" for="signupInputPassword2">Old Password</label>
							<div class="input-group with-focus">
								<input name="oldpassword" class="form-control border-right-0" id="signupInputPassword2" type="password" placeholder="Old Password" autocomplete="off" required>
								<div class="input-group-append">
								<span class="input-group-text fa fa-lock text-muted bg-transparent border-left-0"></span>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="text-muted" for="signupInputPassword1">Password</label>
							<div class="input-group with-focus">
								<input name="password" class="form-control border-right-0" id="signupInputPassword1" type="password" placeholder="Password" autocomplete="off" required>
								<div class="input-group-append">
								<span class="input-group-text fa fa-lock text-muted bg-transparent border-left-0"></span>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="text-muted" for="signupInputRePassword1">Retype Password</label>
							<div class="input-group with-focus">
								<input name="repassword" class="form-control border-right-0" id="signupInputRePassword1" type="password" placeholder="Retype Password" autocomplete="off" required data-parsley-equalto="#signupInputPassword1">
								<div class="input-group-append">
								<span class="input-group-text fa fa-lock text-muted bg-transparent border-left-0"></span>
								</div>
							</div>
						</div>
						<div class="row">
							<button class="offset-md-5 btn btn-oval btn-primary" type="submit">Change Password</button>
						</div>
					</form>
				</div>
			</div>
			<!-- END card-->
		</div>
	</div>
</div>

<!-- PARSLEY-->

<?php $this->load->view('client/layout/footer.php') ?>
<script src="<?=base_url()?>asset/js/client/toastr.min.js"></script>
<?php echo message_box('error'); ?>
<?php echo message_box('success'); ?>

