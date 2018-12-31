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
                    Random History
                </li>
            </ol>
            <div class="container-fluid">
                <div class="animated fadeIn">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-accent-theme">
                                <div class="card-body">
                                    <h4 class="text-theme">
										Random History
									</h4>
									<p><small>Manage Random Information.</small></p>
                                    <br />
                                     <table class="table table-hover table-striped w-full" id="Ajax_DataTables1" width="100%">
                                        <thead>
                                           <tr>
                                                <th>Caller’s User ID</th>
                                                <th>Caller’s video profile</th>
                                                <th>Gender</th>
                                                <th>Callee’s User ID</th>
                                                <th>Callee’s video profile</th>
                                                <th>Call</th>
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
		<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"  aria-hidden="true"
        style="display: none;" id="myModal">
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
		var ajax_datatable1;
	(function(window, document, $, undefined) {
		$(function() {
			ajax_datatable1 = $("#Ajax_DataTables1").dataTable({
				"processing": true,
				"serverSide": true,
				"scrollX": true,
				"bLengthChange" : false,
				"bPaginate": false,
				"order": [[ 0, "desc" ]],
				"ajax": {
						url: "<?=site_url()?>Admin/Call/getData",
						data: { type: 'random' },
				},
				"columns": [
					{ "data": "callerId" },
					{ "data": "callerVideo" },
					{ "data": "callerGender" },
					{ "data": "calleeId" },
					{ "data": "calleeVideo" },
					{ "data": "call_status" },
					{ "data": "duration" },
				]
			});
			$('#Ajax_DataTables').on( 'draw.dt', function () {
				$(".show_v").unbind("click");
				$('.show_v').bind("click", function(event) {
					event.stopPropagation();
				});
			});
		});
	})(window, document, window.jQuery);
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