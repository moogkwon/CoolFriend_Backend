$(document).ready(function(){
	$('.data_table_init').dataTable({
		'order': [[0, 'desc']],
	});
	$('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        startDate: '-3d'
    });
	$('.editor').summernote({
		tabsize: 5,
		focus: true,
		height: 500
	});
	var noti_table = $("#noti_table").dataTable({
		"ordering" : true,
		"columnDefs": [{
            "searchable": false,
            "orderable": false,
            "targets": 0
        }],
		'order': [[1, 'desc']],
	});
	$("#all").on('click', function() { 
		var cells = noti_table.api().cells().nodes();
		$(cells).find('.checkboxclass').prop('checked', this.checked);
		if(this.checked){
			//alert('sds');
			if($('.checkboxclass:checked').length)
			$('.delete_noti,.send_noti').removeAttr('disabled');
		}else{
			$('.delete_noti,.send_noti').attr('disabled','disabled');
		}
	});
	$('.checkboxclass').change(function() {
		if ($('.checkboxclass:checked').length) {
			$('.delete_noti,.send_noti').removeAttr('disabled');
		} else {
			$('.delete_noti,.send_noti').attr('disabled', 'disabled');
		}
	});
	$('.delete_noti').click(function(){
		if(confirm('Are you sure ?')){
			var selected_arr = [];
			$("input:checkbox[name=selected_id]:checked").each(function(){
				selected_arr.push($(this).val());
			});
			if(selected_arr.length){
				$.ajax({
					url: site_url+'Admin/Notifications/deleteData',
					data: {action: 'delete_noti',ids: selected_arr},
					type: 'POST',
					success: function(res){
						location.href=site_url+'Admin/Notifications/';
					}
				});
			}
		}
	});
	$('.send_noti_now').click(function(){
		if(confirm('Are you sure ?')){
			var selected_arr = [];
			$("input:checkbox[name=selected_id]:checked").each(function(){
				selected_arr.push($(this).val());
			});
			if(selected_arr.length){
				$.ajax({
					url: site_url+'Admin/Notifications/Send',
					data: {action: 'send_noti',ids: selected_arr},
					type: 'POST',
					success: function(res){
						if(res=='sent')
						location.href=site_url+'Admin/Notifications/';
					}
				});
			}
		}
	});
	$(document).on("click",'.openEditModel',function(){
		var noti_id = $(this).attr('noti_id');
		$.ajax({
			url: site_url+'Admin/Notifications/getDataByID',
			data: {action: 'edit_noti',noti_id: noti_id},
			type: 'POST',
			success: function(res){
				$('#empModal .modal-body').html(res);
				$("#empModal").modal('show');
			}
		});
	});
	$(document).on("change",'#country_id',function(){
		var country_id = $(this).val();
		if(country_id){
			$.ajax({
				url: site_url+'Admin/General/getStates',
				data: {action: 'get_state',country_id: country_id},
				type: 'POST',
				success: function(res){
					$('#state_id').html(res);
				}
			});
		}
	});
	$(document).on("change",'#state_id',function(){
		var state_id = $(this).val();
		if(state_id){
			$.ajax({
				url: site_url+'Admin/General/getCities',
				data: {action: 'get_city',state_id: state_id},
				type: 'POST',
				success: function(res){
					$('#city_id').html(res);
				}
			});
		}
	});
});