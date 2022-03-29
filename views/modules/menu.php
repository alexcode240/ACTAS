        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="#" class="brand-link">
                <img src="views/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">Actas System</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user (optional) -->



                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->


                        <!--<li class="nav-item">
                            <a href="inicio" class="nav-link <?php if ($request == "inicio") {
                                                                    echo "active";
                                                                } ?>">
                                <i class="nav-icon fa fa-folder-open"></i>
                                <p>
                                    Actas Circunstanciales
                                </p>
                            </a>
                        </li>-->
                        <li class="nav-item">
                            <a href="acta-form" class="nav-link <?php if ($request == "acta-form" || $request == "" || $request == "inicio") {
                                                                    echo "active";
                                                                } ?>">

                                <i class="nav-icon fa fa-book"></i>
                                <p>
                                    Formulario Actas
                                </p>
                            </a>
                        </li>

                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>
        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->