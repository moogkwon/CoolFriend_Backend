<?php $this->load->view('admin/layout/header'); ?>

<!-- Datatables-->
<link rel="stylesheet" href="<?=base_url()?>asset/vendor/datatables.net-bs4/css/dataTables.bootstrap4.css">
<link rel="stylesheet" href="<?=base_url()?>asset/vendor/datatables.net-keytable-bs/css/keyTable.bootstrap.css">
<link rel="stylesheet" href="<?=base_url()?>asset/vendor/datatables.net-responsive-bs/css/responsive.bootstrap.css">


<!-- Page content-->
<div class="content-wrapper">
    <div class="content-heading">
        <div>User Management
            <small>Manage users information.</small>
        </div>
    </div>
    <!-- START row-->
    <div class="row">
        <div class="col-md-12">
            <!-- START card-->
            <div class="card card-default">
                <div class="card-header">User List</div>
                <div class="card-body">
                    <table class="table table-striped" id="Ajax_DataTables">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>PhoneNumber</th>
                                <th>FirstName</th>
                                <th>Birthday</th>
                                <th>Gender</th>
                                <th>Location</th>
                                <th>Status</th>
                                <th>Action</th>
                                <th>Created at</th>
                                <th>Video Profile</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- END card-->
        </div>
    </div>
    <!-- END row-->
</div>


<?php $this->load->view('admin/layout/footer'); ?>

<div id="myModal" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
        <button class="btn" data-dismiss="modal" aria-hidden="true" id="btnClose" onclick="onClose()">Close</button>
    </div>
</div>

<!-- Datatables-->
<script src="<?=base_url()?>asset/vendor/datatables.net/js/jquery.dataTables.js"></script>
<script src="<?=base_url()?>asset/vendor/datatables.net-bs4/js/dataTables.bootstrap4.js"></script>
<script src="<?=base_url()?>asset/vendor/datatables.net-buttons/js/dataTables.buttons.js"></script>
<script src="<?=base_url()?>asset/vendor/datatables.net-buttons-bs/js/buttons.bootstrap.js"></script>
<script src="<?=base_url()?>asset/vendor/datatables.net-buttons/js/buttons.colVis.js"></script>
<script src="<?=base_url()?>asset/vendor/datatables.net-buttons/js/buttons.flash.js"></script>
<script src="<?=base_url()?>asset/vendor/datatables.net-buttons/js/buttons.html5.js"></script>
<script src="<?=base_url()?>asset/vendor/datatables.net-buttons/js/buttons.print.js"></script>
<script src="<?=base_url()?>asset/vendor/datatables.net-keytable/js/dataTables.keyTable.js"></script>
<script src="<?=base_url()?>asset/vendor/datatables.net-responsive/js/dataTables.responsive.js"></script>
<script src="<?=base_url()?>asset/vendor/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>


<script>
var ajax_datatable;
(function(window, document, $, undefined) {
    $(function() {
        ajax_datatable = $("#Ajax_DataTables").dataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "<?=base_url()?>admin/user/getData",
            "columns": [
                { "data": "no" },
                { "data": "phoneNumber" },
                { "data": "firstName" },
                { "data": "birthday" },
                { "data": "gender" },
                { "data": "location" },
                { "data": "activated" },
                { "data": "action" },
                { "data": "created_at" },
                { "data": "videoshow" },
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
        url: "<?=base_url()?>admin/user/changeStatus/" + id + "/" + status,
        method: "POST",
        success: function(data) {
            ajax_datatable.fnClearTable();
        }
    })
}

function onShowModal(videoUrl) {
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