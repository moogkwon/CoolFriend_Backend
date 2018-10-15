<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Griit Admin Panel</title>
	
   <!-- FONT AWESOME-->
   <link rel="stylesheet" href="<?=base_url()?>asset/vendor/font-awesome/css/font-awesome.css">
   <!-- SIMPLE LINE ICONS-->
   <link rel="stylesheet" href="<?=base_url()?>asset/vendor/simple-line-icons/css/simple-line-icons.css">
   <!-- ANIMATE.CSS-->
   <link rel="stylesheet" href="<?=base_url()?>asset/vendor/animate.css/animate.css">
   <!-- WHIRL (spinners)-->
   <link rel="stylesheet" href="<?=base_url()?>asset/vendor/whirl/dist/whirl.css">
   <!-- =============== PAGE VENDOR STYLES ===============-->
   <!-- WEATHER ICONS-->
   <link rel="stylesheet" href="<?=base_url()?>asset/vendor/weather-icons/css/weather-icons.css">
   <!-- =============== BOOTSTRAP STYLES ===============-->
   <link rel="stylesheet" href="<?=base_url()?>asset/css/bootstrap.css" id="bscss">
   <!-- =============== APP STYLES ===============-->
   <link rel="stylesheet" href="<?=base_url()?>asset/css/app.css" id="maincss">

<body class="layout-h">
	<div class="wrapper">
		<!-- top navbar-->
		<header class="topnavbar-wrapper">
			<!-- START Top Navbar-->
			<nav class="navbar topnavbar navbar-expand-lg navbar-light">
				<!-- START navbar header-->
				<div class="navbar-header">
					<a class="navbar-brand" href="#/">
						<div class="brand-logo">
							<img class="img-fluid" src="<?=base_url()?>asset/img/logo.png" alt="App Logo">
						</div>
						<div class="brand-logo-collapsed">
							<img class="img-fluid" src="<?=base_url()?>asset/img/logo-single.png" alt="App Logo">
						</div>
					</a>
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#topnavbar">
						<span class="navbar-toggler-icon"></span>
					</button>
					</div>
					<!-- END navbar header-->
					<!-- START Nav wrapper-->
					<div class="navbar-collapse collapse" id="topnavbar">
					<!-- START Left navbar-->
					<ul class="nav navbar-nav mr-auto flex-column flex-lg-row">
						<!--<li class="nav-item dropdown"><a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="#dashboard" data-toggle="dropdown">Dashboard</a>
							<div class="dropdown-menu animated fadeIn"><a class="dropdown-item" href="dashboard.html">Dashboard v1</a><a class="dropdown-item" href="dashboard_v2.html">Dashboard v2</a><a class="dropdown-item" href="dashboard_v3.html">Dashboard v3</a>
							</div>
						</li>
						<li class="nav-item"><a class="nav-link" href="widgets.html">Widgets</a>
						</li>-->
					</ul>
					<!-- END Left navbar-->
					<!-- START Right Navbar-->
					<ul class="navbar-nav flex-row">
						<!-- START lock screen-->
						<li class="nav-item">
							<a class="nav-link" href="<?=base_url()?>login" title="Login">
								<em class="icon-login"></em>
							</a>
						</li>
					</ul>
				</div>
				<!-- END Nav wrapper-->
				<!-- START Search form-->
				<form class="navbar-form" role="search" action="search.html">
					<div class="form-group">
						<input class="form-control" type="text" placeholder="Type and hit enter ...">
						<div class="fa fa-times navbar-form-close" data-search-dismiss=""></div>
					</div>
					<button class="d-none" type="submit">Submit</button>
				</form>
			<!-- END Search form-->
			</nav>
			<!-- END Top Navbar-->
		</header>
		<section class="section-container">
         <!-- Page content-->
			<div class="content-wrapper">
				<div class="row">
					<div class="col-md-12">
						<img class="wd-wide animated fadeIn" src="<?=base_url()?>asset/img/Thumb.jpg">
					</div>
				</div>
            <!-- END Multiple List group-->
			</div>
		</section>
		<!-- Page footer-->
		<footer>
			<span>&copy; 2018 - Olive Team</span>
		</footer>
	</div>
	<!-- =============== VENDOR SCRIPTS ===============-->
	<!-- MODERNIZR-->
	<script src="<?=base_url()?>asset/vendor/modernizr/modernizr.custom.js"></script>
	<!-- JQUERY-->
	<script src="<?=base_url()?>asset/vendor/jquery/dist/jquery.js"></script>
	<!-- BOOTSTRAP-->
	<script src="<?=base_url()?>asset/vendor/popper.js/dist/umd/popper.js"></script>
	<script src="<?=base_url()?>asset/vendor/bootstrap/dist/js/bootstrap.js"></script>
	<!-- STORAGE API-->
	<script src="<?=base_url()?>asset/vendor/js-storage/js.storage.js"></script>
	<!-- JQUERY EASING-->
	<script src="<?=base_url()?>asset/vendor/jquery.easing/jquery.easing.js"></script>
	<!-- ANIMO-->
	<script src="<?=base_url()?>asset/vendor/animo/animo.js"></script>
	<!-- SCREENFULL-->
	<script src="<?=base_url()?>asset/vendor/screenfull/dist/screenfull.js"></script>
	<!-- LOCALIZE-->
	<script src="<?=base_url()?>asset/vendor/jquery-localize/dist/jquery.localize.js"></script>
	<!-- =============== PAGE VENDOR SCRIPTS ===============-->
	<!-- SPARKLINE-->
	<script src="<?=base_url()?>asset/vendor/jquery-sparkline/jquery.sparkline.js"></script>
	<!-- FLOT CHART-->
	<script src="<?=base_url()?>asset/vendor/flot/jquery.flot.js"></script>
	<script src="<?=base_url()?>asset/vendor/jquery.flot.tooltip/js/jquery.flot.tooltip.js"></script>
	<script src="<?=base_url()?>asset/vendor/flot/jquery.flot.resize.js"></script>
	<script src="<?=base_url()?>asset/vendor/flot/jquery.flot.pie.js"></script>
	<script src="<?=base_url()?>asset/vendor/flot/jquery.flot.time.js"></script>
	<script src="<?=base_url()?>asset/vendor/flot/jquery.flot.categories.js"></script>
	<script src="<?=base_url()?>asset/vendor/jquery.flot.spline/jquery.flot.spline.js"></script>
	<!-- EASY PIE CHART-->
	<script src="<?=base_url()?>asset/vendor/easy-pie-chart/dist/jquery.easypiechart.js"></script>
	<!-- MOMENT JS-->
	<script src="<?=base_url()?>asset/vendor/moment/min/moment-with-locales.js"></script>
	<!-- =============== APP SCRIPTS ===============-->
	<script src="<?=base_url()?>asset/js/app.js"></script>
</body>


</html>
