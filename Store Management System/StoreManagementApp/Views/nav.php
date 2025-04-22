<?php
// Dynamically determine the path
$path = dirname($_SERVER['SCRIPT_NAME']);

// Retrieve the currently logged-in user (mock example, replace as per your authentication logic)
$currentUser = json_decode(isset($_COOKIE['currentUser']) ? $_COOKIE['currentUser'] : '{}', true);
$role = isset($currentUser['role']) ? $currentUser['role'] : null;

// Function to check if the user is an admin
function isAdmin($role) {
    return $role === 'admin';
}
?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="<?= htmlspecialchars($path); ?>/mainpage">Home</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?= htmlspecialchars($path); ?>/product">Products</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?= htmlspecialchars($path); ?>/schedule">Schedule</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?= htmlspecialchars($path); ?>/order">Orders</a>
            </li>

            <?php if (isAdmin($role)): ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?= htmlspecialchars($path); ?>/supplier">Suppliers</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="<?= htmlspecialchars($path); ?>/employee">Employees</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="<?= htmlspecialchars($path); ?>/report">Reports</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="<?= htmlspecialchars($path); ?>/settings">Settings</a>
                </li>
            <?php else: ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?= htmlspecialchars($path); ?>/settings">Settings</a>
                </li>
            <?php endif; ?>
        </ul>

<!--        --><?php //if ($currentUser): ?>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <span class="nav-link">Logged in as: <?= htmlspecialchars(isset($currentUser['username']) ? $currentUser['username'] : 'Guest'); ?></span>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= htmlspecialchars($path); ?>/logout">Logout</a>
                </li>
            </ul>
<!--        --><?php //else: ?>
<!--            <ul class="navbar-nav ml-auto">-->
<!--                <li class="nav-item">-->
<!--                    <a class="nav-link" href="--><?php //= htmlspecialchars($path); ?><!--/login">Login</a>-->
<!--                </li>-->
<!--            </ul>-->
<!--        --><?php //endif; ?>
    </div>
</nav>