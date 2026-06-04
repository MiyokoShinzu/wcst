<?php

include "../src/connection.php";

global $mysqli;

session_start();

/* =====================================
   SESSION USER
===================================== */

$user_id =
    intval(
        $_SESSION['user_id'] ?? 0
    );

/* =====================================
   FACULTY PROFILE
===================================== */

$faculty_profile_id = 0;

$faculty_name = "Faculty";

$faculty =
    $mysqli->query("

    SELECT *

    FROM faculty_profiles

    WHERE account_id = '$user_id'

    LIMIT 1

");

if (

    $faculty &&

    $faculty->num_rows > 0

) {

    $facultyData =
        $faculty->fetch_assoc();

    $faculty_profile_id =
        intval(
            $facultyData['id']
        );

    $faculty_name =

        $facultyData['firstname']

        . ' ' .

        $facultyData['lastname'];
}

/* =====================================
   SCHOOL YEARS
===================================== */

$schoolYears =
    $mysqli->query("

    SELECT *

    FROM school_years

    ORDER BY id DESC

");

/* =====================================
   FILTER
===================================== */

$school_year_id =
    intval(
        $_GET['school_year_id'] ?? 0
    );

/* =====================================
   ASSIGNED SUBJECTS
===================================== */

$query = "

    SELECT

        academic_assignments.id,

        subjects.subject_code,
        subjects.subject_name,
        subjects.units,

        courses.course_name,

        school_years.school_year,
        school_years.semester

    FROM academic_assignments

    INNER JOIN subjects

        ON subjects.id =
        academic_assignments.subject_id

    INNER JOIN courses

        ON courses.id =
        academic_assignments.course_id

    INNER JOIN school_years

        ON school_years.id =
        academic_assignments.school_year_id

    WHERE

        academic_assignments.faculty_profile_id =
        '$faculty_profile_id'

";

if ($school_year_id > 0) {

    $query .= "

        AND academic_assignments.school_year_id =
        '$school_year_id'

    ";
}

$query .= "

    ORDER BY

        school_years.school_year DESC

";

$assignments =
    $mysqli->query($query);

?>

<?php include "../globals/faculty_head.php" ?>

<body>

    <?php include "../globals/faculty_sidebar.php" ?>

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

                        Faculty Dashboard

                    </h2>

                    <p class="
                text-muted
                mb-0
                ">

                        Welcome,
                        <?php
                        echo
                        htmlspecialchars(
                            $faculty_name
                        );
                        ?>

                    </p>

                </div>

            </div>

            <!-- FILTER -->

            <div class="
        card
        border-0
        shadow-sm
        rounded-4
        mb-4">

                <div class="card-body">

                    <form method="GET">

                        <div class="row">

                            <div class="col-md-4">

                                <label class="
                            form-label
                            fw-bold
                            ">

                                    School Year & Semester

                                </label>

                                <select
                                    name="school_year_id"
                                    class="form-select"
                                    onchange="
                                this.form.submit()
                                ">

                                    <option value="">

                                        Select School Year & Semester

                                    </option>

                                    <?php

                                    if (

                                        $schoolYears &&

                                        $schoolYears->num_rows > 0

                                    ) {

                                        while (

                                            $sy =
                                            $schoolYears->fetch_assoc()

                                        ) {

                                    ?>

                                            <option

                                                value="<?php
                                                        echo
                                                        $sy['id'];
                                                        ?>"

                                                <?php

                                                if (

                                                    $school_year_id ==

                                                    $sy['id']

                                                ) {

                                                    echo "selected";
                                                }

                                                ?>>

                                                <?php

                                                echo

                                                $sy['school_year']

                                                    . ' - ' .

                                                    $sy['semester'];

                                                ?>

                                            </option>

                                    <?php

                                        }
                                    }

                                    ?>

                                </select>

                            </div>

                        </div>

                    </form>

                </div>

            </div>

            <!-- ASSIGNED SUBJECTS -->

            <div class="
        card
        border-0
        shadow-sm
        rounded-4">

                <div class="
            card-header
            bg-white
            border-0
            py-3">

                    <h4 class="
                fw-bold
                text-primary
                mb-0
                ">

                        Assigned Subjects

                    </h4>

                </div>

                <div class="card-body">

                    <div class="table-responsive">

                        <table
                            class="
                        table
                        table-hover
                        align-middle
                        "
                            id="assignmentsTable">

                            <thead class="table-primary">

                                <tr>

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

                                        School Year

                                    </th>

                                    <th>

                                        Semester

                                    </th>

                                    <th>

                                        Actions

                                    </th>

                                </tr>

                            </thead>

                            <tbody>

                                <?php

                                if (

                                    $assignments &&

                                    $assignments->num_rows > 0

                                ) {

                                    while (

                                        $row =
                                        $assignments->fetch_assoc()

                                    ) {

                                ?>

                                        <tr>

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

                                                <div class="
                                    d-flex
                                    gap-2
                                    flex-wrap
                                    ">

                                                    <!-- STUDENTS -->

                                                    <button
                                                        class="
                                            btn
                                            btn-primary
                                            btn-sm
                                            rounded-pill
                                            px-3
                                            assignStudentsBtn
                                            "

                                                        data-assignment-id="<?php
                                                                            echo
                                                                            $row['id'];
                                                                            ?>"

                                                        data-subject="<?php
                                                                        echo htmlspecialchars(
                                                                            $row['subject_name']
                                                                        );
                                                                        ?>"

                                                        data-course="<?php
                                                                        echo htmlspecialchars(
                                                                            $row['course_name']
                                                                        );
                                                                        ?>">

                                                        <i class="
                                            bi
                                            bi-people-fill
                                            me-1
                                            "></i>

                                                        Students

                                                    </button>

                                                    <!-- GRADES -->

                                                    <button
                                                        class="
                                            btn
                                            btn-success
                                            btn-sm
                                            rounded-pill
                                            px-3
                                            gradeStudentsBtn
                                            "

                                                        data-assignment-id="<?php
                                                                            echo
                                                                            $row['id'];
                                                                            ?>"

                                                        data-subject="<?php
                                                                        echo htmlspecialchars(
                                                                            $row['subject_name']
                                                                        );
                                                                        ?>"

                                                        data-course="<?php
                                                                        echo htmlspecialchars(
                                                                            $row['course_name']
                                                                        );
                                                                        ?>">

                                                        <i class="
                                            bi
                                            bi-journal-check
                                            me-1
                                            "></i>

                                                        Grades

                                                    </button>

                                                </div>

                                            </td>

                                        </tr>

                                <?php

                                    }
                                }

                                ?>

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- ASSIGN STUDENTS MODAL -->

    <div
        class="
    modal
    fade
    "
        id="assignStudentsModal"
        tabindex="-1">

        <div class="
    modal-dialog
    modal-xl
    modal-dialog-scrollable
    ">

            <div class="
        modal-content
        border-0
        rounded-4
        ">

                <div class="
            modal-header
            bg-primary
            text-white
            ">

                    <h5 class="
                modal-title
                fw-bold
                ">

                        Assign Students

                    </h5>

                    <button
                        type="button"
                        class="btn-close btn-close-white"
                        data-bs-dismiss="modal">

                    </button>

                </div>

                <div class="modal-body">

                    <h6
                        class="
                    fw-bold
                    mb-4
                    "
                        id="assignmentInfo">

                    </h6>

                    <div class="mb-3">

                        <input
                            type="text"
                            class="form-control"
                            id="studentSearchInput"
                            placeholder="Search student...">

                    </div>

                    <div class="table-responsive">

                        <table class="
                    table
                    table-hover
                    table-bordered
                    align-middle
                    ">

                            <thead class="table-primary">

                                <tr>

                                    <th width="50">

                                        Select

                                    </th>

                                    <th>

                                        Student Number

                                    </th>

                                    <th>

                                        Full Name

                                    </th>

                                    <th>

                                        Year

                                    </th>

                                    <th>

                                        Section

                                    </th>

                                </tr>

                            </thead>

                            <tbody id="studentsTableBody">

                            </tbody>

                        </table>

                    </div>

                </div>

                <div class="
            modal-footer
            border-0
            ">

                    <button
                        type="button"
                        class="
                    btn
                    btn-secondary
                    rounded-pill
                    px-4
                    "
                        data-bs-dismiss="modal">

                        Close

                    </button>

                    <button
                        type="button"
                        class="
                    btn
                    btn-primary
                    rounded-pill
                    px-4
                    "
                        id="saveStudentsBtn">

                        Save Students

                    </button>

                </div>

            </div>

        </div>

    </div>



    <!-- GRADE STUDENTS MODAL -->

    <div
        class="
    modal
    fade
    "
        id="gradeStudentsModal"
        tabindex="-1">

        <div class="
    modal-dialog
    modal-xl
    modal-dialog-scrollable
    ">

            <div class="
        modal-content
        border-0
        rounded-4
        ">

                <!-- HEADER -->

                <div class="
            modal-header
            bg-success
            text-white
            ">

                    <h5 class="
                modal-title
                fw-bold
                ">

                        Grade Students

                    </h5>

                    <button
                        type="button"
                        class="btn-close btn-close-white"
                        data-bs-dismiss="modal">

                    </button>

                </div>

                <!-- BODY -->

                <div class="modal-body">

                    <h6
                        class="
                    fw-bold
                    mb-4
                    "
                        id="gradeAssignmentInfo">

                    </h6>

                    <!-- SEARCH -->

                    <div class="mb-3">

                        <input
                            type="text"
                            class="form-control"
                            id="gradeSearchInput"
                            placeholder="Search student...">

                    </div>

                    <!-- TABLE -->

                    <div class="table-responsive">

                        <table class="
                    table
                    table-hover
                    table-bordered
                    align-middle
                    ">

                            <thead class="table-success">

                                <tr>

                                    <th>

                                        Student Number

                                    </th>

                                    <th>

                                        Full Name

                                    </th>

                                    <th>

                                        Year

                                    </th>

                                    <th>

                                        Section

                                    </th>

                                    <th width="150">

                                        Prelim

                                    </th>
                                    <th width="150">

                                        Midterms

                                    </th>
                                    <th width="150">

                                        Prefinal

                                    </th>
                                    <th width="150">

                                        Final

                                    </th>
                                    <th width="150">

                                        Average

                                    </th>

                                </tr>

                            </thead>

                            <tbody id="gradesTableBody">

                            </tbody>

                        </table>

                    </div>

                </div>

                <!-- FOOTER -->

                <div class="
            modal-footer
            border-0
            ">

                    <button
                        type="button"
                        class="
                    btn
                    btn-secondary
                    rounded-pill
                    px-4
                    "
                        data-bs-dismiss="modal">

                        Close

                    </button>

                    <button
                        type="button"
                        class="
                    btn
                    btn-success
                    rounded-pill
                    px-4
                    "
                        id="saveGradesBtn">

                        Save Grades

                    </button>

                </div>

            </div>

        </div>

    </div>

    <?php include "../globals/faculty_scripts.php" ?>

    <script>
        let currentAssignmentId = 0;

        $(document).ready(function() {

            $('#assignmentsTable').DataTable({

                responsive: true,

                pageLength: 10,

                autoWidth: false,

                ordering: true,

                searching: true,

                lengthChange: true,

                order: []

            });

        });

        /* =====================================
           OPEN MODAL
        ===================================== */

        $(document).on(

            'click',

            '.assignStudentsBtn',

            function() {

                currentAssignmentId =

                    $(this).data(
                        'assignment-id'
                    );

                let subject =

                    $(this).data(
                        'subject'
                    );

                let course =

                    $(this).data(
                        'course'
                    );

                $('#assignmentInfo').html(

                    '<strong>Subject:</strong> '

                    +
                    subject +

                    '<br><br>'

                    +

                    '<strong>Course:</strong> '

                    +
                    course

                );

                loadStudents();

                $('#assignStudentsModal').modal(
                    'show'
                );

            }

        );

        /* =====================================
           LOAD STUDENTS
        ===================================== */

        function loadStudents() {

            $.ajax({

                url: '../api/faculty_select_students.php',

                type: 'GET',

                data: {

                    academic_assignment_id: currentAssignmentId

                },

                dataType: 'json',

                success: function(response) {

                    let html = '';

                    response.data.forEach(student => {

                        html += `

                <tr>

                    <td class="text-center">

                        <input
                            type="checkbox"
                            class="
                            form-check-input
                            studentCheckbox
                            "

                            value="${student.student_profile_id}"

                            ${student.assigned == 1
                            ? 'checked'
                            : ''}

                        >

                    </td>

                    <td>

                        ${student.student_number}

                    </td>

                    <td>

                        ${student.full_name}

                    </td>

                    <td>

                        ${student.year_level}

                    </td>

                    <td>

                        ${student.section}

                    </td>

                </tr>

                `;

                    });

                    $('#studentsTableBody').html(
                        html
                    );

                }

            });

        }

        /* =====================================
           SEARCH STUDENTS
        ===================================== */

        $('#studentSearchInput').on(

            'keyup',

            function() {

                let value =

                    $(this)
                    .val()
                    .toLowerCase();

                $('#studentsTableBody tr').filter(function() {

                    $(this).toggle(

                        $(this)
                        .text()
                        .toLowerCase()
                        .indexOf(value) > -1

                    );

                });

            }

        );

        /* =====================================
           SAVE STUDENTS
        ===================================== */

        $('#saveStudentsBtn').on(

            'click',

            function() {

                let students = [];

                $('.studentCheckbox:checked').each(function() {

                    students.push(
                        $(this).val()
                    );

                });

                $.ajax({

                    url: '../api/faculty_insert_enrolled_subjects.php',

                    type: 'POST',

                    data: {

                        academic_assignment_id: currentAssignmentId,

                        students: students

                    },

                    dataType: 'json',

                    success: function(response) {

                        if (response.success == 1) {

                            alert(
                                'Students assigned successfully.'
                            );

                            loadStudents();

                        } else {

                            alert(
                                response.message
                            );

                        }

                    }

                });

            }

        );





        let currentGradeAssignmentId = 0;

        /* =====================================
           OPEN GRADE MODAL
        ===================================== */

        $(document).on(

            'click',

            '.gradeStudentsBtn',

            function() {

                currentGradeAssignmentId =

                    $(this).data(
                        'assignment-id'
                    );

                let subject =

                    $(this).data(
                        'subject'
                    );

                let course =

                    $(this).data(
                        'course'
                    );

                $('#gradeAssignmentInfo').html(

                    '<strong>Subject:</strong> '

                    +
                    subject +

                    '<br><br>'

                    +

                    '<strong>Course:</strong> '

                    +
                    course

                );

                loadGrades();

                $('#gradeStudentsModal').modal(
                    'show'
                );

            }

        );

        /* =====================================
           LOAD GRADES
        ===================================== */

        function loadGrades() {

            $.ajax({

                url: '../api/faculty_select_grades.php',

                type: 'GET',

                data: {

                    academic_assignment_id: currentGradeAssignmentId

                },

                dataType: 'json',

                success: function(response) {

                    let html = '';

                    response.data.forEach(student => {

                        html += `

<tr>

    <td>${student.student_number}</td>

    <td>${student.full_name}</td>

    <td>${student.year_level}</td>

    <td>${student.section}</td>

    <td>

        <input
            type="number"
            class="form-control prelimGrade"
            min="0"
            max="100"
            step="0.01"
            value="${student.prelim ?? ''}"
        >

    </td>

    <td>

        <input
            type="number"
            class="form-control midtermGrade"
            min="0"
            max="100"
            step="0.01"
            value="${student.midterm ?? ''}"
        >

    </td>

    <td>

        <input
            type="number"
            class="form-control prefinalGrade"
            min="0"
            max="100"
            step="0.01"
            value="${student.prefinal ?? ''}"
        >

    </td>

    <td>

        <input
            type="number"
            class="form-control finalGrade"
            min="0"
            max="100"
            step="0.01"
            value="${student.final ?? ''}"
        >

    </td>

    <td>

        ${student.average ?? ''}

    </td>

    <input
        type="hidden"
        class="enrollmentId"
        value="${student.enrollment_id}"
    >

</tr>

`;;

                    });

                    $('#gradesTableBody').html(
                        html
                    );

                }

            });

        }

        /* =====================================
           SEARCH STUDENTS
        ===================================== */

        $('#gradeSearchInput').on(

            'keyup',

            function() {

                let value =

                    $(this)
                    .val()
                    .toLowerCase();

                $('#gradesTableBody tr').filter(function() {

                    $(this).toggle(

                        $(this)
                        .text()
                        .toLowerCase()
                        .indexOf(value) > -1

                    );

                });

            }

        );

        /* =====================================
           SAVE GRADES
        ===================================== */

        $('#saveGradesBtn').on(
            'click',
            function() {

                let grades = [];

                $('#gradesTableBody tr').each(function() {

                    grades.push({

                        enrollment_id:

                            $(this)
                            .find('.enrollmentId')
                            .val(),

                        prelim:

                            $(this)
                            .find('.prelimGrade')
                            .val(),

                        midterm:

                            $(this)
                            .find('.midtermGrade')
                            .val(),

                        prefinal:

                            $(this)
                            .find('.prefinalGrade')
                            .val(),

                        final:

                            $(this)
                            .find('.finalGrade')
                            .val()

                    });

                });
                
                $.ajax({

                    url: '../api/faculty_save_grades.php',

                    type: 'POST',

                    data: {

                        grades: JSON.stringify(grades)

                    },

                    dataType: 'json',

                    success: function(response) {


                        if (
                            response.success == 1
                        ) {

                            alert(
                                'Grades saved successfully.'
                            );

                            loadGrades();

                        } else {

                            alert(
                                response.message
                            );

                        }

                    }

                });

            }
        );
    </script>

</body>

</html>