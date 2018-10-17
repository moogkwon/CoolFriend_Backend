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
                    Calls
                </li>
                <li class="breadcrumb-item">
                   All Calls
                </li>
            </ol>
            <div class="container-fluid">
                <div class="animated fadeIn">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-accent-theme">
                                <div class="card-body">
                                    <h4 class="text-theme">Calls</h4>
									<p><small>Manage call information.</small></p>
                                    <br />
                                    <table class="table table-hover table-striped w-full" id="Ajax_DataTables1" width="100%">
                                        <thead>
                                           <tr>
                                                <th>ID</th>
                                                <th>Type</th>
                                                <th>CallerName</th>
                                                <th>Caller Email</th>
                                                <th>CalleeName</th>
                                                <th>Callee Email</th>
                                                <th>Connected at</th>
                                                <th>End at</th>
                                                <th>Duration</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
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
		var ajax_datatable1;
	(function(window, document, $, undefined) {
		$(function() {
			ajax_datatable1 = $("#Ajax_DataTables1").dataTable({
				"processing": true,
				"serverSide": true,
				"scrollX": true,
				"order": [[ 0, "desc" ]],
				"ajax": "<?=site_url()?>Admin/Call/getData",
				"columns": [
					{ "data": "id" },
					{ "data": "type" },
					{ "data": "callerName" },
					{ "data": "callerEmail" },
					{ "data": "calleeName" },
					{ "data": "calleeEmail" },
					{ "data": "connected_at" },
					{ "data": "end_at" },
					{ "data": "duration" },
				]
			});
		});
	})(window, document, window.jQuery);
	</script>