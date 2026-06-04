<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>

        TESDA Courses

    </title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

</head>

<body>

    <div class="container-fluid py-4">

        <h2 class="
        text-primary
        border-bottom
        border-4
        pb-2
        mb-4
        ">

            TESDA Courses

        </h2>

        <div class="row">

            <div class="col-lg-10 mx-auto">

                <button
                    type="button"
                    class="
                    btn
                    btn-primary
                    btn-lg
                    "
                    data-bs-toggle="modal"
                    data-bs-target="#modalId">

                    Create Profile

                </button>

                <!-- MODAL -->

                <div
                    class="modal fade"
                    id="modalId"
                    tabindex="-1">

                    <div class="
                    modal-dialog
                    modal-xl
                    modal-dialog-scrollable
                    ">

                        <div class="modal-content">

                            <div class="modal-header">

                                <h5 class="modal-title">

                                    Create TESDA Student Profile

                                </h5>

                                <button
                                    type="button"
                                    class="btn-close"
                                    data-bs-dismiss="modal">

                                </button>

                            </div>

                            <form
                                id="createProfileForm"
                                method="POST">

                                <div class="modal-body">

                                    <div class="row g-3">

                                        <div class="col-md-4">

                                            <label class="form-label">

                                                Student Number

                                            </label>

                                            <input
                                                type="text"
                                                class="form-control"
                                                name="student_number"
                                                required>

                                        </div>

                                        <div class="col-md-4">

                                            <label class="form-label">

                                                Username

                                            </label>

                                            <input
                                                type="text"
                                                class="form-control"
                                                name="username"
                                                required>

                                        </div>

                                        <div class="col-md-4">

                                            <label class="form-label">

                                                Password

                                            </label>

                                            <input
                                                type="password"
                                                class="form-control"
                                                name="password"
                                                required>

                                        </div>

                                        <div class="col-md-4">

                                            <label class="form-label">

                                                First Name

                                            </label>

                                            <input
                                                type="text"
                                                class="form-control"
                                                name="firstname"
                                                required>

                                        </div>

                                        <div class="col-md-4">

                                            <label class="form-label">

                                                Middle Name

                                            </label>

                                            <input
                                                type="text"
                                                class="form-control"
                                                name="middlename">

                                        </div>

                                        <div class="col-md-4">

                                            <label class="form-label">

                                                Last Name

                                            </label>

                                            <input
                                                type="text"
                                                class="form-control"
                                                name="lastname"
                                                required>

                                        </div>

                                        <div class="col-md-3">

                                            <label class="form-label">

                                                Suffix

                                            </label>

                                            <input
                                                type="text"
                                                class="form-control"
                                                name="suffix">

                                        </div>

                                        <div class="col-md-3">

                                            <label class="form-label">

                                                Gender

                                            </label>

                                            <select
                                                class="form-select"
                                                name="gender">

                                                <option value="">

                                                    Select

                                                </option>

                                                <option value="Male">

                                                    Male

                                                </option>

                                                <option value="Female">

                                                    Female

                                                </option>

                                            </select>

                                        </div>

                                        <div class="col-md-3">

                                            <label class="form-label">

                                                Birthdate

                                            </label>

                                            <input
                                                type="date"
                                                class="form-control"
                                                name="birthdate">

                                        </div>

                                        <div class="col-md-3">

                                            <label class="form-label">

                                                Contact Number

                                            </label>

                                            <input
                                                type="text"
                                                class="form-control"
                                                name="contact_number">

                                        </div>

                                        <div class="col-md-12">

                                            <label class="form-label">

                                                Address

                                            </label>

                                            <textarea
                                                class="form-control"
                                                rows="3"
                                                name="address"></textarea>

                                        </div>

                                        <div class="col-md-6">

                                            <label class="form-label">

                                                Guardian Name

                                            </label>

                                            <input
                                                type="text"
                                                class="form-control"
                                                name="guardian_name">

                                        </div>

                                        <div class="col-md-6">

                                            <label class="form-label">

                                                Guardian Contact

                                            </label>

                                            <input
                                                type="text"
                                                class="form-control"
                                                name="guardian_contact">

                                        </div>

                                        <div class="col-md-6">

                                            <label class="form-label">

                                                Course

                                            </label>

                                            <select
                                                class="form-select"
                                                name="course">

                                                <option>

                                                    Computer Systems Servicing NC II

                                                </option>

                                                <option>

                                                    Electrical Installation and Maintenance NC II

                                                </option>

                                                <option>

                                                    Shielded Metal Arc Welding NC I

                                                </option>

                                                <option>

                                                    Shielded Metal Arc Welding NC II

                                                </option>

                                            </select>

                                        </div>

                                        <div class="col-md-6">

                                            <label class="form-label">

                                                Enrollment Date

                                            </label>

                                            <input
                                                type="date"
                                                class="form-control"
                                                name="enrollment_date">

                                        </div>

                                    </div>

                                </div>

                                <div class="modal-footer">

                                    <button
                                        type="button"
                                        class="btn btn-secondary"
                                        data-bs-dismiss="modal">

                                        Close

                                    </button>

                                    <button
                                        type="submit"
                                        class="btn btn-primary">

                                        Save Profile

                                    </button>

                                </div>

                            </form>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

</body>

</html>