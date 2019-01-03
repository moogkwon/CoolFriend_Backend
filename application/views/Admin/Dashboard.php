<?php $this->load->view('elements/header'); ?>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<?php $this->load->view('elements/header_top'); ?>
    <!-- end header -->
    <div class="app-body">
        <?php $this->load->view('elements/left_sidebar_admin'); ?>
        <!-- end sidebar -->
        <main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb bc-colored bg-theme" id="breadcrumb">
                <li class="breadcrumb-item ">
                    <a href="<?php echo base_url(); ?>">Home</a>
                </li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
            <div class="container-fluid">
                <div class="animated fadeIn">
                    <!-- end row -->
					<div style="height: 20px;"></div>
                    <div class="row">
						<div class="col-lg-6 text-center">
							<div id="chart_div"></div>
						</div>
						<div class="col-lg-6">
							<div class="col-md-12">
								<div class="card card-accent-theme">
									<div class="card-body">
										<h4 class="text-theme"># of online users: <?php echo !empty($online_users)?count($online_users):0; ?></h4>
										<p><small>Online users information.</small></p>
										<br />
										<table class="table-hover table-striped data_table_init" id="online_user_table" width="100%">
											<thead>
												<tr>
													<th>ID</th>
													<th>Country</th>
													<th>City</th>
													<th>State</th>
												</tr>
											</thead>
											<tbody>
												<?php if(!empty($online_users)) { ?>
												<?php foreach($online_users as $online_user) { 
												if($online_user->gender=='female'){
												$color = 'color: red';
												}else{
												$color = '';
												}
												?>
												<tr>
													<td>
														<a href="<?php echo site_url('Admin/Users/View/'.$online_user->id); ?>" style="<?php echo $color; ?>">
															<?php echo $online_user->id; ?>
														</a>
													</td>
													<td><?php echo $online_user->location_country; ?></td>
													<td><?php echo $online_user->location_city; ?></td>
													<td><?php echo $online_user->location_state; ?></td>
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
						</div>
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
	google.charts.load('current', {'packages':['line']});
	google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
      var data = new google.visualization.DataTable();
      data.addColumn('number', 'Hour');
      data.addColumn('number', 'Online Users');
      data.addRows([
		<?php if(!empty($last24hrs)) { ?>
		<?php foreach($last24hrs as $row) { ?>
        [<?php echo $row->hrs; ?>,  <?php echo $row->total; ?> ],
		<?php } ?>
		<?php } ?>
      ]);
      var options = {
        chart: {
          title: 'Online User in last 24 hours',
          subtitle: 'Number of user online',
		  chxs: '0N*f0*',
        },
		vAxis: {
			gridlines: { count: <?php echo $row->total+1; ?>}, 
			viewWindow:{
			  min: 0,
			  max: <?php echo ($row->total % 2 == 0)?$row->total+2:$row->total+1; ?>
			},
		},
        width: 570,
        height: 400
      };
      var chart = new google.charts.Line(document.getElementById('chart_div'));
      chart.draw(data, google.charts.Line.convertOptions(options));
    }
	</script>