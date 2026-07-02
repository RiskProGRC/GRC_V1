<?php
?>

<style>
    .bg-red { background-color: red; }

    /* ── Top bar ───────────────────────────────────────────────── */
    .layout-horizontal .header-top {
        padding: 0.15rem 0 !important;
    }
    .layout-horizontal .header-top .logo img {
        height: 26px !important;
    }
    .layout-horizontal .header-top-right {
        gap: 0.5rem !important;
    }
    .avatar.avatar-md2 img,
    .avatar.avatar-md2 .avatar-content {
        height: 30px !important;
        width: 30px !important;
    }

    /* ── Main nav bar ──────────────────────────────────────────── */
    .layout-horizontal .main-navbar {
        background-color: #02338d !important;
        padding: 0 1rem !important;
    }
    .layout-horizontal .main-navbar ul {
        gap: 0.3rem !important;
        align-items: center !important;
        height: 42px;
    }
    .layout-horizontal .main-navbar ul .menu-link {
        padding: 0.45rem 0.5rem !important;
        gap: 0.35rem !important;
        font-size: 14px !important;
        white-space: nowrap;
        align-items: center !important;
        line-height: 1.4 !important;
    }
    .layout-horizontal .main-navbar ul .menu-link span {
        font-size: 14px !important;
        height: auto !important;
        line-height: 1.4 !important;
        vertical-align: middle;
    }
    .layout-horizontal .main-navbar ul .menu-link i.bi {
        font-size: 14px !important;
        width: 14px !important;
        height: 14px !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
    }
    .layout-horizontal .main-navbar ul > .menu-item.has-sub .menu-link {
        padding-right: 1.2rem !important;
    }
    .layout-horizontal .main-navbar ul > .menu-item.has-sub .menu-link:after {
        top: 50% !important;
        transform: translateY(-50%) !important;
    }

    /* ── Active link — gold bottom accent ─────────────────────── */
    .layout-horizontal .main-navbar ul .menu-item.active > .menu-link,
    .layout-horizontal .main-navbar ul .menu-link.active {
        border-bottom: 3px solid #ffc107 !important;
        color: #fff !important;
        background: rgba(255,255,255,0.1) !important;
    }

    /* ── User dropdown text ────────────────────────────────────── */
    .user-dropdown-name   { font-size: 13px !important; }
    .user-dropdown-status { font-size: 10px !important; }

    /* ── Burger button ─────────────────────────────────────────── */
    .burger-btn { display: none; }

    @media screen and (max-width: 1199px) {
        .layout-horizontal .header-top {
            position: relative !important;
            padding: 0.3rem 0 !important;
        }
        .burger-btn {
            display: flex !important;
            align-items: center;
            justify-content: center;
            position: absolute !important;
            left: 0.75rem !important;
            top: 50% !important;
            transform: translateY(-50%) !important;
            z-index: 20;
            width: 34px;
            height: 34px;
            border-radius: 6px;
            background: #435ebe;
            color: #fff !important;
            text-decoration: none;
        }
        .burger-btn i {
            font-size: 18px !important;
            color: #fff !important;
        }
        .burger-btn:hover { background: #3451a8; }

        .layout-horizontal .header-top .logo img {
            height: 22px !important;
            max-width: 100px;
            width: auto;
        }
        .layout-horizontal .header-top .logo {
            padding-left: 3.25rem !important;
            flex: 1;
            min-width: 0;
        }
        .layout-horizontal .header-top .container-fluid.row {
            flex-wrap: nowrap !important;
            align-items: center !important;
        }
        .layout-horizontal .header-top-right {
            flex-shrink: 0;
        }

        @media screen and (max-width: 575px) {
            .user-dropdown-name,
            .user-dropdown-status { display: none !important; }
        }

        .layout-horizontal .main-navbar {
            background-color: #02338d !important;
            padding: 0.5rem 1rem !important;
            border-top: 1px solid rgba(255,255,255,0.08);
        }
        .layout-horizontal .main-navbar ul {
            height: auto !important;
        }
        .layout-horizontal .main-navbar ul .menu-link {
            padding: 0.7rem 0.75rem !important;
            font-size: 14px !important;
            color: #dee2e6 !important;
            border-radius: 6px;
        }
        .layout-horizontal .main-navbar ul .menu-link:hover {
            background: rgba(255,255,255,0.08) !important;
            color: #fff !important;
        }
        .layout-horizontal .main-navbar ul .menu-link span {
            font-size: 14px !important;
        }
        .layout-horizontal .main-navbar ul .menu-link i.bi {
            font-size: 14px !important;
            width: 14px !important;
            height: 14px !important;
            color: #aab4d0 !important;
        }
        .layout-horizontal .main-navbar .submenu {
            background-color: #0f1628 !important;
            border-radius: 6px !important;
            margin: 2px 0 4px 1rem !important;
            padding: 4px 0 !important;
        }
        .layout-horizontal .main-navbar .submenu .submenu-group .submenu-item a {
            font-size: 13px !important;
            padding: 0.55rem 1rem !important;
            color: #aab4d0 !important;
            border-radius: 4px;
        }
        .layout-horizontal .main-navbar .submenu .submenu-group .submenu-item a:hover {
            color: #fff !important;
            background: rgba(255,255,255,0.06) !important;
        }
    }
</style>

<header class="mb-5">

    <!-- Top Bar -->
    <div class="header-top">
        <div class="container-fluid row">

            <div class="logo col-11">
                <a href="../Project/dashboard.php">
                    <img src="../assets/images/logo/GRC.png" width="120px" alt="Logo">
                </a>
            </div>

            <div class="header-top-right col-1">

                <div class="dropdown">
                    <a href="#" class="user-dropdown d-flex dropend" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="avatar avatar-md2">
                            <img src="../assets/images/faces/1.jpg" alt="Avatar">
                        </div>
                        <div class="text">
                            <h5 class="user-dropdown-name"><?= $sess_username ?></h5>
                            <p class="user-dropdown-status text-sm text-muted">Member</p>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow-lg" aria-labelledby="dropdownMenuButton1">
                        <li><a class="dropdown-item" href="#">My Account</a></li>
                        <li><a class="dropdown-item" href="../systemover.php">Overview</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="../Project/logout.php">Logout</a></li>
                    </ul>
                </div>

                <!-- Burger button responsive -->
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>

            </div>
        </div>
    </div>

    <!-- Main Navigation -->
    <nav class="main-navbar">
        <div class="container">
            <ul>

                <!-- Dashboard -->
                <li class="menu-item">
                    <a href="../Project/dashboard.php" class="menu-link">
                        <i class="bi bi-grid-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <!-- Overview -->
                <li class="menu-item">
                    <a href="../Project/bussinf.php" class="menu-link">
                        <i class="bi bi-grid-fill"></i>
                        <span>Overview</span>
                    </a>
                </li>

                <!-- Inbox — Admin and Manager only -->
                <?php if ($sess_roles == 1 || $sess_roles == 3) { ?>
                    <li class="menu-item">
                        <a href="../Project/inbox.php" class="menu-link">
                            <i class="bi bi-envelope"></i>
                            <span>Inbox <span class="badge bg-red"></span></span>
                        </a>
                    </li>
                <?php } ?>

                <!-- Risk Tracker -->
                <li class="menu-item has-sub">
                    <a href="#" class="menu-link">
                        <i class="bi bi-box-seam"></i>
                        <span>Risk Tracker</span>
                    </a>
                    <div class="submenu">
                        <div class="submenu-group-wrapper">
                            <ul class="submenu-group">
                                <li class="submenu-item">
                                    <a href="../Project/riskview.php" class="submenu-link">Risk Tracker</a>
                                </li>
                                <li class="submenu-item">
                                    <a href="../Project/risk_report.php" class="submenu-link">Risk Report Log</a>
                                </li>
                                <li class="submenu-item">
                                    <a href="../Project/bulk_risk_upload.php" class="submenu-link">Bulk Upload</a>
                                </li>
                                <?php if ($sess_roles == 1) { ?>
                                    <li class="submenu-item">
                                        <a href="../Project/entitylist.php" class="submenu-link">Add Entity</a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </li>

                <!-- Risks — all roles -->
                <li class="menu-item has-sub">
                    <a href="#" class="menu-link">
                        <i class="bi bi-file-earmark-medical-fill"></i>
                        <span>Risks</span>
                    </a>
                    <div class="submenu">
                        <div class="submenu-group-wrapper">
                            <ul class="submenu-group">
                                <li class="submenu-item">
                                    <a href="../Project/risklist.php" class="submenu-link">Risk Lists</a>
                                </li>
                                <li class="submenu-item">
                                    <a href="../Project/riskassess.php" class="submenu-link">Risk Assessment</a>
                                </li>
                                <li class="submenu-item">
                                    <a href="../Project/risk_register_report.php" class="submenu-link">Risk Register</a>
                                </li>
                                <li class="submenu-item">
                                    <a href="risktop.php" class="submenu-link">Top 10 Risks</a>
                                </li>
                                <li class="submenu-item">
                                    <a href="riskmatrix.php" class="submenu-link">Risk Ranking</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>

                <!-- Risk Treatment — all roles -->
                <li class="menu-item has-sub">
                    <a href="#" class="menu-link">
                        <i class="bi bi-arrow-right-square-fill"></i>
                        <span>Risk Treatment</span>
                    </a>
                    <div class="submenu">
                        <div class="submenu-group-wrapper">
                            <ul class="submenu-group">
                                <li class="submenu-item">
                                    <a href="../Project/risktreatment.php" class="submenu-link">Risk Treatment</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>

                <!-- Controls Library — all roles -->
                <li class="menu-item">
                    <a href="../Project/controls.php" class="menu-link">
                        <i class="bi bi-stack"></i>
                        <span>Controls Lib.</span>
                    </a>
                </li>

                <!-- Risk Monitor — all roles -->
                <li class="menu-item has-sub">
                    <a href="#" class="menu-link">
                        <i class="bi bi-table"></i>
                        <span>Risk Monitor</span>
                    </a>
                    <div class="submenu">
                        <div class="submenu-group-wrapper">
                            <ul class="submenu-group">
                                <li class="submenu-item">
                                    <a href="../Project/kra_settings.php" class="submenu-link">KRI Measure</a>
                                </li>
                                <li class="submenu-item">
                                    <a href="../Project/kri.php" class="submenu-link">KRI</a>
                                </li>
                                <li class="submenu-item">
                                    <a href="../Project/incidents.php" class="submenu-link">Incidents</a>
                                </li>
                                <li class="submenu-item">
                                    <a href="../Project/actions.php" class="submenu-link">Actions</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>

                <!-- Recommendations — all roles -->
                <li class="menu-item">
                    <a href="../Project/recommendations.php" class="menu-link">
                        <i class="bi bi-bookmark-check-fill"></i>
                        <span>Recommendations</span>
                    </a>
                </li>

                <!-- Internal Audit — all roles (links added progressively per implementation phase) -->
                <li class="menu-item has-sub">
                    <a href="#" class="menu-link">
                        <i class="bi bi-clipboard2-check-fill"></i>
                        <span>Internal Audit</span>
                    </a>
                    <div class="submenu">
                        <div class="submenu-group-wrapper">
                            <ul class="submenu-group">
                                <li class="submenu-item">
                                    <a href="../Project/iacharter.php" class="submenu-link">Charters</a>
                                </li>
                                <li class="submenu-item">
                                    <a href="../Project/iastrategicplan.php" class="submenu-link">Strategic Plan</a>
                                </li>
                                <li class="submenu-item">
                                    <a href="../Project/iaannualplan.php" class="submenu-link">Annual Plan</a>
                                </li>
                                <li class="submenu-item">
                                    <a href="../Project/engagements.php" class="submenu-link">Engagements</a>
                                </li>
                                <li class="submenu-item">
                                    <a href="../Project/findingsdatabase.php" class="submenu-link">Findings Database</a>
                                </li>
                                <li class="submenu-item">
                                    <a href="../Project/iareports.php" class="submenu-link">Reports</a>
                                </li>
                                <li class="submenu-item">
                                    <a href="../Project/iaqa.php" class="submenu-link">Performance &amp; QA</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>

                <!-- Settings — Admin and Manager only -->
                <?php if ($sess_roles == 1 || $sess_roles == 3) { ?>
                    <li class="menu-item has-sub">
                        <a href="#" class="menu-link">
                            <i class="bi bi-gear-fill"></i>
                            <span>Settings</span>
                        </a>
                        <div class="submenu">
                            <div class="submenu-group-wrapper">
                                <ul class="submenu-group">
                                    <?php if ($sess_roles == 1) { ?>
                                        <li class="submenu-item">
                                            <a href="../Project/userslist.php" class="submenu-link">User Management</a>
                                        </li>
                                    <?php }else{} ?>
                                    <li class="submenu-item">
                                        <a href="../Project/impact.php" class="submenu-link">Impact Levels</a>
                                    </li>
                                    <li class="submenu-item">
                                        <a href="../Project/likelihood.php" class="submenu-link">Likelihood Level</a>
                                    </li>
                                    <li class="submenu-item">
                                        <a href="../Project/riskcat.php" class="submenu-link">Risk Category</a>
                                    </li>
                                    <li class="submenu-item">
                                        <a href="../Project/controlstrength.php" class="submenu-link">Control Strength</a>
                                    </li>
                                    <li class="submenu-item">
                                        <a href="../Project/controltype.php" class="submenu-link">Control Type</a>
                                    </li>
                                    <?php if ($sess_roles == 1) { ?>
                                        <li class="submenu-item">
                                            <a href="../Project/activitylog.php" class="submenu-link">Activity Logs</a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                    </li>
                <?php } ?>

            </ul>
        </div>
    </nav>

</header>
