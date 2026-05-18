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

                    <h3 class="fw-bold text-primary">

                        Academic Assignments

                    </h3>

                    <p class="text-muted mb-0">

                        Assign faculty to course subjects.

                    </p>

                </div>

            </div>

            <!-- CARD -->
            <div class="
        card
        border-0
        shadow-sm
        rounded-4">

                <div class="card-body">

                    <div class="row">

                        <!-- FACULTY -->
                        <div class="col-md-4 mb-3">

                            <label class="form-label fw-bold">

                                Faculty

                            </label>

                            <select
                                class="form-select"
                                id="faculty_profile_id">

                                <option value="">

                                    Select Faculty

                                </option>

                            </select>

                        </div>

                        <!-- COURSE -->
                        <div class="col-md-4 mb-3">

                            <label class="form-label fw-bold">

                                Course

                            </label>

                            <select
                                class="form-select"
                                id="course_id">

                                <option value="">

                                    Select Course

                                </option>

                            </select>

                        </div>

                        <!-- SCHOOL YEAR -->
                        <div class="col-md-4 mb-3">

                            <label class="form-label fw-bold">

                                School Year

                            </label>

                            <select
                                class="form-select"
                                id="school_year_id">

                                <option value="">

                                    Select School Year

                                </option>

                            </select>

                        </div>

                    </div>

                    <!-- TABLE -->
                    <div class="table-responsive">

                        <table
                            class="
                        table
                        table-hover
                        align-middle
                        "
                            id="subjectsTable">

                            <thead class="table-primary">

                                <tr>

                                    <th width="50">

                                        Select

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

                                        Semester

                                    </th>

                                </tr>

                            </thead>

                            <tbody id="subjectsTableBody">

                            </tbody>

                        </table>

                    </div>

                    <!-- BUTTON -->
                    <div class="mt-4">

                        <button
                            onclick="saveAssignments()"
                            class="
                        btn
                        btn-primary
                        rounded-pill
                        px-4
                        ">

                            Save Assignments

                        </button>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- TOAST -->
    <div
        id="toastContainer"
        class="
    position-fixed
    bottom-0
    start-0
    p-3
    "
        style="z-index:9999;">
    </div>

    <?php include "../globals/admin_scripts.php" ?>

    <script>
        /* =====================================
       TOAST
    ====================================== */

        function showToast(
            message,
            type = 'success'
        ) {

            const toastContainer =
                document.getElementById(
                    'toastContainer'
                );

            const toast =
                document.createElement('div');

            toast.className =
                `
        toast
        align-items-center
        text-bg-${type}
        border-0
        show
        mb-2
        `;

            toast.innerHTML = `

        <div class="d-flex">

            <div class="toast-body">

                ${message}

            </div>

            <button
                type="button"
                class="
                btn-close
                btn-close-white
                me-2
                m-auto
                "
                onclick="
                this.parentElement.parentElement.remove()
                ">
            </button>

        </div>

        `;

            toastContainer.appendChild(toast);

            setTimeout(() => {

                toast.remove();

            }, 3000);
        }

        /* =====================================
           LOAD FACULTY
        ====================================== */

        async function loadFaculty() {

            const response =
                await fetch(
                    '../api/admin_select_faculty_profiles.php'
                );

            const data =
                await response.json();

            const select =
                document.getElementById(
                    'faculty_profile_id'
                );

            select.innerHTML = `

        <option value="">

            Select Faculty

        </option>

        `;

            data.data.forEach(faculty => {

                select.innerHTML += `

            <option value="${faculty.id}">

                ${faculty.full_name}

            </option>

            `;
            });

        }

        loadFaculty();

        /* =====================================
           LOAD COURSES
        ====================================== */

        async function loadCourses() {

            const response =
                await fetch(
                    '../api/admin_select_courses.php'
                );

            const data =
                await response.json();

            const select =
                document.getElementById(
                    'course_id'
                );

            select.innerHTML = `

        <option value="">

            Select Course

        </option>

        `;

            data.data.forEach(course => {

                select.innerHTML += `

            <option value="${course.id}">

                ${course.course_name}

            </option>

            `;
            });

        }

        loadCourses();

        /* =====================================
           LOAD SCHOOL YEARS
        ====================================== */

        async function loadSchoolYears() {

            const response =
                await fetch(
                    '../api/admin_select_school_years.php'
                );

            const data =
                await response.json();

            const select =
                document.getElementById(
                    'school_year_id'
                );

            select.innerHTML = `

        <option value="">

            Select School Year

        </option>

        `;

            data.data.forEach(sy => {

                select.innerHTML += `

            <option value="${sy.id}">

                ${sy.school_year}
                -
                ${sy.semester}

            </option>

            `;
            });

        }

        loadSchoolYears();

        /* =====================================
           LOAD SUBJECTS
        ====================================== */

        async function loadSubjects() {

            const faculty_profile_id =
                document.getElementById(
                    'faculty_profile_id'
                ).value;

            const course_id =
                document.getElementById(
                    'course_id'
                ).value;

            const school_year_id =
                document.getElementById(
                    'school_year_id'
                ).value;

            const tbody =
                document.getElementById(
                    'subjectsTableBody'
                );

            tbody.innerHTML = '';

            /* ================================
               DESTROY DATATABLE
            ================================= */

            if (
                $.fn.DataTable.isDataTable(
                    '#subjectsTable'
                )
            ) {

                $('#subjectsTable')
                    .DataTable()
                    .clear()
                    .destroy();
            }

            if (
                course_id == ''
            ) {

                return;
            }

            /* ================================
               GET COURSE SUBJECTS
            ================================= */

            const response =
                await fetch(
                    `../api/admin_select_course_subjects_full.php?course_id=${course_id}`
                );

            const data =
                await response.json();

            /* ================================
               GET ASSIGNED SUBJECTS
            ================================= */

            let assignedSubjects = [];

            if (

                faculty_profile_id != '' &&

                school_year_id != ''

            ) {

                const assignedResponse =
                    await fetch(

                        `../api/admin_select_academic_assignments.php?faculty_profile_id=${faculty_profile_id}&school_year_id=${school_year_id}&course_id=${course_id}`

                    );

                const assignedData =
                    await assignedResponse.json();

                assignedSubjects =
                    assignedData.data.map(

                        item =>
                        parseInt(
                            item.course_subject_id
                        )

                    );
            }

            /* ================================
               SORT CHECKED FIRST
            ================================= */

            data.data.sort((a, b) => {

                const aChecked =
                    assignedSubjects.includes(
                        parseInt(a.course_subject_id)
                    );

                const bChecked =
                    assignedSubjects.includes(
                        parseInt(b.course_subject_id)
                    );

                return bChecked - aChecked;
            });

            /* ================================
               LOAD ROWS
            ================================= */

            data.data.forEach(subject => {

                const isChecked =
                    assignedSubjects.includes(
                        parseInt(subject.course_subject_id)
                    );

                tbody.innerHTML += `

            <tr>

                <td>

                    <input
                        type="checkbox"
                        class="
                        form-check-input
                        subject_checkbox
                        "
                        value="${subject.course_subject_id}"

                        ${
                            isChecked
                            ?
                            'checked'
                            :
                            ''
                        }
                    >

                </td>

                <td>

                    ${subject.subject_code}

                </td>

                <td>

                    ${subject.subject_name}

                </td>

                <td>

                    ${subject.units}

                </td>

                <td>

                    ${subject.semester}

                </td>

            </tr>

            `;
            });

            /* ================================
               RELOAD DATATABLE
            ================================= */

            $('#subjectsTable').DataTable({

                pageLength: 25,

                responsive: true,

                destroy: true,

                order: []

            });

        }

        /* =====================================
           SAVE ASSIGNMENTS
        ====================================== */

        async function saveAssignments() {

            const faculty_profile_id =
                document.getElementById(
                    'faculty_profile_id'
                ).value;

            const school_year_id =
                document.getElementById(
                    'school_year_id'
                ).value;

            if (

                faculty_profile_id == '' ||

                school_year_id == ''

            ) {

                showToast(
                    'Select faculty and school year.',
                    'danger'
                );

                return;
            }

            const checkboxes =
                document.querySelectorAll(
                    '.subject_checkbox'
                );

            for (
                const checkbox of checkboxes
            ) {

                const formData =
                    new FormData();

                formData.append(
                    'faculty_profile_id',
                    faculty_profile_id
                );

                formData.append(
                    'course_subject_id',
                    checkbox.value
                );

                formData.append(
                    'school_year_id',
                    school_year_id
                );

                /* ================================
                   INSERT CHECKED
                ================================= */

                if (
                    checkbox.checked
                ) {

                    await fetch(
                        '../api/admin_insert_academic_assignment.php', {

                            method: 'POST',

                            body: formData
                        }
                    );

                } else {

                    /* ============================
                       DELETE UNCHECKED
                    ============================ */

                    await fetch(
                        '../api/admin_delete_academic_assignment.php', {

                            method: 'POST',

                            body: formData
                        }
                    );
                }
            }

            showToast(
                'Assignments updated successfully.',
                'success'
            );

            /* =================================
               RELOAD TABLE
            ================================= */

            await loadSubjects();
        }

        /* =====================================
           CHANGE EVENTS
        ====================================== */

        document.getElementById(
            'faculty_profile_id'
        ).addEventListener(
            'change',
            loadSubjects
        );

        document.getElementById(
            'course_id'
        ).addEventListener(
            'change',
            loadSubjects
        );

        document.getElementById(
            'school_year_id'
        ).addEventListener(
            'change',
            loadSubjects
        );
    </script>

</body>

</html>