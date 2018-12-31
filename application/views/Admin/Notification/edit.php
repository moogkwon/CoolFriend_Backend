	<div class="col-sm-12">
		<form action="<?php echo site_url('Admin/Notifications/Update/'.$notification->id); ?>" method="post">
			<input type="hidden" name="update_noti" value="true" />
			<div class="card">
				<div class="card-header text-theme">
					<strong>Notification</strong>
					<small>Form</small>
				</div>
				<div class="card-body">
					<div class="form-group">
						<label for="title">Title</label>
						<input type="text" class="form-control" id="title" name="title" placeholder="Title" value="<?php echo $notification->title; ?>" required />
					</div>
					<div class="form-group">
						<label for="type">Type</label>
						<select name="type" id="type" class="form-control">
							<?php foreach($noti_types as $key=>$noti_type) { ?>
							<option value="<?php echo $noti_type->id; ?>" <?php echo $notification->type==$noti_type->id?'selected':''; ?>><?php echo $noti_type->title; ?></option>
							<?php } ?>
						</select>
					</div>
					<div class="form-group">
						<label for="content">Content</label>
						<textarea class="form-control" id="content" name="content" placeholder="Content"><?php echo $notification->content; ?></textarea>
					</div>
					<div class="form-group">
						<label for="status">Status</label>
						<select name="status" id="status" class="form-control">
							<?php foreach($status_arr as $key=>$status){ ?>
							<option value="<?php echo $key; ?>" <?php echo $notification->status==$key?'selected':''; ?>><?php echo $status; ?></option>
							<?php } ?>
						</select>
					</div>
					<!--/.row-->
					<div class="form-group">
						<label for="added_date">Date</label>
						<input type="text" class="form-control datepicker" id="added_date" name="added_date" placeholder="Date" value="<?php echo $notification->added_date; ?>" />
					</div>
					<button type="submit" class="btn btn-theme btn-sm"><i class="fa fa-dot-circle-o"></i>Update</button>
				</div>
				<!-- end card-body -->
			</div>
		</form>
		<!-- end card -->
	</div>
	<script>
	$('.editor').summernote({
		tabsize: 2,
		height: 500,
		dialogsInBody: true
	});
	$('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        startDate: '-3d'
    });
	</script>