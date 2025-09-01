<!DOCTYPE html>
<html>

<head>
	<!-- Basic Page Info -->
	<meta charset="utf-8">
	<title><?= isset($pageTitle) ? $pageTitle : 'TaxControl'; ?> </title>
	<meta name="keywords" content="TaxControl, Tax, Control, App">
	<meta name="description" content="TaxControl App">
	<meta name="author" content="TaxControl Team">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">


	<!-- Site favicon -->
	<link rel="apple-touch-icon" sizes="180x180" href="/backend/vendors/images/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="/backend/vendors/images/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="/backend/vendors/images/favicon-16x16.png">

	<!-- Mobile Specific Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<!-- Google Font -->
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
		rel="stylesheet">
	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="/backend/vendors/styles/core.css">
	<link rel="stylesheet" type="text/css" href="/backend/vendors/styles/icon-font.min.css">
	<link rel="stylesheet" type="text/css" href="/backend/vendors/styles/style.css">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />

	<?= $this->renderSection('stylesheet'); ?>

</head>

<body>

	<?= $this->include('frontend/layout/inc/header'); ?>

	<?= $this->include('frontend/layout/inc/right-sidebar.php') ?>
	<?= $this->include('frontend/layout/inc/left-sidebar.php') ?>

	<div class="mobile-menu-overlay"></div>

	<div class="main-container">
		<div class="pd-ltr-20 xs-pd-20-10">
			<div class="min-height-200px">

				<div>
					<?= $this->renderSection('contenido'); ?>
				</div>
			</div>
			<?= $this->include('frontend/layout/inc/footer.php'); ?>
		</div>
	</div>
	<!-- js -->
	<script src="/backend/vendors/scripts/core.js"></script>
	<script src="/backend/vendors/scripts/script.min.js"></script>
	<script src="/backend/src/plugins/sweetalert2@10.16.0/dist/sweetalert2.all.min.js"></script>
	<script src="/backend/vendors/scripts/process.js"></script>
	<script src="/backend/vendors/scripts/layout-settings.js"></script>
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
	<?= $this->renderSection('scripts'); ?>
</body>

</html>