<?php $this->load->view('admin/layout/header'); ?>

<!-- Datatables-->
<link rel="stylesheet" href="<?=base_url()?>asset/vendor/datatables.net-bs4/css/dataTables.bootstrap4.css">
<link rel="stylesheet" href="<?=base_url()?>asset/vendor/datatables.net-keytable-bs/css/keyTable.bootstrap.css">
<link rel="stylesheet" href="<?=base_url()?>asset/vendor/datatables.net-responsive-bs/css/responsive.bootstrap.css">


<!-- Page content-->
<div class="content-wrapper">
    <div class="content-heading">
        <div>Report Management
            <small>Manage reports information.</small>
        </div>
    </div>
    <!-- START row-->
    <div class="row">
        <div class="col-md-12">
            <!-- START card-->
            <div class="card card-default">
                <div class="card-header">Report List</div>
                <div class="card-body">
                    <table class="table table-striped" id="Ajax_DataTables">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>PhoneNumber</th>
                                <th>Reporter username</th>
                                <th>Reporter Phonenumber</th>
                                <th>Report</th>
                                <th>Created at</th>
                                <th>Report Image</th>
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
        <h3 id="myModalLabel">Report Image</h3>
    </div>
    <div class="modal-body">
        <img id="myImage" src="" width="100%">
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true" id="btnClose">Close</button>
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
            "ajax": "<?=base_url()?>admin/report/getData",
            "columns": [
                { "data": "id" },
                { "data": "userName" },
                { "data": "userPhone" },
                { "data": "reporterName" },
                { "data": "reporterPhone" },
                { "data": "report" },
                { "data": "created_at" },
                { "data": "videoshow" },
            ]
        });
        ajax_datatable.on("click",'tr', function (event) {
            var id = $($(this).children()[0]).html();
        });
    });
})(window, document, window.jQuery);


function onShowModal(text, imageUrl) {
    $("#myModalLabel").html(text);
    document.getElementById("myImage").src = imageUrl;

    $('#myModal').modal('show');
    
    setTimeout(function() {
        $(".modal-backdrop").bind("click", function() {
            $("#btnClose").trigger("click");
        })
    }, 500);
}
</script>