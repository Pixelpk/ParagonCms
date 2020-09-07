<nav class="navbar">
    <a href="#" class="sidebar-toggler">
        <i data-feather="menu"></i>
    </a>
    <div class="navbar-content">
        <form class="search-form">
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i data-feather="search"></i>
                    </div>
                </div>
                <input type="text" class="form-control" id="navbarForm" placeholder="Search here...">
            </div>
        </form>
        <ul class="navbar-nav">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="languageDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="flag-icon flag-icon-us mt-1" title="us"></i> <span class="font-weight-medium ml-1 mr-1">English</span>
                </a>
                <div class="dropdown-menu" aria-labelledby="languageDropdown">
                    <a href="javascript:;" class="dropdown-item py-2"><i class="flag-icon flag-icon-us" title="us" id="us"></i> <span class="ml-1"> English </span></a>
                </div>
            </li>
            <li class="nav-item dropdown nav-notifications">
                <a class="nav-link dropdown-toggle" href="#" id="notificationDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i data-feather="bell"></i>
                    <div class="indicator">
                        <div class="circle"></div>
                    </div>
                </a>
                <div class="dropdown-menu" aria-labelledby="notificationDropdown">
                    <div class="dropdown-header d-flex align-items-center justify-content-between">
                        <p class="mb-0 font-weight-medium">New Notifications</p>

                    </div>
                    <div class="dropdown-body">
                        <?php if ($notifications==NULL): ?>
                            <?php while($n = $notification->fetch_assoc()): ?>
                            <a href="javascript:;" class="dropdown-item">
                                <div class="icon">
                                    <i data-feather="user-plus"></i>
                                </div>

                                <div class="content">
                                    <p><?=$n['sender'];?></p>
                                    <p><?=$n['type'];?></p>
                                    <p class="sub-text text-muted"><?=$n['time'];?></p>
                                </div>
                            </a>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <a href="javascript:;" class="dropdown-item">
                                <div class="icon">
                                    <i data-feather="user-plus"></i>
                                </div>
                                <div class="content">
                                    <p>No Notifications</p>
                                </div>
                            </a>
                        <?php endif; ?>



                    </div>
                    <div class="dropdown-footer d-flex align-items-center justify-content-center">
                        <a href="<?=$config['URL']?>/index?nav=notifications">View all</a>
                    </div>
                </div>
            </li>
            <li class="nav-item dropdown nav-profile">
                <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img src="assets/images/user.png" alt="userr">
                </a>
                <div class="dropdown-menu" aria-labelledby="profileDropdown">
                    <div class="dropdown-header d-flex flex-column align-items-center">
                        <div class="figure mb-3">
                            <img src="assets/images/user.png" alt="">
                        </div>
                        <div class="info text-center">
                            <p class="name font-weight-bold mb-0"><?=$logged_in_user_data["name"]?></p>
                            <p class="email text-muted mb-3"><?=$logged_in_user_data["email"]?></p>
                            <?php
                            switch($logged_in_user_data["role_id"]){
                                case 1:
                                    echo '<p class="text-center"><a href="#" class="text-primary disabled">Super Admin </a></p>';
                                    break;
                                case 2:
                                    echo '<p class="text-center"><a href="#" class="text-primary disabled">Admin </a></p>';
                                    break;
                                case 3:
                                    echo '<p class="text-center"><a href="#" class="text-primary disabled">Consultant </a></p>';
                                    break;
                                case 4:
                                    echo '<p class="text-center"><a href="#" class="text-primary disabled">Admission Team</a></p>';
                                    break;
                            }
                            ?>
                        </div>
                    </div>
                    <div class="dropdown-body">
                        <ul class="profile-nav p-0 pt-3">
                            <li class="nav-item">
                                <a href="index?nav=profile" class="nav-link">
                                    <i data-feather="edit"></i>
                                    <span>Edit Profile</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a id="logout__" href="javascript:void;" class="nav-link">
                                    <i data-feather="log-out"></i>
                                    <span>Log Out</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</nav>