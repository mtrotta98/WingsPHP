<!--<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">-->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="alumnos.php" class="brand-link">
        <img src="imagenes/logo_wings.jpg" alt="Wings" class="brand-image"
             style="opacity: .8">
        <br />
        <span class="brand-text font-weight-light"></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="alumnos.php" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Ir a Inicio
                        </p>
                    </a>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Alumnos
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="carga_alumnos.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Nuevo Alumno</p>
                            </a>
                            <a href="alumnos_estado.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Alumnos Inactivos</p>
                            </a>
                        </li>
                        
                    </ul>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Tutor
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="carga_tutores.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Nuevo tutor</p>
                            </a>
                            <a href="tutores.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Editar tutor</p>
                            </a>
                            <a href="tutores_inactivos.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Tutores inactivos</p>
                            </a>
                        </li>
                        
                    </ul>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Docentes
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="carga_docentes.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Nuevo Docente</p>
                            </a>
                            <a href="docentes.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Editar Docente</p>
                            </a>
                            <a href="docentes_inactivos.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Docentes Inactivos</p>
                            </a>
                        </li>
                        
                    </ul>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Cursos
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="carga_curso.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Nuevo Curso</p>
                            </a>
                            <a href="cursos.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Editar Curso</p>
                            </a>
                            <a href="cursos_inactivos.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Cursos Inactivos</p>
                            </a>
                        </li>
                        
                    </ul>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Libros
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="carga_libros.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Nuevo Libro</p>
                            </a>
                            <a href="libros.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Editar Libro</p>
                            </a>
                            <a href="libros_inactivos.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Libros Inactivos</p>
                            </a>
                        </li>
                        
                    </ul>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Fichas Medicas
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="lista_fichas.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Edita Ficha</p>
                            </a>
                            <a href="fichas_inactivas.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Fichas Inactivas</p>
                            </a>
                        </li>
                        
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="historial_pagos.php" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Pagos
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="gastos.php" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Gastos
                        </p>
                    </a>
                </li>

                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Resumen
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="resumen.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Resumen mensual</p>
                            </a>
                            <a href="resumen_fecha.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Resumen por fecha</p>
                            </a>
                        </li>
                        
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="listados_gral.php" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Listador
                        </p>
                    </a>
                </li>
                <li>
                    <a href="acciones.php?valor=19&accion=backup"><button type="button" class="btn btn-block btn-warning">Backup</button></a>
                </li>
                <!--<li>
                    <a href="acciones.php?valor=20&accion=cuotas"><button type="button" class="btn btn-block btn-primary">Cuotas</button></a>
                </li>-->
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>