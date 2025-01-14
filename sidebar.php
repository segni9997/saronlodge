<head>
    <style>
        .nav .active a {
            color: #86B817 !important;
            background-color: transparent !important;
        }

        .nav .active a:hover {
            color: #86B817 !important;
        }
    </style>
</head>

<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
    <div class="profile-sidebar">
        <div class="profile-userpic">
            <img src="img/user.png" class="img-responsive" alt="">
        </div>
        <div class="profile-usertitle">
            <div class="profile-usertitle-name"><?php echo $user['name']; ?></div>
            <div class="profile-usertitle-status"><?php echo $_SESSION['role_name']; ?></div>
        </div>
        <div class="clear"></div>
    </div>
    <div class="divider"></div>
    <ul class="nav menu">
        <?php 
        if (isset($_GET['dashboard'])) { ?>
            <li class="active">
                <a href="index.php?dashboard"><em class="fa fa-dashboard">&nbsp;</em>
                    Dashboard
                </a>
            </li>
        <?php } else { ?>
            <li>
                <a href="index.php?dashboard"><em class="fa fa-dashboard">&nbsp;</em>
                    Dashboard
                </a>
            </li>
        <?php } 
    
        if ($_SESSION['role_name'] === 'Receptionist') { 
            if (isset($_GET['reservation'])) { ?>
                <li class="active">
                    <a href="index.php?reservation"><em class="fa fa-calendar">&nbsp;</em>
                        Reservation
                    </a>
                </li>
            <?php } else { ?>
                <li>
                    <a href="index.php?reservation"><em class="fa fa-calendar">&nbsp;</em>
                        Reservation
                    </a>
                </li>
            <?php }
        }

        if (isset($_GET['room_mang'])) { ?>
            <li class="active">
                <a href="index.php?room_mang"><em class="fa fa-bed">&nbsp;</em>
                    Manage Rooms
                </a>
            </li>
        <?php } else { ?>
            <li>
                <a href="index.php?room_mang"><em class="fa fa-bed">&nbsp;</em>
                    Manage Rooms
                </a>
            </li>
        <?php } 

        if ($_SESSION['role_name'] === 'Manager') { 
            if (isset($_GET['staff_mang'])) { ?>
                <li class="active">
                    <a href="index.php?staff_mang"><em class="fa fa-users">&nbsp;</em>
                        Staff Section
                    </a>
                </li>
            <?php } else { ?>
                <li>
                    <a href="index.php?staff_mang"><em class="fa fa-users">&nbsp;</em>
                        Staff Section
                    </a>
                </li>
            <?php }
        }

        if ($_SESSION['role_name'] === 'Receptionist') { 
            if (isset($_GET['check_payement'])) { ?>
                <li class="active">
                    <a href="index.php?check_payement"><em class="fa fa-users">&nbsp;</em>
                        Check Online Payement
                    </a>
                </li>
            <?php } else { ?>
                <li>
                    <a href="index.php?check_payement"><em class="fa fa-users">&nbsp;</em>
                        Check Online Payement
                    </a>
                </li>
            <?php }
        }

        if (isset($_GET['complain'])) { ?>
            <li class="active">
                <a href="index.php?complain"><em class="fa fa-comments">&nbsp;</em>
                    Manage Complaints
                </a>
            </li>
        <?php } else { ?>
            <li>
                <a href="index.php?complain"><em class="fa fa-comments">&nbsp;</em>
                    Manage Complaints
                </a>
            </li>
        <?php } 

        if (isset($_GET['statistics'])) { ?>
            <li class="active">
                <a href="index.php?statistics"><em class="fa fa-pie-chart">&nbsp;</em>
                    Statistics
                </a>
            </li>
        <?php } else { ?>
            <li>
                <a href="index.php?statistics"><em class="fa fa-pie-chart">&nbsp;</em>
                    Statistics
                </a>
            </li>
        <?php } ?>
    </ul>
</div><!--/.sidebar-->
