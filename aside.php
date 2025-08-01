
<!-- Sidebar Start -->
<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div>
    <div class="brand-logo d-flex align-items-center justify-content-between">
        <a href="./index.html" class="text-nowrap logo-img">
        <img src="assets/images/logos/iac.png" width="50" alt="" />
        </a>
        <h4><b>Imagi Creative</b></h4>
        <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
        <i class="ti ti-x fs-8"></i>
        </div>
    </div>
    <!-- Sidebar navigation-->
    <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
        <ul id="sidebarnav">
            <li class="nav-small-cap">
                <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                <span class="hide-menu">Home</span>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="index.php?page=home" aria-expanded="false">
                <span>
                    <i class="ti ti-layout-dashboard"></i>
                </span>
                <span class="hide-menu">Dashboard</span>
                </a>
            </li>
            <?php if($level == "Staff"){ ?>
            <li class="nav-small-cap">
                <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                <span class="hide-menu">Permohonan Biaya</span>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="index.php?page=pbn" aria-expanded="false">
                <span>
                    <i class="ti ti-file-description"></i>
                </span>
                <span class="hide-menu">Form PB</span>
                </a>
            </li>
            <li class="nav-small-cap">
                <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                <span class="hide-menu">Status PB</span>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="index.php?page=statuspb" aria-expanded="false">
                <span>
                    <i class="ti ti-layout-dashboard"></i>
                </span>
                <span class="hide-menu">Status PB</span>
                </a>
            </li>
            <li class="nav-small-cap">
                <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                <span class="hide-menu">History PB</span>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="index.php?page=historypb" aria-expanded="false">
                <span>
                    <i class="ti ti-layout-dashboard"></i>
                </span>
                <span class="hide-menu">History PB</span>
                </a>
            </li>
            <?php } elseif($level == "Keuangan") { ?>
            <li class="nav-small-cap">
                <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                <span class="hide-menu">Project</span>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="./rabproject.php" aria-expanded="false">
                <span>
                    <i class="ti ti-layout-dashboard"></i>
                </span>
                <span class="hide-menu">Project</span>
                </a>
            </li>
            
            <li class="sidebar-item">
                <a class="sidebar-link" href="./formpb.php" aria-expanded="false">
                <span>
                    <i class="ti ti-file-description"></i>
                </span>
                <span class="hide-menu">Form PB - Event</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="./historyph.php" aria-expanded="false">
                <span>
                    <i class="ti ti-layout-dashboard"></i>
                </span>
                <span class="hide-menu">History Permohonan Biaya</span>
                </a>
            </li>
            <li class="nav-small-cap">
                <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                <span class="hide-menu">AUTH</span>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="./authentication-login.html" aria-expanded="false">
                <span>
                    <i class="ti ti-login"></i>
                </span>
                <span class="hide-menu">Login</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="./authentication-register.html" aria-expanded="false">
                <span>
                    <i class="ti ti-user-plus"></i>
                </span>
                <span class="hide-menu">Register</span>
                </a>
            </li>
            <?php } else { ?>
                
            <li class="nav-small-cap">
                <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                <span class="hide-menu">Approval PB</span>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="index.php?page=appb" aria-expanded="false">
                <span>
                    <i class="ti ti-layout-dashboard"></i>
                </span>
                <span class="hide-menu">Approval PB</span>
                </a>
            </li>
            
            <li class="nav-small-cap">
                <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                <span class="hide-menu">History PB</span>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="index.php?page=historypbadm" aria-expanded="false">
                <span>
                    <i class="ti ti-layout-dashboard"></i>
                </span>
                <span class="hide-menu">History PB</span>
                </a>
            </li>
            <?php } ?>
        </ul>
    </nav>
    <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
<!--  Sidebar End -->