<?php
session_start();

if (!isset($_SESSION['employeeUsername'])) {
    header("location:admin-login.php");
}
?>

<?php
// Get the current file name without the directory and extension
$current_page = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php
        $currentPage = basename($_SERVER['PHP_SELF'], ".php"); // Get the filename without extension
        $formattedPage = "Admin | " . ucfirst(str_replace('-', ' ', $currentPage)); // Prepend 'Admin |'
        echo $formattedPage;
        ?>
    </title>
    <link rel="icon" href="../img/icon/coffeLogo.png" type="image/png" media="(prefers-color-scheme: light)">
    <link rel="icon" href="../img/icon/whiteLogo.png" type="image/png" media="(prefers-color-scheme: dark)">
    <link rel="stylesheet" href="../css/admin.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
</head>

<body>
    <main>
        <div class="d-flex">
            <!-- Sidebar -->
            <div class="nav-container">

                <!-- Logo -->
                <div>
                    <img class="logo" src="../images/logowhite.png" alt="Logo" style="width: 80px; height: 80px;">
                </div>


                <!-- Navigation Links -->
                <div class="nav-items">
                    <div class="nav-item <?= ($current_page == 'orders.php') ? 'active' : '' ?>">
                        <a href="orders.php"
                            class="d-flex flex-column align-items-center text-decoration-none text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                class="bi bi-cart3" viewBox="0 0 16 16">
                                <path
                                    d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .49.598l-1 5a.5.5 0 0 1-.465.401l-9.397.472L4.415 11H13a.5.5 0 0 1 0 1H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l.84 4.479 9.144-.459L13.89 4zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2" />
                            </svg>
                            <span>Orders</span>
                        </a>
                    </div>

                    <div class="nav-item mt-3 <?= ($current_page == 'product.php') ? 'active' : '' ?>">
                        <a href="product.php"
                            class="d-flex flex-column align-items-center text-decoration-none text-white">
                            <!-- SVG + Text -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
                                class="bi bi-inbox" viewBox="0 0 16 16">
                                <path
                                    d="M4.98 4a.5.5 0 0 0-.39.188L1.54 8H6a.5.5 0 0 1 .5.5 1.5 1.5 0 1 0 3 0A.5.5 0 0 1 10 8h4.46l-3.05-3.812A.5.5 0 0 0 11.02 4zm9.954 5H10.45a2.5 2.5 0 0 1-4.9 0H1.066l.32 2.562a.5.5 0 0 0 .497.438h12.234a.5.5 0 0 0 .496-.438zM3.809 3.563A1.5 1.5 0 0 1 4.981 3h6.038a1.5 1.5 0 0 1 1.172.563l3.7 4.625a.5.5 0 0 1 .105.374l-.39 3.124A1.5 1.5 0 0 1 14.117 13H1.883a1.5 1.5 0 0 1-1.489-1.314l-.39-3.124a.5.5 0 0 1 .106-.374z" />
                            </svg>
                            <span>Inventory</span>
                        </a>
                    </div>
                </div>

                <!-- Logout Button -->
                <div class="mt-5">
                    <div class="nav-item">
                        <a href="admin-logout.php"
                            class="d-flex flex-column align-items-center text-decoration-none text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
                                class="bi bi-box-arrow-in-right" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-8A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0z" />
                                <path fill-rule="evenodd"
                                    d="M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="bodyContainer p-4">
                <div class="p-4 bg-white h-100 border"> 
