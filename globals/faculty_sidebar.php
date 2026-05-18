<!-- LEFT SIDEBAR -->
<div class="sidebar" id="sidebar">

    <!-- CLOSE BUTTON -->
    <div class="close-btn text-end" id="close-btn">

        <i class="bi bi-x"></i>

    </div>

    <!-- SIDEBAR BRAND -->
    <div class="sidebar-brand">

        <img
            src="../assets/logo.jpg"
            alt="Logo">

        <h5>

            Faculty

        </h5>

    </div>

    <!-- NAVIGATION -->
    <nav class="nav flex-column">

        <!-- DASHBOARD -->
        <a class="nav-link active" href="index.php">

            <i class="bi bi-house-fill"></i>

            Dashboard

        </a>

        <!-- ACCOUNTS -->
        <a
            class="nav-link collapsed"
            data-bs-toggle="collapse"
            href="#accountsSubmenu">

            <i class="bi bi-person-circle"></i>

            Manage Profile

            <i class="bi bi-chevron-right dropdown-icon ms-auto"></i>

        </a>

        <div
            class="collapse submenu"
            id="accountsSubmenu">


            <a class="nav-link" href="profile.php">

                View Profile

            </a>

        </div>


       

       
      

     

        <!-- LOGOUT -->
        <a class="nav-link logout-link" href="logout.php">

            <i class="bi bi-box-arrow-right"></i>

            Logout

        </a>

    </nav>

</div>

<style>
    body {

        font-family: 'Poppins', sans-serif;

        background: #f8f9fa;

        overflow-x: hidden;
    }

    /* ========================================
       SIDEBAR
    ======================================== */

    .sidebar {

        min-height: 100vh;

        height: 100vh;

        background: #ffffff;

        border-right: 1px solid #dee2e6;

        position: fixed;

        top: 0;

        left: 0;

        width: 260px;

        padding: 20px;

        overflow-y: auto;

        overflow-x: hidden;

        transition: 0.3s ease;

        z-index: 1000;

        box-shadow:
            4px 0 18px rgba(0, 0, 0, 0.04);

        scrollbar-width: thin;

        scrollbar-color:
            rgba(13, 110, 253, 0.20) transparent;
    }

    /* SCROLLBAR */

    .sidebar::-webkit-scrollbar {

        width: 6px;
    }

    .sidebar::-webkit-scrollbar-thumb {

        background:
            rgba(13, 110, 253, 0.18);

        border-radius: 20px;
    }

    .sidebar::-webkit-scrollbar-thumb:hover {

        background:
            rgba(13, 110, 253, 0.35);
    }

    /* DECORATION */

    .sidebar::before {

        content: '';

        position: absolute;

        top: -50px;

        right: -50px;

        width: 150px;

        height: 150px;

        background:
            rgba(13, 110, 253, 0.08);

        border-radius: 50%;
    }

    .sidebar::after {

        content: '';

        position: absolute;

        bottom: -50px;

        left: -50px;

        width: 150px;

        height: 150px;

        background:
            rgba(13, 110, 253, 0.08);

        border-radius: 50%;
    }

    /* ========================================
       SIDEBAR BRAND
    ======================================== */

    .sidebar .sidebar-brand {

        display: flex;

        align-items: center;

        margin-bottom: 40px;

        position: relative;

        z-index: 1;
    }

    .sidebar .sidebar-brand img {

        max-width: 50px;

        margin-right: 10px;

        border-radius: 50%;
    }

    .sidebar .sidebar-brand h5 {

        margin: 0;

        font-weight: 700;

        color: #0d47a1;
    }

    /* ========================================
       NAV LINKS
    ======================================== */

    .sidebar .nav-link {

        color: #6c757d;

        font-weight: 600;

        margin: 6px 0;

        border-radius: 12px;

        position: relative;

        z-index: 1;

        transition: 0.25s ease;

        display: flex;

        align-items: center;

        font-size: 0.86rem;

        text-align: left;

        padding: 12px 14px;
    }

    .sidebar .nav-link i {

        margin-right: 10px;

        font-size: 1rem;
    }

    /* HOVER */

    .sidebar .nav-link:hover {

        color: #fff;

        background-color: #0d6efd;

        transform: translateX(4px);

        box-shadow:
            0 6px 14px rgba(13, 110, 253, 0.15);
    }

    /* ACTIVE */

    .sidebar .nav-link.active {

        background: #0d6efd;

        color: #fff;

        box-shadow:
            0 8px 18px rgba(13, 110, 253, 0.18);
    }

    /* ========================================
       SUBMENU
    ======================================== */

    .sidebar .submenu a {

        font-weight: 500;

        padding-left: 42px;

        font-size: 0.8rem;

        text-align: left;

        opacity: 0.92;
    }

    /* ========================================
       DROPDOWN ICON
    ======================================== */

    .sidebar .nav-link[data-bs-toggle="collapse"] i.dropdown-icon {

        transition: transform 0.3s;
    }

    .sidebar .nav-link.collapsed i.dropdown-icon {

        transform: rotate(0deg);
    }

    .sidebar .nav-link:not(.collapsed) i.dropdown-icon {

        transform: rotate(90deg);
    }

    /* ========================================
       LOGOUT
    ======================================== */

    .logout-link {

        color: #dc3545 !important;
    }

    .logout-link:hover {

        background: #dc3545 !important;

        color: white !important;
    }

    /* ========================================
       CLOSE BUTTON
    ======================================== */

    .sidebar .close-btn {

        display: none;

        font-size: 1.5rem;

        position: absolute;

        top: 15px;

        right: 15px;

        cursor: pointer;

        z-index: 1001;
    }

    /* ========================================
       MAIN CONTENT
    ======================================== */

    .content {

        margin-left: 260px;

        padding: 20px;

        transition: 0.3s;
    }

    /* ========================================
       TOP NAVBAR
    ======================================== */

    .top-navbar {

        background: #ffffff;

        padding: 12px 20px;

        border-bottom: 1px solid #dee2e6;

        display: flex;

        align-items: center;

        justify-content: space-between;

        position: sticky;

        top: 0;

        z-index: 10;

        border-radius: 14px;

        box-shadow:
            0 4px 14px rgba(0, 0, 0, 0.03);

        margin-bottom: 20px;
    }

    .toggle-btn {

        display: none;

        font-size: 1.5rem;

        cursor: pointer;

        color: #0d6efd;
    }

    /* ========================================
       RESPONSIVE
    ======================================== */

    @media(max-width:992px) {

        .sidebar {

            left: -280px;
        }

        .sidebar.show {

            left: 0;
        }

        .sidebar .close-btn {

            display: block;
        }

        .content {

            margin-left: 0;
        }

        .toggle-btn {

            display: block;
        }
    }
</style>

