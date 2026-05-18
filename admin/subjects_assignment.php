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

                        Assign Subjects to Course

                    </h3>

                    <p class="text-muted mb-0">

                        Manage course subject assignments.

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

                    <!-- COURSE -->
                    <div class="row mb-4">

                        <div class="col-md-12">

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

                    </div>

                  

                    <!-- SUBJECTS -->
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
           LOAD SUBJECTS
        ====================================== */

        async function loadSubjects() {

            const course_id =
                document.getElementById(
                    'course_id'
                ).value;

            const tbody =
                document.getElementById(
                    'subjectsTableBody'
                );

            /* ================================
               CLEAR TABLE
            ================================= */

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
               GET ALL SUBJECTS
            ================================= */

            const subjectsResponse =
                await fetch(
                    '../api/admin_select_subjects.php'
                );

            const subjectsData =
                await subjectsResponse.json();

            /* ================================
               GET ASSIGNED SUBJECTS
            ================================= */

            const assignedResponse =
                await fetch(
                    `../api/admin_select_course_subjects.php?course_id=${course_id}`
                );

            const assignedData =
                await assignedResponse.json();

            const assignedSubjects =
                assignedData.data.map(
                    item => parseInt(item.subject_id)
                );

            /* ================================
               SORT CHECKED FIRST
            ================================= */

            subjectsData.data.sort((a, b) => {

                const aAssigned =
                    assignedSubjects.includes(
                        parseInt(a.id)
                    );

                const bAssigned =
                    assignedSubjects.includes(
                        parseInt(b.id)
                    );

                return bAssigned - aAssigned;
            });

            /* ================================
               LOAD ROWS
            ================================= */

            subjectsData.data.forEach(subject => {

                const isAssigned =
                    assignedSubjects.includes(
                        parseInt(subject.id)
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
                        value="${subject.id}"

                        ${
                            isAssigned
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

            /* ================================
               SEARCH
            ================================= */

            $('#subjectSearch').off('keyup').on(
                'keyup',
                function() {

                    $('#subjectsTable')
                        .DataTable()
                        .search(this.value)
                        .draw();
                }
            );

        }

        /* =====================================
           CHANGE COURSE
        ====================================== */

        document.getElementById(
            'course_id'
        ).addEventListener(
            'change',
            loadSubjects
        );

        /* =====================================
           SAVE ASSIGNMENTS
        ====================================== */

        async function saveAssignments() {

            const course_id =
                document.getElementById(
                    'course_id'
                ).value;

            if (
                course_id == ''
            ) {

                showToast(
                    'Please select course.',
                    'danger'
                );

                return;
            }

            const checkedSubjects =
                document.querySelectorAll(
                    '.subject_checkbox:checked'
                );

            /* ================================
               DELETE OLD ASSIGNMENTS
            ================================= */

            await fetch(
                '../api/admin_delete_course_subjects.php', {

                    method: 'POST',

                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },

                    body: `course_id=${course_id}`
                }
            );

            /* ================================
               INSERT NEW ASSIGNMENTS
            ================================= */

            for (
                const checkbox of checkedSubjects
            ) {

                const formData =
                    new FormData();

                formData.append(
                    'course_id',
                    course_id
                );

                formData.append(
                    'subject_id',
                    checkbox.value
                );

                await fetch(
                    '../api/admin_insert_course_subject.php', {

                        method: 'POST',

                        body: formData
                    }
                );
            }

            showToast(
                'Assignments updated successfully.'
            );

            setTimeout(() => {

                loadSubjects();

            }, 500);
        }
    </script>

</body>

</html>