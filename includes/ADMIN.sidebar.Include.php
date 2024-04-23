<aside id="sidebar">
    <div class="d-flex">
        <a href="../" class="toggle-btn">
            <i class="lni lni-grid-alt"></i>
        </a>
        <div class="sidebar-logo">
            <a href="../">Dashboard</a>
        </div>
    </div>
    <ul class="sidebar-nav">
        <li class="sidebar-item">
            <a href="../users" class="sidebar-link <?= ($_SESSION['site'] === 'users') ? "active-tab" : "" ?>">
                <i class="lni lni-user"></i>
                <span>Users</span>
            </a>
        </li>
        <li class="sidebar-item sidebar-before">
            <a class="sidebar-link has-dropdown" data-bs-toggle="collapse" data-bs-target="#shop" aria-expanded="true"
                aria-controls="shop">
                <i class="lni lni-shopping-basket"></i>
                <span>Shops</span>
            </a>
            <ul id="shop" class="sidebar-dropdown list-unstyled collapse show">
                <li class="sidebar-item">
                    <a href="../shops/profiles.php"
                        class="sidebar-link <?= ($_SESSION['site'] === 'shopProfiles') ? "active-tab" : "" ?>">&nbsp;&nbsp;Profiles</a>
                </li>
                <li class="sidebar-item">
                    <a href="../shops/products.php"
                        class="sidebar-link <?= ($_SESSION['site'] === 'shopProducts') ? "active-tab" : "" ?>">&nbsp;&nbsp;Products</a>
                </li>
            </ul>
        </li>
        <li class="sidebar-item sidebar-after">
            <a class="sidebar-link has-dropdown collapsed" data-bs-toggle="show" data-bs-target="#shop2"
                aria-expanded="false" aria-controls="shop">
                <i class="lni lni-shopping-basket"></i>
                <span>Shops</span>
            </a>
            <ul id="shop2" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                <li class="sidebar-item">
                    <a href="../shops/profiles.php"
                        class="sidebar-link <?= ($_SESSION['site'] === 'shopProfiles') ? "active-tab" : "" ?>">&nbsp;&nbsp;Profiles</a>
                </li>
                <li class="sidebar-item">
                    <a href="../shops/products.php"
                        class="sidebar-link <?= ($_SESSION['site'] === 'shopProducts') ? "active-tab" : "" ?>">&nbsp;&nbsp;Products</a>
                </li>
            </ul>
        </li>
        <li class="sidebar-item">
            <a href="users" class="sidebar-link <?= ($_SESSION['site'] === 'notifications') ? "active-tab" : "" ?>">
                <i class="lni lni-envelope"></i>
                <span>Notifications</span>
            </a>
        </li>
    </ul>
    <div class="sidebar-footer">
        <a href="../profile" class="sidebar-link <?= ($_SESSION['site'] === 'adminAccount') ? "active-tab" : "" ?>">
            <i class="lni lni-cogs"></i>
            <span>Account Settings</span>
        </a>
        <a href="../../" class="sidebar-link">
            <i class="lni lni-backward"></i>
            <span>Back to Main Website</span>
        </a>
        <a href="../../db/logout.php" class="sidebar-link">
            <i class="lni lni-exit"></i>
            <span>Logout</span>
        </a>
    </div>
</aside>