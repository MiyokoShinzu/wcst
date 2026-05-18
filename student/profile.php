<?php

include "../src/connection.php";

global $mysqli;

/* =====================================
   SAFE SESSION
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
   UPDATE PROFILE
===================================== */

if (

    isset($_POST['update_profile'])

) {

    $student_number =
        trim($_POST['student_number']);

    $firstname =
        trim($_POST['firstname']);

    $middlename =
        trim($_POST['middlename']);

    $lastname =
        trim($_POST['lastname']);

    $suffix =
        trim($_POST['suffix']);

    $gender =
        trim($_POST['gender']);

    $birthdate =
        trim($_POST['birthdate']);

    $contact_number =
        trim($_POST['contact_number']);

    $address =
        trim($_POST['address']);

    $guardian_name =
        trim($_POST['guardian_name']);

    $guardian_contact =
        trim($_POST['guardian_contact']);

    $year_level =
        trim($_POST['year_level']);

    $section =
        trim($_POST['section']);

    $school_year =
        trim($_POST['school_year']);

    $stmt =
        $mysqli->prepare("

        UPDATE student_profiles

        SET

            student_number = ?,
            firstname = ?,
            middlename = ?,
            lastname = ?,
            suffix = ?,
            gender = ?,
            birthdate = ?,
            contact_number = ?,
            address = ?,
            guardian_name = ?,
            guardian_contact = ?,
            year_level = ?,
            section = ?,
            school_year = ?

        WHERE account_id = ?

    ");

    $stmt->bind_param(

        "ssssssssssssssi",

        $student_number,
        $firstname,
        $middlename,
        $lastname,
        $suffix,
        $gender,
        $birthdate,
        $contact_number,
        $address,
        $guardian_name,
        $guardian_contact,
        $year_level,
        $section,
        $school_year,
        $user_id

    );

    $stmt->execute();

    $success =
        "Profile updated successfully.";
}

/* =====================================
   SELECT PROFILE
===================================== */

$profile =
    $mysqli->query("

    SELECT *

    FROM student_profiles

    WHERE account_id = '$user_id'

    LIMIT 1

");

$data =
    $profile->fetch_assoc();

?>

<?php include "../globals/student_head.php" ?>

<body class="bg-light">

    <?php include "../globals/student_sidebar.php" ?>

    <div class="content">

        <div class="container py-5">

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

                        Student Profile

                    </h2>

                    <p class="
                text-muted
                mb-0
                ">

                        Manage and update your student information.

                    </p>

                </div>

            </div>

            <!-- SUCCESS -->

            <?php if (isset($success)) { ?>

                <div class="
            alert
            alert-success
            border-0
            shadow-sm
            rounded-4
            ">

                    <?php
                    echo $success;
                    ?>

                </div>

            <?php } ?>

            <!-- CARD -->

            <div class="
        card
        border-0
        shadow-lg
        rounded-4
        overflow-hidden
        ">

                <!-- CARD HEADER -->

                <div class="
            bg-primary
            text-white
            p-4
            ">

                    <h4 class="
                fw-bold
                mb-1
                ">

                        Profile Information

                    </h4>

                    <p class="
                mb-0
                opacity-75
                ">

                        Keep your information updated.

                    </p>

                </div>

                <!-- BODY -->

                <div class="card-body p-5">

                    <form method="POST">

                        <div class="row g-4">

                            <!-- STUDENT NUMBER -->

                            <div class="col-md-6">

                                <label class="
                            form-label
                            fw-semibold
                            ">

                                    Student Number

                                </label>

                                <input
                                    type="text"
                                    name="student_number"
                                    class="
                                form-control
                                rounded-3
                                "
                                    required

                                    value="<?php
                                            echo htmlspecialchars(
                                                $data['student_number']
                                            );
                                            ?>">

                            </div>

                            <!-- SCHOOL YEAR -->

                            <div class="col-md-6">

                                <label class="
                            form-label
                            fw-semibold
                            ">

                                    School Year

                                </label>

                                <input
                                    type="text"
                                    name="school_year"
                                    class="
                                form-control
                                rounded-3
                                "

                                    value="<?php
                                            echo htmlspecialchars(
                                                $data['school_year']
                                            );
                                            ?>">

                            </div>

                            <!-- FIRST NAME -->

                            <div class="col-md-4">

                                <label class="
                            form-label
                            fw-semibold
                            ">

                                    First Name

                                </label>

                                <input
                                    type="text"
                                    name="firstname"
                                    class="
                                form-control
                                rounded-3
                                "
                                    required

                                    value="<?php
                                            echo htmlspecialchars(
                                                $data['firstname']
                                            );
                                            ?>">

                            </div>

                            <!-- MIDDLE NAME -->

                            <div class="col-md-4">

                                <label class="
                            form-label
                            fw-semibold
                            ">

                                    Middle Name

                                </label>

                                <input
                                    type="text"
                                    name="middlename"
                                    class="
                                form-control
                                rounded-3
                                "

                                    value="<?php
                                            echo htmlspecialchars(
                                                $data['middlename']
                                            );
                                            ?>">

                            </div>

                            <!-- LAST NAME -->

                            <div class="col-md-4">

                                <label class="
                            form-label
                            fw-semibold
                            ">

                                    Last Name

                                </label>

                                <input
                                    type="text"
                                    name="lastname"
                                    class="
                                form-control
                                rounded-3
                                "
                                    required

                                    value="<?php
                                            echo htmlspecialchars(
                                                $data['lastname']
                                            );
                                            ?>">

                            </div>

                            <!-- SUFFIX -->

                            <div class="col-md-3">

                                <label class="
                            form-label
                            fw-semibold
                            ">

                                    Suffix

                                </label>

                                <input
                                    type="text"
                                    name="suffix"
                                    class="
                                form-control
                                rounded-3
                                "

                                    value="<?php
                                            echo htmlspecialchars(
                                                $data['suffix']
                                            );
                                            ?>">

                            </div>

                            <!-- GENDER -->

                            <div class="col-md-3">

                                <label class="
                            form-label
                            fw-semibold
                            ">

                                    Gender

                                </label>

                                <select
                                    name="gender"
                                    class="
                                form-select
                                rounded-3
                                ">

                                    <option value="Male"

                                        <?php
                                        if (
                                            $data['gender']
                                            == 'Male'
                                        ) {
                                            echo "selected";
                                        }
                                        ?>>

                                        Male

                                    </option>

                                    <option value="Female"

                                        <?php
                                        if (
                                            $data['gender']
                                            == 'Female'
                                        ) {
                                            echo "selected";
                                        }
                                        ?>>

                                        Female

                                    </option>

                                </select>

                            </div>

                            <!-- BIRTHDATE -->

                            <div class="col-md-3">

                                <label class="
                            form-label
                            fw-semibold
                            ">

                                    Birthdate

                                </label>

                                <input
                                    type="date"
                                    name="birthdate"
                                    class="
                                form-control
                                rounded-3
                                "

                                    value="<?php
                                            echo htmlspecialchars(
                                                $data['birthdate']
                                            );
                                            ?>">

                            </div>

                            <!-- CONTACT -->

                            <div class="col-md-3">

                                <label class="
                            form-label
                            fw-semibold
                            ">

                                    Contact Number

                                </label>

                                <input
                                    type="text"
                                    name="contact_number"
                                    class="
                                form-control
                                rounded-3
                                "

                                    value="<?php
                                            echo htmlspecialchars(
                                                $data['contact_number']
                                            );
                                            ?>">

                            </div>

                            <!-- ADDRESS -->

                            <div class="col-md-12">

                                <label class="
                            form-label
                            fw-semibold
                            ">

                                    Address

                                </label>

                                <textarea
                                    name="address"
                                    rows="3"
                                    class="
                                form-control
                                rounded-3
                                "><?php

                                    echo htmlspecialchars(
                                        $data['address']
                                    );

                                    ?></textarea>

                            </div>

                            <!-- GUARDIAN -->

                            <div class="col-md-6">

                                <label class="
                            form-label
                            fw-semibold
                            ">

                                    Guardian Name

                                </label>

                                <input
                                    type="text"
                                    name="guardian_name"
                                    class="
                                form-control
                                rounded-3
                                "

                                    value="<?php
                                            echo htmlspecialchars(
                                                $data['guardian_name']
                                            );
                                            ?>">

                            </div>

                            <!-- GUARDIAN CONTACT -->

                            <div class="col-md-6">

                                <label class="
                            form-label
                            fw-semibold
                            ">

                                    Guardian Contact

                                </label>

                                <input
                                    type="text"
                                    name="guardian_contact"
                                    class="
                                form-control
                                rounded-3
                                "

                                    value="<?php
                                            echo htmlspecialchars(
                                                $data['guardian_contact']
                                            );
                                            ?>">

                            </div>

                            <!-- YEAR LEVEL -->

                            <!-- YEAR LEVEL -->

                            <div class="col-md-6">

                                <label class="
    form-label
    fw-semibold
    ">

                                    Year Level

                                </label>

                                <select
                                    name="year_level"
                                    class="
        form-select
        rounded-3
        ">

                                    <option value="">

                                        Select Year Level

                                    </option>

                                    <!-- JUNIOR HIGH -->

                                    <option value="Grade 7"

                                        <?php
                                        if (
                                            $data['year_level']
                                            == 'Grade 7'
                                        ) {
                                            echo "selected";
                                        }
                                        ?>>

                                        Grade 7

                                    </option>

                                    <option value="Grade 8"

                                        <?php
                                        if (
                                            $data['year_level']
                                            == 'Grade 8'
                                        ) {
                                            echo "selected";
                                        }
                                        ?>>

                                        Grade 8

                                    </option>

                                    <option value="Grade 9"

                                        <?php
                                        if (
                                            $data['year_level']
                                            == 'Grade 9'
                                        ) {
                                            echo "selected";
                                        }
                                        ?>>

                                        Grade 9

                                    </option>

                                    <option value="Grade 10"

                                        <?php
                                        if (
                                            $data['year_level']
                                            == 'Grade 10'
                                        ) {
                                            echo "selected";
                                        }
                                        ?>>

                                        Grade 10

                                    </option>

                                    <!-- SENIOR HIGH -->

                                    <option value="Grade 11"

                                        <?php
                                        if (
                                            $data['year_level']
                                            == 'Grade 11'
                                        ) {
                                            echo "selected";
                                        }
                                        ?>>

                                        Grade 11

                                    </option>

                                    <option value="Grade 12"

                                        <?php
                                        if (
                                            $data['year_level']
                                            == 'Grade 12'
                                        ) {
                                            echo "selected";
                                        }
                                        ?>>

                                        Grade 12

                                    </option>

                                    <!-- COLLEGE -->

                                    <option value="1st Year"

                                        <?php
                                        if (
                                            $data['year_level']
                                            == '1st Year'
                                        ) {
                                            echo "selected";
                                        }
                                        ?>>

                                        1st Year

                                    </option>

                                    <option value="2nd Year"

                                        <?php
                                        if (
                                            $data['year_level']
                                            == '2nd Year'
                                        ) {
                                            echo "selected";
                                        }
                                        ?>>

                                        2nd Year

                                    </option>

                                    <option value="3rd Year"

                                        <?php
                                        if (
                                            $data['year_level']
                                            == '3rd Year'
                                        ) {
                                            echo "selected";
                                        }
                                        ?>>

                                        3rd Year

                                    </option>

                                    <option value="4th Year"

                                        <?php
                                        if (
                                            $data['year_level']
                                            == '4th Year'
                                        ) {
                                            echo "selected";
                                        }
                                        ?>>

                                        4th Year

                                    </option>

                                </select>

                            </div>
                            <!-- SECTION -->

                            <div class="col-md-6">

                                <label class="
                            form-label
                            fw-semibold
                            ">

                                    Section

                                </label>

                                <input
                                    type="text"
                                    name="section"
                                    class="
                                form-control
                                rounded-3
                                "

                                    value="<?php
                                            echo htmlspecialchars(
                                                $data['section']
                                            );
                                            ?>">

                            </div>

                            <!-- BUTTON -->

                            <div class="col-12 mt-4">

                                <button
                                    type="submit"
                                    name="update_profile"
                                    class="
                                btn
                                btn-primary
                                btn-lg
                                rounded-pill
                                px-5
                                shadow-sm
                                ">

                                    Update Profile

                                </button>

                            </div>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

    <?php include "../globals/student_scripts.php" ?>

</body>

</html>