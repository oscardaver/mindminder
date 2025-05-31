<?php
session_start();

include_once 'controllers/reporteStudent.controller.php';
$ControladorStudent= new reporteStudent_controller();

$organizaciones = $ControladorStudent->mostrarOrganizacion();
$suOrganizaciones = $ControladorStudent->mostrarSubOrganizacion();


?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Reporte Estudiantes</title>

    <!-- Custom fonts for this template-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
                <div class="sidebar-brand-icon rotate-n-15">
                <i class="fa-solid fa-infinity"></i>
                </div>
                <div class="sidebar-brand-text mx-3">MindMinder</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="index.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Home</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Interfaces
            </div>

            <!-- MENUUUUU LATERAL -->

            <!-- Nav Item - usuarios -->
            <li class="nav-item">
                <a class="nav-link" href="usuarios.php">
                    <i class="fas fa-fw fa-chart-area"></i>
                <span>Registrar Usuarios</span></a>
            </li>

            <!-- Nav Item - Cuestionario -->
            <li class="nav-item">
                <a class="nav-link" href="Cuestionario.php">
                    <i class="fa-solid fa-clipboard-question"></i>                    
                <span>Cuestionario</span></a>
            </li>

            <!-- Nav Item - trastorno -->
            <li class="nav-item">
                <a class="nav-link" href="trastorno.php">
                    <i class="fa-solid fa-brain"></i>          
                <span>Trastornos</span></a>
            </li>
            
            <!-- Nav Item - Reporte Estudiante -->
            <li class="nav-item">
                <a class="nav-link" href="reporteStudent.php">
                    <i class="fa-solid fa-person"></i>                   
                <span>Reporte Estudiante</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>


        </ul>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->
                    <form
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                                aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <!-- Nav Item - Alerts -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                <!-- Counter - Alerts -->
                                <span class="badge badge-danger badge-counter"></span>
                            </a>
                            <!-- Dropdown - Alerts -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">
                                    Alerts Center
                                </h6>
                            </div>
                        </li>

                        <!-- Nav Item - Messages -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-envelope fa-fw"></i>
                                <!-- Counter - Messages -->
                                <span class="badge badge-danger badge-counter"></span>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="messagesDropdown">
                                <h6 class="dropdown-header">
                                    Message Center
                                </h6>
                                <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a>
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                <!-- Nav Item - User Information -->
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                <?php echo isset($_SESSION['nombre']) ? htmlspecialchars($_SESSION['nombre']) : 'Usuario'; ?>
                            </span>
                            <img class="img-profile rounded-circle" src="img/undraw_profile.svg">
                        </a>
                        <!-- Dropdown - User Information -->
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                            aria-labelledby="userDropdown">
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                Cerrar Sesión
                            </a>
                        </div>
                    </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                <div class="container">
                   <div class="card shadow-sm p-3 mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h2 class="mb-0">Cargar Estudiantes</h2>
                        <button id="btnDescargarPlantilla" class="btn btn-icon btn-outline-primary" data-bs-toggle="tooltip" title="Descargar plantilla CSV">
                            <i class="fa-solid fa-download"></i>
                        </button>
                    </div>

                    <!-- Formulario para cargar CSV -->
                    <div class="mb-3 d-flex align-items-center gap-2">
                        <input class="form-control" type="file" id="csvFile" name="csvFile" accept=".csv" required>
                        <button type="button" id="subirEstudiantesBtn" class="btn btn-primary">Subir</button>
                    </div>
                </div>


                    <!-- Caja de Filtros -->
                <div class="card shadow-sm p-3 mb-4">
                    <h5 class="mb-3">Filtros</h5>
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label>Fecha Inicio</label>
                            <input type="date" id="fechaInicio" class="form-control"
                                value="<?php echo isset($_POST['fechaInicio']) ? $_POST['fechaInicio'] : date('Y-m-d'); ?>">
                        </div>
                        <div class="col-md-3">
                            <label>Fecha Fin</label>
                            <input type="date" id="fechaFin" class="form-control"
                                value="<?php echo isset($_POST['fechaFin']) ? $_POST['fechaFin'] : date('Y-m-d'); ?>">
                        </div>
                        <div class="col-md-2">
                            <label>Carrera</label>
                            <select id="filtroCarrera" name="filtroCarrera[]" class="form-select" multiple>
                                <option value="">Todas</option>
                                <?php
                                foreach ($suOrganizaciones as $row) {
                                    $selected = '';
                                    if (isset($_POST['filtroCarrera']) && in_array($row['nombre'], $_POST['filtroCarrera'])) {
                                        $selected = 'selected';
                                    }
                                    echo '<option value="' . $row['nombre'] . '" ' . $selected . '>' . $row['nombre'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label>Organización</label>
                            <select id="filtroOrganizacion" name="filtroOrganizacion[]" class="form-select" multiple>
                                <option value="">Todas</option>
                                <?php
                                foreach ($organizaciones as $row) {
                                    $selected = '';
                                    if (isset($_POST['filtroOrganizacion']) && in_array($row['nombre'], $_POST['filtroOrganizacion'])) {
                                        $selected = 'selected';
                                    }
                                    echo '<option value="' . $row['nombre'] . '" ' . $selected . '>' . $row['nombre'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label>Código</label>
                            <input type="number" id="codigoEstudiante" class="form-control" placeholder="Ej: 20230123"
                                value="<?php echo isset($_POST['codigoEstudiante']) ? htmlspecialchars($_POST['codigoEstudiante']) : '' ?>">
                        </div>
                    </div>

                    <!-- Botón de búsqueda -->
                    <div class="d-flex justify-content-end">
                        <button id="buscarEstudiantesBtn" class="btn btn-primary">
                            <i class="fa fa-search me-1"></i> Buscar
                        </button>
                    </div>
                </div>

                    <div class="container mt-5">
                        <div class="card shadow rounded">
                            <div class="card-header bg-primary text-white">
                                <h4 class="mb-0">Reporte Estudiante</h4>
                            </div>
                            <div class="card-body">
                                <!-- Tabla de estudiantes -->
                                <table id="tablaEstudiantes" class="display table table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Fecha Registro</th>
                                            <th>Código</th>
                                            <th>Nombre</th>
                                            <th>Carrera</th>
                                            <th>Organización</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Se llenará dinámicamente -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
          
                </div>
                    </div>
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->
        
        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Listo para salir</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Seleccione "Cerrar sesión" a continuación si está listo para finalizar su sesión actual.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                    <a class="btn btn-primary" href="login.php">Cerrar sesión</a>
                </div>
            </div>
        </div>
    </div>

     <!-- SweetAlert2 -->
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> 
<!-- Bootstrap core JavaScript-->
     <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap 5 JS Bundle (con Popper incluido) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery y DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>


    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/papaparse@5.3.2/papaparse.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>
    <!-- Page level custom scripts -->
    <script src="js/reporteStudent.js"></script>

</body>

</html>