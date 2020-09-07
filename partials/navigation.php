<nav class="sidebar">
    <div class="sidebar-header">
        <a href="<?=$config['URL']?>" class="sidebar-brand">
            Paragon<span> CMS</span>
        </a>
        <div class="sidebar-toggler not-active">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
    <div class="sidebar-body">
        <ul class="nav">
            <li class="nav-item nav-category">Main</li>
            <li class="nav-item">
                <a href="<?=$config['URL']?>" class="nav-link">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">Dashboard</span>
                </a>
            </li>
            <li class="nav-item nav-category">Cases</li>
            <li class="nav-item">
                <a href="<?=$config['URL']?>/index?nav=student-cases" class="nav-link">
                    <i class="link-icon fas fa-database" ></i>
                    <span class="link-title">Student Cases</span>
                </a>
            </li>
            <?php if ($logged_in_user_data["role_id"]==1): ?>
            <li class="nav-item nav-category">Settings</li>
            <li class="nav-item">
                <a href="<?=$config['URL']?>/index?nav=universities" class="nav-link">
                    <i class="link-icon fas fa-graduation-cap" ></i>
                    <span class="link-title">Universities</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?=$config['URL']?>/index?nav=countries" class="nav-link">
                    <i class="link-icon" data-feather="globe"></i>
                    <span class="link-title">Countries</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?=$config['URL']?>/index?nav=franchise" class="nav-link">
                    <i class="link-icon far fa-building" ></i>
                    <span class="link-title">Franchise</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?=$config['URL']?>/index?nav=document-types" class="nav-link">
                    <i class="link-icon far fa-folder" ></i>
                    <span class="link-title">Document Types</span>
                </a>
            </li>
            <li class="nav-item nav-category">Credential</li>
            <li class="nav-item">
                <a href="<?=$config['URL']?>/index?nav=user" class="nav-link">
                    <i class="link-icon fas fa-user-circle" ></i>
                    <span class="link-title">Add New Users</span>
                </a>
            </li>

            <li class="nav-item nav-category">Docs</li>
            <li class="nav-item">
                <a href="<?=$config['URL']?>/index?nav=reports" class="nav-link">
                    <i class="link-icon" data-feather="hash"></i>
                    <span class="link-title">Reports</span>
                </a>
            </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>
<nav class="settings-sidebar">
    <div class="sidebar-body">
        <a href="#" class="settings-sidebar-toggler">
            <i data-feather="settings"></i>
        </a>
        <h6 class="text-muted">Sidebar:</h6>
        <div class="form-group border-bottom">
            <div class="form-check form-check-inline">
                <label class="form-check-label">
                    <input type="radio" class="form-check-input" name="sidebarThemeSettings" id="sidebarLight" value="sidebar-light" checked>
                    Light
                </label>
            </div>
            <div class="form-check form-check-inline">
                <label class="form-check-label">
                    <input type="radio" class="form-check-input" name="sidebarThemeSettings" id="sidebarDark" value="sidebar-dark">
                    Dark
                </label>
            </div>
        </div>
    </div>
</nav>