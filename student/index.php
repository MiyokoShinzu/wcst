<?php

include "../src/connection.php";

global $mysqli;

/* =====================================
   START SESSION SAFELY
===================================== */

if (

    session_status() === PHP_SESSION_NONE

) {

    session_start();
}

/* =====================================
   SESSION USER
===================================== */

$user_id =
    intval(
        $_SESSION['user_id'] ?? 0
    );

/* =====================================
   STUDENT PROFILE
===================================== */

$student_profile_id = 0;

$student_name = "Student";

$student =
    $mysqli->query("

    SELECT *

    FROM student_profiles

    WHERE account_id = '$user_id'

    LIMIT 1

");

if (

    $student &&

    $student->num_rows > 0

) {

    $studentData =
        $student->fetch_assoc();

    $student_profile_id =
        intval(
            $studentData['id']
        );

    $student_name =

        $studentData['lastname']

        . ', '

        .

        $studentData['firstname'];
}

/* =====================================
   CHECKLIST QUERY
===================================== */

$query = "

    SELECT

        enrolled_subjects.id,

        enrolled_subjects.grade,

        enrolled_subjects.grade_updated,

        subjects.subject_code,
        subjects.subject_name,
        subjects.units,

        courses.course_name,

        school_years.school_year,
        school_years.semester,

        CONCAT(

            faculty_profiles.lastname,
            ', ',
            faculty_profiles.firstname,

            IF(

                faculty_profiles.middlename IS NULL
                OR
                faculty_profiles.middlename = '',

                '',

                CONCAT(
                    ' ',
                    faculty_profiles.middlename
                )

            ),

            IF(

                faculty_profiles.suffix IS NULL
                OR
                faculty_profiles.suffix = '',

                '',

                CONCAT(
                    ' ',
                    faculty_profiles.suffix
                )

            )

        ) AS faculty_name

    FROM enrolled_subjects

    INNER JOIN academic_assignments

        ON academic_assignments.id =
        enrolled_subjects.academic_assignment_id

    INNER JOIN subjects

        ON subjects.id =
        academic_assignments.subject_id

    INNER JOIN courses

        ON courses.id =
        academic_assignments.course_id

    INNER JOIN school_years

        ON school_years.id =
        academic_assignments.school_year_id

    INNER JOIN faculty_profiles

        ON faculty_profiles.id =
        academic_assignments.faculty_profile_id

    WHERE

        enrolled_subjects.student_profile_id =
        '$student_profile_id'

    ORDER BY

        school_years.school_year DESC,

        school_years.semester DESC,

        subjects.subject_name ASC

";

$checklist =
    $mysqli->query($query);

?>

<?php include "../globals/student_head.php" ?>

<body class="bg-light">

    <?php include "../globals/student_sidebar.php" ?>

    <div class="content">

        <div class="container-fluid mt-4">

            <!-- HEADER -->

            <div class="
        d-flex
        justify-content-between
        align-items-center
        mb-4
        ">

                <div>

                    <h2 class="
                fw-bold
                text-primary
                mb-1
                ">

                        Student Checklist

                    </h2>

                    <p class="
                text-muted
                mb-0
                ">

                        Welcome,
                        <?php
                        echo htmlspecialchars(
                            $student_name
                        );
                        ?>

                    </p>

                </div>

            </div>

            <!-- CHECKLIST TABLE -->

            <div class="
        card
        border-0
        shadow-sm
        rounded-4
        ">

                <div class="
            card-header
            bg-white
            border-0
            py-3
            ">

               

                </div>

                <div class="card-body">

                    <div class="table-responsive">

                        <table
                            class="
                        table
                        table-hover
                        align-middle
                        "
                            id="checklistTable">

                            <thead class="table-primary">

                                <tr>

                                    <th>

                                        School Year

                                    </th>

                                    <th>

                                        Semester

                                    </th>

                                    <th>

                                        Subject Code

                                    </th>

                                    <th>

                                        Subject Name

                                    </th>

                                    <th>

                                        Units

                                    </th>

                                    <th>

                                        Course

                                    </th>

                                    <th>

                                        Faculty

                                    </th>

                                    <th>

                                        Grade

                                    </th>

                                    <th>

                                        Grade Updated

                                    </th>

                                    <th>

                                        Remarks

                                    </th>

                                </tr>

                            </thead>

                            <tbody>

                                <?php

                                if (

                                    $checklist &&

                                    $checklist->num_rows > 0

                                ) {

                                    while (

                                        $row =
                                        $checklist->fetch_assoc()

                                    ) {

                                        $grade =
                                            $row['grade'];

                                        /* =====================================
                                   REMARKS
                                ===================================== */

                                        if (

                                            $grade === NULL ||

                                            $grade === ''

                                        ) {

                                            $remarks =
                                                '<span class="
                                    badge
                                    bg-secondary
                                    ">
                                    No Grade
                                    </span>';
                                        } elseif (

                                            floatval($grade) >= 75

                                        ) {

                                            $remarks =
                                                '<span class="
                                    badge
                                    bg-success
                                    ">
                                    Passed
                                    </span>';
                                        } else {

                                            $remarks =
                                                '<span class="
                                    badge
                                    bg-danger
                                    ">
                                    Failed
                                    </span>';
                                        }

                                ?>

                                        <tr>

                                            <td>

                                                <?php
                                                echo htmlspecialchars(
                                                    $row['school_year']
                                                );
                                                ?>

                                            </td>

                                            <td>

                                                <?php
                                                echo htmlspecialchars(
                                                    $row['semester']
                                                );
                                                ?>

                                            </td>

                                            <td>

                                                <?php
                                                echo htmlspecialchars(
                                                    $row['subject_code']
                                                );
                                                ?>

                                            </td>

                                            <td>

                                                <?php
                                                echo htmlspecialchars(
                                                    $row['subject_name']
                                                );
                                                ?>

                                            </td>

                                            <td>

                                                <?php
                                                echo htmlspecialchars(
                                                    $row['units']
                                                );
                                                ?>

                                            </td>

                                            <td>

                                                <?php
                                                echo htmlspecialchars(
                                                    $row['course_name']
                                                );
                                                ?>

                                            </td>

                                            <td>

                                                <?php
                                                echo htmlspecialchars(
                                                    $row['faculty_name']
                                                );
                                                ?>

                                            </td>

                                            <td>

                                                <?php

                                                echo

                                                $grade !== NULL
                                                    &&
                                                    $grade !== ''

                                                    ?

                                                    htmlspecialchars($grade)

                                                    :

                                                    '-';

                                                ?>

                                            </td>

                                            <td>

                                                <?php

                                                echo

                                                !empty($row['grade_updated'])

                                                    ?

                                                    date(

                                                        "M d, Y h:i A",

                                                        strtotime(
                                                            $row['grade_updated']
                                                        )

                                                    )

                                                    :

                                                    '-';

                                                ?>

                                            </td>

                                            <td>

                                                <?php
                                                echo $remarks;
                                                ?>

                                            </td>

                                        </tr>

                                    <?php

                                    }
                                } else {

                                    ?>

                                    <tr>

                                        <td
                                            colspan="10"
                                            class="
                                    text-center
                                    text-muted
                                    py-5
                                    ">

                                            No enrolled subjects found.

                                        </td>

                                    </tr>

                                <?php

                                }

                                ?>

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <?php include "../globals/student_scripts.php" ?>

    <script>
        $(document).ready(function() {

            $('#checklistTable').DataTable({
                dom: 'fQrBtip',
                responsive: true,
                buttons: [
                    
                    {
                        extend: 'excel',
                        text: 'Excel',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'pdf',
                        text: 'PDF',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'print',
                        text: 'Print',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'colvis',
                        text: 'Show/Hide Columns'
                    }
                ],
                fixedHeader: true,
                paging: true,
                searching: true,
                ordering: true,
                scrollY: '300px',
                colReorder: true,
                scrollCollapse: true,
                language: {
                    search: 'Search:'
                }


            });

        });
    </script>

</body>

</html>