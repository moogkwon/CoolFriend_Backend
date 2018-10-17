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
                                    <h4 class="text-theme">Users</h4>
									<p><small>Manage users information.</small></p>
                                    <br />
                                    <table class="table table-hover table-striped w-full" id="Ajax_DataTables" width="100%">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>PhoneNumber</th>
                                                <th>Username</th>
                                                <th>Email</th>
                                                <th>Social</th>
                                                <th>Birthday</th>
                                                <th>Gender</th>
                                                <th>LGBTQ</th>
                                                <th>City</th>
                                                <th>State</th>
                                                <th>Country</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                                <th>Created at</th>
                                                <th>Video Profile</th>
                                                <th>Delete</th>
                                            </tr>
                                        </thead>
										<tbody>
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
	<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"  aria-hidden="true"
        style="display: none;" id="myModal">
	<div class="modal-dialog modal-lg">
	 <div class="modal-content">
    <div class="modal-header">
        <h3 id="myModalLabel">Video Profile</h3>
    </div>
    <div class="modal-body">
        <video width="100%" height="500px" controls id="myVideo" autoplay loop>
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
var ajax_datatable;
(function(window, document, $, undefined) {
    $(function() {
        ajax_datatable = $("#Ajax_DataTables").dataTable({
            "processing": true,
            "serverSide": true,
			"pageLength": 200,
			"lengthMenu": [ 200, 500, 1000 ],
			/* "scrollY":        200,
			"deferRender":    true,
			"scroller":       true, */
			"dom": 'Bfrtip',
			"dom": 'lBfrtip',
			"buttons": [
				'excelHtml5',
				'csvHtml5',
			],
			"scrollX": true,
			"order": [[ 0, "desc" ]],
            "ajax": "<?=site_url()?>Admin/Users/getData",
            "columns": [
                { "data": "id" },
                { "data": "phoneNumber" },
                { "data": "firstName" },
                { "data": "email" },
                { "data": "social" },
                { "data": "birthday" },
                { "data": "gender" },
                { "data": "lgbtq" },
                { "data": "city" },
                { "data": "state" },
                { "data": "country" },
                { "data": "activated" },
                { "data": "action" },
                { "data": "created_at" },
                { "data": "videoshow" },
                { "data": "delete_user" ,"orderable": false},
            ]
        });

        $('#Ajax_DataTables').on( 'draw.dt', function () {
            $(".btn-approve").unbind("click");
            $(".btn-reject").unbind("click");
            
            $(".btn-approve").bind("click", function() {
                changeStatus($(this).attr("data-id"), 1);
                return false;
            });
            
            $(".btn-reject").bind("click", function() {
                changeStatus($(this).attr("data-id"), -1);
                return false;
            });
        });
    });
})(window, document, window.jQuery);

function changeStatus(id, status) {
    $.ajax({
        url: "<?=site_url()?>Admin/Users/changeStatus/" + id + "/" + status,
        method: "POST",
        success: function(data) {
            ajax_datatable.fnClearTable();
        }
    })
}

function deleteUser(user_id){
	if(user_id){
		if(confirm('Are you sure ?')){
			$.ajax({
				url: "<?=site_url()?>Admin/Users/deleteUser/" + user_id,
				method: "POST",
				success: function(data) {
					ajax_datatable.fnClearTable();
				}
			})
		}
	}
}
function onShowModal(videoUrl) {
	console.log(videoUrl);
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
</script>