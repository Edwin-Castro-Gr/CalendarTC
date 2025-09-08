<div class="left-side-bar">
	<div class="brand-logo">
		<a href="index.html">
			<img src="/backend/vendors/images/deskapp-logo.png" alt="" class="dark-logo">
			<img src="/backend/vendors/images/deskapp-logo-white.svg" alt="" class="light-logo">
		</a>
		<div class="close-sidebar" data-toggle="left-sidebar-close">
			<i class="ion-close-round"></i>
		</div>
	</div>
	<div class="menu-block customscroll">
		<div class="sidebar-menu">
			<ul id="accordion-menu">
				<li class="dropdown">
					<a href="javascript:;" class="dropdown-toggle">
						<span class="micon dw dw-house-1"></span><span class="mtext">Administración</span>
					</a>
					<ul class="submenu">
						<li><a href="<?= route_to('admin.usuarios') ?>">Usuarios</a></li>
						<li><a href="<?= route_to('admin.roles') ?>">Roles</a></li>
						<li><a href="#">Clientes</a></li>
						<li><a href="#">Tipos de Documentos</a></li>
						<li><a href="#">Ciudades</a></li>
						<li><a href="#">Paises</a></li>
						<li><a href="#">Tipos de Contribuyentes</a></li>
						<li><a href="#">Obligaciones Tributarias</a></li>
						<li><a href="#">Responsables Fiscales</a></li>
					</ul>
				</li>
				<li class="dropdown">
					<a href="javascript:;" class="dropdown-toggle">
						<span class="micon dw dw-edit2"></span><span class="mtext">Gestión de Declaraciones</span>
					</a>
				</li>
				<li class="dropdown">
					<a href="javascript:;" class="dropdown-toggle">
						<span class="micon dw dw-library"></span><span class="mtext">Gestión Tributario</span>
					</a>
				</li>
				<li>
					<a href="calendar.html" class="dropdown-toggle no-arrow">
						<span class="micon dw dw-calendar1"></span><span class="mtext">Calendario</span>
					</a>
				</li>
				<li class="dropdown">
					<a href="javascript:;" class="dropdown-toggle">
						<span class="micon dw dw-apartment"></span><span class="mtext"> Reportes </span>
					</a>
				</li>
			</ul>
		</div>
	</div>
</div>