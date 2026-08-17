<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Second-Hand Book Marketplace</title>

    <link rel="stylesheet" href="/bookloop-marketplace/css/style.css">

</head>


<body>

<nav class="site-navbar">

    <div class="navbar-container">

        <!-- Logo -->
        <a class="navbar-brand" href="/bookloop-marketplace/index.php">
            BookLoop Marketplace
        </a>


        <!-- Mobile Menu Button -->
        <button
            class="navbar-toggle"
            type="button"
            onclick="toggleNavbar()"
            aria-label="Toggle navigation"
        >
            ☰
        </button>


        <!-- Navigation -->
        <div class="navbar-menu" id="navbarMenu">

            <?php if (isset($_SESSION['user_id'])) { ?>

                <?php if ($_SESSION['role'] == "customer") { ?>

                    <ul class="navbar-links">

                        <li>
                            <a href="/bookloop-marketplace/index.php">
                                Home
                            </a>
                        </li>

                        <li>
                            <a href="/bookloop-marketplace/customer/browse_books.php">
                                Browse books
                            </a>
                        </li>

                        <li>
                            <a href="/bookloop-marketplace/customer/cart.php">
                                Cart
                            </a>
                        </li>

                        <li>
                            <a href="/bookloop-marketplace/customer/dashboard.php">
                                Dashboard
                            </a>
                        </li>
						
						<li>
                            <a href="/bookloop-marketplace/customer/contact.php">
                                Contact Us
                            </a>
                        </li>

                    </ul>


                    <a
                        class="nav-button logout-button"
                        href="/bookloop-marketplace/logout.php"
                    >
                        Logout
                    </a>


                <?php } else { ?>

                    <!-- Staff -->
                    <ul class="navbar-links staff-links">

                        <li>
                            <a href="/bookloop-marketplace/staff/dashboard.php">
                                Dashboard
                            </a>
                        </li>

                    </ul>


                    <a
                        class="nav-button logout-button"
                        href="/bookloop-marketplace/logout.php"
                    >
                        Logout
                    </a>


                <?php } ?>


            <?php } else { ?>

                <!-- Guest -->
                <div class="guest-buttons">

                    <a
                        href="/bookloop-marketplace/login.php"
                        class="nav-button login-button"
                    >
                        Login
                    </a>

                    <a
                        href="/bookloop-marketplace/register.php"
                        class="nav-button register-button"
                    >
                        Register
                    </a>

                </div>

            <?php } ?>

        </div>

    </div>

</nav>


<main>


<script>

function toggleNavbar() {

    const menu = document.getElementById("navbarMenu");

    menu.classList.toggle("navbar-menu-active");

}

</script>