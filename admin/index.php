<?php

include "../src/connection.php";

global $mysqli;

/* =====================================
   TOTAL STUDENTS
===================================== */

$total_students = 0;

$students =
    $mysqli->query("

    SELECT COUNT(*) AS total

    FROM student_profiles

");

if ($students) {

    $row =
        $students->fetch_assoc();

    $total_students =
        $row['total'];
}

/* =====================================
   TOTAL FACULTY
===================================== */

$total_faculty = 0;

$faculty =
    $mysqli->query("

    SELECT COUNT(*) AS total

    FROM faculty_profiles

");

if ($faculty) {

    $row =
        $faculty->fetch_assoc();

    $total_faculty =
        $row['total'];
}

/* =====================================
   TOTAL SUBJECTS
===================================== */

$total_subjects = 0;

$subjects =
    $mysqli->query("

    SELECT COUNT(*) AS total

    FROM subjects

    WHERE archived = 0

");

if ($subjects) {

    $row =
        $subjects->fetch_assoc();

    $total_subjects =
        $row['total'];
}

/* =====================================
   TOTAL COURSES
===================================== */

$total_courses = 0;

$courses =
    $mysqli->query("

    SELECT COUNT(*) AS total

    FROM courses

    WHERE archived = 0

");

if ($courses) {

    $row =
        $courses->fetch_assoc();

    $total_courses =
        $row['total'];
}

/* =====================================
   TOTAL ACCOUNTS
===================================== */

$total_accounts = 0;

$accounts =
    $mysqli->query("

    SELECT COUNT(*) AS total

    FROM accounts

    WHERE archived = 0

");

if ($accounts) {

    $row =
        $accounts->fetch_assoc();

    $total_accounts =
        $row['total'];
}

/* =====================================
   ARCHIVED ACCOUNTS
===================================== */

$archived_accounts = 0;

$archived =
    $mysqli->query("

    SELECT COUNT(*) AS total

    FROM accounts

    WHERE archived = 1

");

if ($archived) {

    $row =
        $archived->fetch_assoc();

    $archived_accounts =
        $row['total'];
}

/* =====================================
   PENDING ACCOUNT APPROVALS
===================================== */

$pending_approvals = 0;

$pending =
    $mysqli->query("

    SELECT COUNT(*) AS total

    FROM accounts

    WHERE `status` = 0

    AND archived = 0

");

if ($pending) {

    $row =
        $pending->fetch_assoc();

    $pending_approvals =
        $row['total'];
}

/* =====================================
   APPROVED ACCOUNTS
===================================== */

$approved_accounts = 0;

$approved =
    $mysqli->query("

    SELECT COUNT(*) AS total

    FROM accounts

    WHERE `status` = 1

    AND archived = 0

");

if ($approved) {

    $row =
        $approved->fetch_assoc();

    $approved_accounts =
        $row['total'];
}

/* =====================================
   ASSIGNED SUBJECTS
===================================== */

$total_assigned_subjects = 0;

$assigned =
    $mysqli->query("

    SELECT COUNT(*) AS total

    FROM academic_assignments

");

if ($assigned) {

    $row =
        $assigned->fetch_assoc();

    $total_assigned_subjects =
        $row['total'];
}

/* =====================================
   ACTIVE SCHOOL YEAR
===================================== */

$current_school_year = "N/A";

$current_semester = "N/A";

$schoolYear =
    $mysqli->query("

    SELECT *

    FROM school_years

    WHERE `is_active` = 1

    LIMIT 1

");

if (

    $schoolYear &&

    $schoolYear->num_rows > 0

) {

    $row =
        $schoolYear->fetch_assoc();

    $current_school_year =
        $row['school_year'];

    $current_semester =
        $row['semester'];
}

/* =====================================
   CURRENT DATE TIME
===================================== */

date_default_timezone_set(
    'Asia/Manila'
);

$current_datetime =
    date(
        "F d, Y h:i:s A"
    );

?>

<?php include "../globals/admin_head.php" ?>

<body>

    <?php include "../globals/admin_sidebar.php" ?>

    <div class="content">

        <div class="container-fluid mt-4">

            <!-- HEADER -->
            <div class="
        d-flex
        justify-content-between
        align-items-center
        mb-4">

                <div>

                    <h2 class="
                fw-bold
                text-primary
                mb-1
                ">

                        Dashboard

                    </h2>

                    <p class="
                text-muted
                mb-0
                ">

                        Academic Management System Overview

                    </p>

                </div>

                <div class="text-end">

                    <h5 class="
                fw-bold
                mb-1
                ">

                        <?php
                        echo
                        $current_datetime;
                        ?>

                    </h5>

                    

                </div>

            </div>

            <!-- ACTIVE SCHOOL YEAR -->
            <div class="
        card
        border-0
        shadow-sm
        rounded-4
        mb-4">

                <div class="card-body">

                    <div class="
                d-flex
                justify-content-between
                align-items-center">

                        <div>

                            <h5 class="
                        fw-bold
                        text-primary
                        mb-1
                        ">

                                Active School Year

                            </h5>

                            <p class="
                        text-muted
                        mb-0
                        ">

                                Current Academic Period

                            </p>

                        </div>

                        <div class="text-end">

                            <h3 class="
                        fw-bold
                        mb-1
                        ">

                                <?php
                                echo
                                $current_school_year;
                                ?>

                            </h3>

                            <span class="
                        badge
                        bg-primary
                        px-4
                        py-2
                        rounded-pill
                        ">

                                <?php
                                echo
                                $current_semester;
                                ?>

                            </span>

                        </div>

                    </div>

                </div>

            </div>

            <!-- DASHBOARD CARDS -->
            <div class="row g-4">

                <!-- TOTAL STUDENTS -->
                <div class="col-xl-3 col-md-6">

                    <div class="
                card
                border-0
                shadow-sm
                rounded-4">

                        <div class="card-body">

                            <p class="
                        text-muted
                        mb-1
                        ">

                                Total Students

                            </p>

                            <h2 class="
                        fw-bold
                        text-primary
                        ">

                                <?php
                                echo
                                $total_students;
                                ?>

                            </h2>

                        </div>

                    </div>

                </div>

                <!-- TOTAL FACULTY -->
                <div class="col-xl-3 col-md-6">

                    <div class="
                card
                border-0
                shadow-sm
                rounded-4">

                        <div class="card-body">

                            <p class="
                        text-muted
                        mb-1
                        ">

                                Total Faculty

                            </p>

                            <h2 class="
                        fw-bold
                        text-success
                        ">

                                <?php
                                echo
                                $total_faculty;
                                ?>

                            </h2>

                        </div>

                    </div>

                </div>

                <!-- TOTAL SUBJECTS -->
                <div class="col-xl-3 col-md-6">

                    <div class="
                card
                border-0
                shadow-sm
                rounded-4">

                        <div class="card-body">

                            <p class="
                        text-muted
                        mb-1
                        ">

                                Total Subjects

                            </p>

                            <h2 class="
                        fw-bold
                        text-warning
                        ">

                                <?php
                                echo
                                $total_subjects;
                                ?>

                            </h2>

                        </div>

                    </div>

                </div>

                <!-- TOTAL COURSES -->
                <div class="col-xl-3 col-md-6">

                    <div class="
                card
                border-0
                shadow-sm
                rounded-4">

                        <div class="card-body">

                            <p class="
                        text-muted
                        mb-1
                        ">

                                Total Courses

                            </p>

                            <h2 class="
                        fw-bold
                        text-info
                        ">

                                <?php
                                echo
                                $total_courses;
                                ?>

                            </h2>

                        </div>

                    </div>

                </div>

                <!-- TOTAL ACCOUNTS -->
                <div class="col-xl-3 col-md-6">

                    <div class="
                card
                border-0
                shadow-sm
                rounded-4">

                        <div class="card-body">

                            <p class="
                        text-muted
                        mb-1
                        ">

                                Total Accounts

                            </p>

                            <h2 class="
                        fw-bold
                        text-dark
                        ">

                                <?php
                                echo
                                $total_accounts;
                                ?>

                            </h2>

                        </div>

                    </div>

                </div>

                <!-- PENDING APPROVALS -->
                <div class="col-xl-3 col-md-6">

                    <div class="
                card
                border-0
                shadow-sm
                rounded-4">

                        <div class="card-body">

                            <p class="
                        text-muted
                        mb-1
                        ">

                                Pending Account Approvals

                            </p>

                            <h2 class="
                        fw-bold
                        text-danger
                        ">

                                <?php
                                echo
                                $pending_approvals;
                                ?>

                            </h2>

                        </div>

                    </div>

                </div>

                <!-- APPROVED ACCOUNTS -->
                <div class="col-xl-3 col-md-6">

                    <div class="
                card
                border-0
                shadow-sm
                rounded-4">

                        <div class="card-body">

                            <p class="
                        text-muted
                        mb-1
                        ">

                                Approved Accounts

                            </p>

                            <h2 class="
                        fw-bold
                        text-success
                        ">

                                <?php
                                echo
                                $approved_accounts;
                                ?>

                            </h2>

                        </div>

                    </div>

                </div>

                <!-- ARCHIVED ACCOUNTS -->
                <div class="col-xl-3 col-md-6">

                    <div class="
                card
                border-0
                shadow-sm
                rounded-4">

                        <div class="card-body">

                            <p class="
                        text-muted
                        mb-1
                        ">

                                Archived Accounts

                            </p>

                            <h2 class="
                        fw-bold
                        text-secondary
                        ">

                                <?php
                                echo
                                $archived_accounts;
                                ?>

                            </h2>

                        </div>

                    </div>

                </div>

              
            </div>

        </div>

    </div>

    <?php include "../globals/admin_scripts.php" ?>

</body>

</html>