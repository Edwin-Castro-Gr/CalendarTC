<?= $this->extend('frontend/layout/page-layout') ?>

<?= $this->section('stylesheet') ?>

<?= $this->endSection() ?>

<?= $this->section('contenido') ?>
<div class="page-header">
	<div class="row">
		<div class="col-md-12 col-sm-12">
			<div class="title">
				<h4>Usuarios</h4>
			</div>
			<nav aria-label="breadcrumb" role="navigation">
				<ol class="breadcrumb">
					<li class="breadcrumb-item">
						<a href="<?= route_to('admin.home') ?>">Home</a>
					</li>
					<li class="breadcrumb-item active" aria-current="page">
						Usuarios
					</li>
				</ol>
			</nav>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-12 mb-4">
		<div class="card card-box">
			<div class="card-header">
				<div class="clearfix">
					<div class="pull-left">
						Usuarios
					</div>
					<div class="pull-right">
						<a href="#" role="button" class="btn btn-default btn-sm-p-0" id="btnNuevoUsuario" name="btnNuevoUsuario"> <i class="fa fa-plus circle"></i>
							Agregar Usuario
						</a>
					</div>
				</div>
			</div>
			<div class="card-body">
				<table id="tablaUsuarios" class="table table-sm table-borderless table-hover table-striped">	
					<thead>
						<tr>
							<th scope="col">ID</th>
							<th scope="col">Nombre</th>
							<th scope="col">Correo</th>
							<th scope="col">Estado</th>
							<th scope="col">Acciones</th>
						</tr>
					</thead>
					<tbody>
						<!-- Aquí se cargarán los usuarios mediante AJAX -->
						<tr>
							<th scope="row">1</th>
							<td>---</td>
							<td>---</td>
							<td>---</td>
							<td>---</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<?php include 'modals/usuario-modal.php' ?>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
	<script src="/backend/_js/usuarios.js"></script>
<!-- Datatable Setting js -->

<?= $this->endSection() ?>