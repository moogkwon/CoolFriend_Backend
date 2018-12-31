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
                        <div class="col-md-12">
                            <div class="card card-accent-theme">
                                <div class="card-body">
                                    <table class="table table-hover table-striped w-full" id="noti_tables" width="100%">
                                        <thead>
											<tr>
                                                <th>ID</th>
                                                <th>User ID</th>
                                                <th>Notification Title</th>
												<th>Country</th>
												<th>State</th>
												<th>City</th>
                                                <th>Notification Type</th>
                                                <th>Notification Status</th>
                                                <th>Date Added</th>
                                               
                                            </tr>
                                        </thead>
                                        <tbody>
											<?php
											if(!empty($notifications)){ 
											foreach($notifications as $key=>$notification){ 
											?>
											<tr>
                                                <td><?php echo $notification->id; ?></td>
												<td><?php echo $notification->user_ids; ?></td>
                                                <td><?php echo $notification->title; ?></td>
                                                <td><?php echo $notification->country; ?></td>
                                                <td><?php echo $notification->state; ?></td>
                                                <td><?php echo $notification->city; ?></td>
                                                <td><?php echo $notification->type_title; ?></td>
                                                
                                                <td><?php echo $status_arr[$notification->status]; ?></td>
                                                <td><?php echo $notification->added_date; ?></td>
                                                
                                            </tr>
											<?php } } ?>
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
		var ajax_datatable;
	(function(window, document, $, undefined) {
		$(function() {
			ajax_datatable = $("#noti_tables").dataTable({
				 "order": [[ 0, "desc" ]]
			});
		});
	})(window, document, window.jQuery);
	</script>