<?php

include "../src/connection.php";

global $mysqli;

session_start();

/* =====================================
   SESSION
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

    $faculty_number =
        trim($_POST['faculty_number']);

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

    $specialization =
        trim($_POST['specialization']);

    $employment_status =
        trim($_POST['employment_status']);

    /* =====================================
       UPDATE QUERY
    ===================================== */

    $stmt =
        $mysqli->prepare("

        UPDATE faculty_profiles

        SET

            faculty_number = ?,
            firstname = ?,
            middlename = ?,
            lastname = ?,
            suffix = ?,
            gender = ?,
            birthdate = ?,
            contact_number = ?,
            address = ?,
            specialization = ?,
            employment_status = ?

        WHERE account_id = ?

    ");

    $stmt->bind_param(

        "sssssssssssi",

        $faculty_number,
        $firstname,
        $middlename,
        $lastname,
        $suffix,
        $gender,
        $birthdate,
        $contact_number,
        $address,
        $specialization,
        $employment_status,
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

    FROM faculty_profiles

    WHERE account_id = '$user_id'

    LIMIT 1

");

$data =
    $profile->fetch_assoc();

?>

<?php include "../globals/faculty_head.php" ?>

<body class="bg-light">

    <?php include "../globals/faculty_sidebar.php" ?>

    <div class="content">

        <div class="container py-5">

            <!-- PAGE HEADER -->

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

                        Faculty Profile

                    </h2>

                    <p class="
                text-muted
                mb-0
                ">

                        Manage and update your faculty information.

                    </p>

                </div>

            </div>

            <!-- SUCCESS MESSAGE -->

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

            <!-- PROFILE CARD -->

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

                        Keep your faculty information updated.

                    </p>

                </div>

                <!-- CARD BODY -->

                <div class="card-body p-5">

                    <form method="POST">

                        <div class="row g-4">

                            <!-- FACULTY NUMBER -->

                            <div class="col-md-12">

                                <label class="
                            form-label
                            fw-semibold
                            ">

                                    Faculty Number

                                </label>

                                <input
                                    type="text"
                                    name="faculty_number"
                                    class="
                                form-control
                                rounded-3
                                "
                                    required

                                    value="<?php
                                            echo htmlspecialchars(
                                                $data['faculty_number']
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
                                    rows="4"
                                    class="
                                form-control
                                rounded-3
                                "><?php

                                    echo htmlspecialchars(
                                        $data['address']
                                    );

                                    ?></textarea>

                            </div>

                            <!-- SPECIALIZATION -->

                            <div class="col-md-6">

                                <label class="
                            form-label
                            fw-semibold
                            ">

                                    Specialization

                                </label>

                                <input
                                    type="text"
                                    name="specialization"
                                    class="
                                form-control
                                rounded-3
                                "

                                    value="<?php
                                            echo htmlspecialchars(
                                                $data['specialization']
                                            );
                                            ?>">

                            </div>

                            <!-- EMPLOYMENT STATUS -->

                            <div class="col-md-6">

                                <label class="
                            form-label
                            fw-semibold
                            ">

                                    Employment Status

                                </label>

                                <select
                                    name="employment_status"
                                    class="
                                form-select
                                rounded-3
                                ">

                                    <option value="Full-Time"

                                        <?php
                                        if (
                                            $data['employment_status']
                                            == 'Full-Time'
                                        ) {
                                            echo "selected";
                                        }
                                        ?>>

                                        Full-Time

                                    </option>

                                    <option value="Part-Time"

                                        <?php
                                        if (
                                            $data['employment_status']
                                            == 'Part-Time'
                                        ) {
                                            echo "selected";
                                        }
                                        ?>>

                                        Part-Time

                                    </option>

                                </select>

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

    <?php include "../globals/faculty_scripts.php" ?>

</body>

</html>