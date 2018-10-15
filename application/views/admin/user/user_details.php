<?php $this->load->view('admin/layout/header'); ?>

<!-- Datatables-->
<link rel="stylesheet" href="<?=base_url()?>asset/vendor/datatables.net-bs4/css/dataTables.bootstrap4.css">
<link rel="stylesheet" href="<?=base_url()?>asset/vendor/datatables.net-keytable-bs/css/keyTable.bootstrap.css">
<link rel="stylesheet" href="<?=base_url()?>asset/vendor/datatables.net-responsive-bs/css/responsive.bootstrap.css">


<!-- Page content-->
<div class="content-wrapper">
    <div class="content-heading">
        <div>User
            <small>User Information</small>
        </div>
    </div>
    <!-- START row-->
    <div class="row">
        <div class="col-md-12">
            <!-- START card-->
            <div class="card card-default">
                <div class="card-header">User Information</div>
                    <div class="card-body">
                        <div class="row py-4 justify-content-center">
                            <div class="col-12 col-sm-10">
                                <div class="form-horizontal">
                                    <div class="form-group row">
                                        <label class="text-bold col-xl-2 col-md-3 col-4 col-form-label text-right">Name</label>
                                        <div class="col-xl-10 col-md-9 col-8">
                                            <label class="col-form-label"><?=$user->username?></label>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="text-bold col-xl-2 col-md-3 col-4 col-form-label text-right" for="inputUsername">Email</label>
                                        <div class="col-xl-10 col-md-9 col-8">
                                            <label class="col-form-label"><?=$user->email?></label>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="text-bold col-xl-2 col-md-3 col-4 col-form-label text-right" for="inputUsername">ETH Address</label>
                                        <div class="col-xl-10 col-md-9 col-8">
                                            <label class="col-form-label">
                                                <a href="https://etherscan.io/address/<?=$user->eth_address?>" target="_blank"><?=$user->eth_address?></a></label>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row">
                                        <label class="text-bold col-xl-2 col-md-3 col-4 col-form-label text-right" for="inputUsername">Status</label>
                                        <div class="col-xl-10 col-md-9 col-8">
                                            <label class="col-form-label"><?=$status [$user->activated]?></label>
                                        </div>
                                    </div>
                                    <?php
                                    foreach(C_TABS as $tabId => $tabName) { ?>
                                    <div class="form-group row">
                                        <label class="text-bold col-xl-2 col-md-3 col-4 col-form-label text-right" for="inputUsername"><?=$tabName?> account</label>
                                        <div class="col-xl-10 col-md-9 col-8">
                                            <label class="col-form-label"><?=isset($user->social_accounts [$tabName]) ? $user->social_accounts [$tabName] : ""?></label>
                                        </div>
                                    </div>
                                    <?php }?>
                                    <div class="form-group row">
                                        <label class="text-bold col-xl-2 col-md-3 col-4 col-form-label text-right" for="inputUsername">Status</label>
                                        <div class="col-xl-10 col-md-9 col-8">
                                            <label class="col-form-label"><?=$status [$user->activated]?></label>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-10">
                                            <a href="<?=base_url()?>admin/user"><button class="btn btn-info">Back to List</button></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END row-->
</div>


<?php $this->load->view('admin/layout/footer'); ?>
