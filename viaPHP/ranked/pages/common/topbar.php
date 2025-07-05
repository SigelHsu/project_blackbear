<!-- Topbar -->
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

	<!-- Sidebar Toggle (Topbar) -->
	<button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
		<i class="fa fa-bars"></i>
	</button>


	<!-- Topbar Navbar -->
	<ul class="navbar-nav ml-auto">

		<!-- Nav Item - Search -->
		<?php require_once("./pages/common/topbar/topbar_searchbox.php"); ?>

		<!-- Nav Item - Alerts -->
		<?php require_once("./pages/common/topbar/topbar_noticebox.php"); ?>

		<!-- Nav Item - Messages -->
		<?php require_once("./pages/common/topbar/topbar_messagebox.php"); ?>

		<div class="topbar-divider d-none d-sm-block"></div>

		<!-- Nav Item - User Information -->
		<?php require_once("./pages/common/topbar/topbar_profilebox.php"); ?>

	</ul>

</nav>
<!-- End of Topbar -->