<!DOCTYPE html>
<html lang="en">

	<head>
		<?php require_once("./pages/common/headbar.php"); ?>
	</head>

	<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

			<!-- Sidebar -->
			<?php require_once("./pages/common/sidebar.php"); ?>
			<!-- End of Sidebar -->

			<!-- Content Wrapper -->
			<div id="content-wrapper" class="d-flex flex-column">

				<!-- Main Content -->
				<div id="content">

					<!-- Topbar -->
					<?php require_once("./pages/common/topbar.php"); ?>
					<!-- End of Topbar -->

					<!-- Begin Page Content -->
					<?php require_once("./pages/common/main.php"); ?>
					<!-- /.container-fluid -->

				</div>
				<!-- End of Main Content -->

				<!-- Footer -->
				<?php require_once("./pages/common/footbar.php"); ?>
				<!-- End of Footer -->

			</div>
			<!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->
		
		<!-- Scroll to Top Button-->
		<a id="btn_top" class="scroll-to-top rounded" href="#page-top">
			<i class="fas fa-angle-up"></i>
		</a>
		
		<?php include_once("./pages/common/toast.php");	//掛載 toast的頁面 ?>
	</body>

</html>