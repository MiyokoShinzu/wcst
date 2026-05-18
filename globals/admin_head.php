<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WCST-Admin</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- FullCalendar -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
    <link href="https://cdn.datatables.net/v/dt/jszip-3.10.1/dt-2.0.8/af-2.7.0/b-3.0.2/b-colvis-3.0.2/b-html5-3.0.2/b-print-3.0.2/cr-2.0.3/date-1.5.2/fc-5.0.1/fh-4.0.1/kt-2.12.1/r-3.0.2/rg-1.5.0/rr-1.5.0/sc-2.4.3/sb-1.7.1/sp-2.3.1/sl-2.0.3/sr-1.4.1/datatables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" />
    <link rel="icon" href="../assets/logo.jpg">
    <?php

    if (

        session_status() === PHP_SESSION_NONE

    ) {

        session_start();
    }

    include "../src/connection.php";

    global $mysqli;

    /* =====================================
   CHECK LOGIN
===================================== */

    if (

        !isset($_SESSION['user_id'])

    ) {

        header(

            "Location: ../login.php"

        );

        exit;
    }

    /* =====================================
   USER ID
===================================== */

    $user_id =
        intval(
            $_SESSION['user_id']
        );

    /* =====================================
   CHECK ROLE
===================================== */

    $stmt =
        $mysqli->prepare("

    SELECT role

    FROM accounts

    WHERE id = ?

    LIMIT 1

");

    $stmt->bind_param(

        "i",

        $user_id

    );

    $stmt->execute();

    $result =
        $stmt->get_result();

    /* =====================================
   ACCOUNT NOT FOUND
===================================== */

    if (

        $result->num_rows == 0

    ) {

        session_destroy();

        header(

            "Location: ../login.php"

        );

        exit;
    }

    $user =
        $result->fetch_assoc();

    /* =====================================
   VALIDATE FACULTY ROLE
===================================== */

    if (

        strtolower(
            $user['role']
        ) != 'admin'

    ) {

        session_destroy();

        header(

            "Location: ../login.php"

        );

        exit;
    }

    ?>
    <style>
        .dt-buttons {
            width: 100%;
        }

        .buttons-excel {
            background: rgb(0, 154, 16);
            width: 100px;
            margin: 10px 10px;
        }

        .buttons-print {
            background: rgba(1, 77, 94, 0.52);
            width: 100px;
            margin: 10px 10px;
        }

        .buttons-colvis {
            width: auto;
            height: auto;
            margin: 10px 10px;
        }

        .buttons-pdf {
            background: rgb(202, 8, 8);
            width: 100px;
            margin: 10px 10px;
        }

        .add_account,
        .add_course,
        .add_school_year,
        .add_subject {
            background: rgb(9, 93, 220);
            color: white;
            width: 100px;
            margin: 10px 10px;
        }

        .add_account:hover,
        .add_course:hover,
        .add_school_year:hover,
        .add_subject:hover {
            background: rgb(0, 32, 77);
        }

        .buttons-excel:hover {
            background: rgb(0, 77, 8);
        }

        .buttons-print:hover {
            background: rgb(0, 54, 69);
        }

        .buttons-pdf:hover {
            background: rgb(153, 6, 6);
        }

        .dropdown {
            position: relative;
            display: inline-block;
            z-index: 100;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            left: 100%;
            background-color: #fff;
            border: 1px solid var(--bs-info);
            min-width: 160px;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
            padding: 12px 16px;
            z-index: 100;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .dropdown-item:hover {
            color: var(--bs-info);
        }

        .dt-search {
            display: flex;
            align-items: center;
            justify-content: flex-end;
        }

        div.dt-container .dt-search input {
            outline: none;
        }

        div.dt-container .dt-search input:focus {
            border: 1px solid var(--bs-info);
        }

        div.dtsb-searchBuilder button.dtsb-button {
            background: cadetblue;
            color: #fff;
        }

        div.dtsb-searchBuilder div.dtsb-group div.dtsb-logicContainer button.dtsb-logic {
            color: #000;
        }

        div.dt-length {
            display: flex;
            align-items: center;
            justify-content: flex-end;
        }

        td {
            font-size: 12px;
        }

        /* =====================================
   DATATABLE RESPONSIVE ICON
===================================== */

        table.dataTable.dtr-inline.collapsed>tbody>tr>td.dtr-control,
        table.dataTable.dtr-inline.collapsed>tbody>tr>th.dtr-control {

            position: relative;

            padding-left: 35px;
        }

        table.dataTable.dtr-inline.collapsed>tbody>tr>td.dtr-control::before,
        table.dataTable.dtr-inline.collapsed>tbody>tr>th.dtr-control::before {

            position: absolute;

            top: 50%;

            left: 10px;

            transform: translateY(-50%);

            width: 18px;

            height: 18px;

            border-radius: 50%;

            background: var(--bs-primary);

            color: white;

            display: flex;

            align-items: center;

            justify-content: center;

            font-size: 12px;

            font-weight: bold;

            content: "+";

            border: 2px solid #fff;

            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        /* =====================================
   EXPANDED ICON
===================================== */

        table.dataTable.dtr-inline.collapsed>tbody>tr.dtr-expanded>td.dtr-control::before,
        table.dataTable.dtr-inline.collapsed>tbody>tr.dtr-expanded>th.dtr-control::before {

            content: "--";
            display: flex;
            align-self: center;
            justify-content: center;
            background: var(--bs-secondary);
        }
    </style>
</head>