<?= $this->extend('frontend/layout/page-layout')?>

<?= $this->section('stylesheet') ?>
<link rel="stylesheet" type="text/css" href="src/plugins/datatables/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" type="text/css" href="src/plugins/datatables/css/responsive.bootstrap4.min.css">
<?= $this->endSection() ?>

<?= $this->section('contenido') ?>
<div class="page-header">
	<div class="row">
		<div class="col-md-6 col-sm-12">
			<div class="title">
				<h4>Clientes</h4>

                <button type="button" class="btn btn-blue px-3 d-block text-95 radius-round border-2 brc-black-tp10" data-toggle="modal" data-target="#newModal" id="btn_nuevo_registro">
                    <i class="fa fa-plus mr-1"></i>
                    <span class="d-sm-none d-md-inline" id="btn_nuevo_registro">Nuevo Cliente</span>
                </button>
			</div>
			<nav aria-label="breadcrumb" role="navigation">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="index.html">Home</a></li>
					<li class="breadcrumb-item active" aria-current="page">Clientes</li>
				</ol>
			</nav>
		</div>		
	</div>
</div>
<!-- Simple Datatable start -->
<div class="card-box mb-30">
	<div class="pd-20">
		<h4 class="text-blue h4">Gestión de Clientes</h4>		
	</div>
	<div class="pb-20">
		<table class="data-table table stripe hover nowrap">
			<thead>
				<tr>
					<th class="table-plus datatable-nosort">Tipo Cliente</th>
					<th class="table-plus datatable-nosort">Tipo Identidad</th>
					<th class="table-plus datatable-nosort">Numero de identificación </th>
					<th class="table-plus datatable-nosort">Nombre Cliente</th>
					<th class="table-plus datatable-nosort">Estado</th>
					<th class="datatable-nosort">Acción</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="table-plus">Administrador</td>
					<td>Administrador del Sistema</td>
					<td>
						<div class="dropdown">
							<a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#"
								role="button" data-toggle="dropdown">
								<i class="dw dw-more"></i>
							</a>
							<div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
								<a class="dropdown-item" href="#"><i class="dw dw-eye"></i> Ver</a>
								<a class="dropdown-item" href="#"><i class="dw dw-edit2"></i> Editar</a>
								<a class="dropdown-item" href="#"><i class="dw dw-delete-3"></i> Eliminar</a>
							</div>
						</div>
					</td>
				</tr>
				<tr>
					<td class="table-plus">Auxiliar</td>
					<td>Auxiliar Contable</td>
					<td>
						<div class="dropdown">
							<a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#"
								role="button" data-toggle="dropdown">
								<i class="dw dw-more"></i>
							</a>
							<div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
								<a class="dropdown-item" href="#" id="btnVerRegistro"><i class="dw dw-eye" id="btnVerRegistro"></i> Ver</a>
								<a class="dropdown-item" href="#" id="btnEditarRegistro"><i class="dw dw-edit2" id="btnEditarRegistro"></i> Editar</a>
								<a class="dropdown-item" href="#" id="btnEliminarRegistro"><i class="dw dw-delete-3" id="btnEliminarRegistro"></i> Eliminar</a>
							</div>
						</div>
					</td>
				</tr>				
			</tbody>
		</table>
	</div>
</div>
<!-- Simple Datatable End -->
<!-- Modal Nuevo Rol --> 
<div class="modal fade " id="newModal" tabindex="-1" role="dialog" aria-labelledby="newModalLabel" aria-hidden="true">  
    <div class="modal-dialog" role="document">             
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalNuevoClienteLabel">Nuevo Cliente</h5>            
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formNuevoCiudad">
                    <div class="form-group">
                        <label for="nombreCiudad">Rol</label>
                        <input type="text" class="form-control" id="identificacion" name="identificacion" required> 
                    </div>
                    <div class="form-group">
                        <label for="DescripcionRol">Descripcion del Rol</label>
                        <input type="text" class="form-control" id="DescripcionRol" name="DescripcionRol" required> 
                    </div>
            </form> 
            </div>
            <div class="modal-footer">  
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary" form="formNuevoRol">Guardar Rol</button>          
            </div>
        </div>     
    </div> 
</div> 
<!-- Modal Nuevo rol End-->
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
	<script src="src/plugins/datatables/js/jquery.dataTables.min.js"></script>
	<script src="src/plugins/datatables/js/dataTables.bootstrap4.min.js"></script>
	<script src="src/plugins/datatables/js/dataTables.responsive.min.js"></script>
	<script src="src/plugins/datatables/js/responsive.bootstrap4.min.js"></script>
	<!-- buttons for Export datatable -->
	<script src="src/plugins/datatables/js/dataTables.buttons.min.js"></script>
	<script src="src/plugins/datatables/js/buttons.bootstrap4.min.js"></script>
	<script src="src/plugins/datatables/js/buttons.print.min.js"></script>
	<script src="src/plugins/datatables/js/buttons.html5.min.js"></script>
	<script src="src/plugins/datatables/js/buttons.flash.min.js"></script>
	<script src="src/plugins/datatables/js/pdfmake.min.js"></script>
	<script src="src/plugins/datatables/js/vfs_fonts.js"></script>
	<!-- Datatable Setting js -->
	<script src="vendors/scripts/datatable-setting.js"></script>
<?= $this->endSection() ?>