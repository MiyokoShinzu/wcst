<?php include "../globals/admin_head.php" ?>

<style>
    .custom-modal {

        position: fixed;

        inset: 0;

        background: rgba(0, 0, 0, 0.5);

        display: none;

        justify-content: center;

        align-items: center;

        z-index: 9999;

        padding: 20px;
    }

    .custom-modal-content {

        background: #fff;

        width: 100%;

        max-width: 550px;

        border-radius: 20px;

        padding: 30px;

        box-shadow:
            0 10px 40px rgba(0, 0, 0, 0.2);

        animation:
            modalFade 0.2s ease;
    }

    @keyframes modalFade {

        from {

            transform: translateY(20px);

            opacity: 0;
        }

        to {

            transform: translateY(0);

            opacity: 1;
        }
    }
</style>

<body>

    <!-- SIDEBAR -->
    <?php include "../globals/admin_sidebar.php" ?>

    <!-- MAIN CONTENT -->
    <div class="content">

        <div class="container-fluid mt-4">

            <!-- PAGE HEADER -->
            <div class="
            d-flex
            justify-content-between
            align-items-center
            mb-4">

                <div>

                    <h3 class="fw-bold text-primary">

                        Manage Courses

                    </h3>

                    <p class="text-muted mb-0">

                        View and manage all programs and courses.

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

                    <!-- TABLE -->
                    <div class="table-responsive">

                        <table
                            class="
                            table
                            table-hover
                            align-middle
                            "
                            id="coursesTable">

                            <thead class="table-primary">

                                <tr>

                                    <th>ID</th>

                                    <th>Course Name</th>

                                    <th>Course Code</th>

                                    <th>Program Type</th>

                                    <th>Duration</th>

                                    <th>Strand</th>

                                    <th>Status</th>

                                    <th>Date Created</th>

                                    <th width="180">

                                        Actions

                                    </th>

                                </tr>

                            </thead>

                            <tbody id="coursesTableBody">

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- =====================================
         ADD COURSE MODAL
    ====================================== -->

    <div
        id="addCourseModal"
        class="custom-modal">

        <div class="custom-modal-content">

            <!-- HEADER -->
            <div class="
            d-flex
            justify-content-between
            align-items-center
            mb-4
            ">

                <h4 class="fw-bold mb-0">

                    Add Course

                </h4>

                <button
                    onclick="closeAddModal()"
                    class="btn-close">
                </button>

            </div>

            <!-- COURSE NAME -->
            <div class="mb-3">

                <label class="form-label">

                    Course Name

                </label>

                <input
                    type="text"
                    class="form-control"
                    id="add_course_name">

            </div>

            <!-- COURSE CODE -->
            <div class="mb-3">

                <label class="form-label">

                    Course Code

                </label>

                <input
                    type="text"
                    class="form-control"
                    id="add_course_code">

            </div>

            <!-- PROGRAM TYPE -->
            <div class="mb-3">

                <label class="form-label">

                    Program Type

                </label>

                <select
                    class="form-select"
                    id="add_program_type">

                    <option value="TESDA Programs">

                        TESDA Programs

                    </option>

                    <option value="PQ5 Programs">

                        PQ5 Programs

                    </option>

                    <option value="JHS">

                        JHS

                    </option>

                    <option value="SHS">

                        SHS

                    </option>

                </select>

            </div>

            <!-- DURATION -->
            <div class="mb-3">

                <label class="form-label">

                    Duration (Years)

                </label>

                <input
                    type="number"
                    class="form-control"
                    id="add_duration_years">

            </div>

            <!-- STRAND -->
            <div class="mb-4">

                <label class="form-label">

                    Strand

                </label>

                <input
                    type="text"
                    class="form-control"
                    id="add_strand">

            </div>

            <!-- ACTIONS -->
            <div class="
            d-flex
            justify-content-end
            gap-2
            ">

                <button
                    onclick="closeAddModal()"
                    class="
                    btn
                    btn-secondary
                    ">

                    Cancel

                </button>

                <button
                    onclick="insertCourse()"
                    class="
                    btn
                    btn-primary
                    ">

                    Add Course

                </button>

            </div>

        </div>

    </div>

    <!-- =====================================
         EDIT COURSE MODAL
    ====================================== -->

    <div
        id="editModal"
        class="custom-modal">

        <div class="custom-modal-content">

            <!-- HEADER -->
            <div class="
            d-flex
            justify-content-between
            align-items-center
            mb-4
            ">

                <h4 class="fw-bold mb-0">

                    Edit Course

                </h4>

                <button
                    onclick="closeModal()"
                    class="btn-close">
                </button>

            </div>

            <input
                type="hidden"
                id="edit_id">

            <!-- COURSE NAME -->
            <div class="mb-3">

                <label class="form-label">

                    Course Name

                </label>

                <input
                    type="text"
                    class="form-control"
                    id="edit_course_name">

            </div>

            <!-- COURSE CODE -->
            <div class="mb-3">

                <label class="form-label">

                    Course Code

                </label>

                <input
                    type="text"
                    class="form-control"
                    id="edit_course_code">

            </div>

            <!-- PROGRAM TYPE -->
            <div class="mb-3">

                <label class="form-label">

                    Program Type

                </label>

                <select
                    class="form-select"
                    id="edit_program_type">

                    <option value="TESDA Programs">

                        TESDA Programs

                    </option>

                    <option value="PQ5 Programs">

                        PQ5 Programs

                    </option>

                    <option value="JHS">

                        JHS

                    </option>

                    <option value="SHS">

                        SHS

                    </option>

                </select>

            </div>

            <!-- DURATION -->
            <div class="mb-3">

                <label class="form-label">

                    Duration (Years)

                </label>

                <input
                    type="number"
                    class="form-control"
                    id="edit_duration_years">

            </div>

            <!-- STRAND -->
            <div class="mb-4">

                <label class="form-label">

                    Strand

                </label>

                <input
                    type="text"
                    class="form-control"
                    id="edit_strand">

            </div>

            <!-- ACTIONS -->
            <div class="
            d-flex
            justify-content-end
            gap-2
            ">

                <button
                    onclick="closeModal()"
                    class="
                    btn
                    btn-secondary
                    ">

                    Cancel

                </button>

                <button
                    onclick="updateCourse()"
                    class="
                    btn
                    btn-primary
                    ">

                    Save Changes

                </button>

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

    <!-- SCRIPTS -->
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
           FETCH COURSES
        ====================================== */

        fetch(
                '../api/admin_select_courses.php'
            )

            .then(
                res => res.json()
            )

            .then(data => {

                const tableBody =
                    document.getElementById(
                        'coursesTableBody'
                    );

                tableBody.innerHTML = '';

                data.data.forEach(course => {

                    const date =
                        new Date(
                            course.date_created
                        );

                    const formattedDate =
                        date.toLocaleDateString(
                            'en-US', {

                                year: 'numeric',

                                month: 'short',

                                day: 'numeric'
                            }
                        );

                    tableBody.innerHTML += `

                <tr>

                    <td>

                        ${course.id}

                    </td>

                    <td>

                        ${course.course_name}

                    </td>

                    <td>

                        ${course.course_code}

                    </td>

                    <td>

                        <span class="
                        badge
                        bg-primary
                        ">

                            ${course.program_type}

                        </span>

                    </td>

                    <td>

                        ${course.duration_years} Year(s)

                    </td>

                    <td>

                        ${course.strand ?? '-'}

                    </td>

                    <td>

                        ${
                            course.status == 1

                            ?

                            `<span class="
                            badge
                            bg-success
                            ">
                                Active
                            </span>`

                            :

                            `<span class="
                            badge
                            bg-danger
                            ">
                                Archived
                            </span>`
                        }

                    </td>

                    <td>

                        ${formattedDate}

                    </td>

                    <td>

                     <!-- EDIT -->
<button
    onclick="
    openEditModal(
        ${course.id},
        '${course.course_name}',
        '${course.course_code}',
        '${course.program_type}',
        '${course.duration_years}',
        '${course.strand}',
        '${course.status}'
    )
    "
    class="
    btn
    btn-primary
    btn-sm
    rounded-pill
    shadow-sm
    ">

    <i class="
    bi bi-pencil-fill
    "></i>

</button>

<!-- DELETE -->
<button
    onclick="
    deleteCourse(${course.id})
    "
    class="
    btn
    btn-danger
    btn-sm
    rounded-pill
    shadow-sm
    ">

    <i class="
    bi bi-trash-fill
    "></i>

</button>
                    </td>

                </tr>

                `;
                });

                $('#coursesTable').DataTable({

                    dom: 'fQrBtip',

                    responsive: true,

                    buttons: [

                        {
                            text: 'Add Course',

                            className: 'add_course'
                        },

                        {
                            extend: 'excel',

                            text: 'Excel'
                        },

                        {
                            extend: 'pdf',

                            text: 'PDF'
                        },

                        {
                            extend: 'print',

                            text: 'Print'
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

                    scrollCollapse: true
                });

            });

        /* =====================================
           OPEN ADD MODAL
        ====================================== */

        $(document).on(
            'click',
            '.add_course',
            function() {

                document.getElementById(
                    'addCourseModal'
                ).style.display = 'flex';
            }
        );

        /* =====================================
           CLOSE ADD MODAL
        ====================================== */

        function closeAddModal() {

            document.getElementById(
                'addCourseModal'
            ).style.display = 'none';
        }

        /* =====================================
           INSERT COURSE
        ====================================== */

        async function insertCourse() {

            const course_name =
                document.getElementById(
                    'add_course_name'
                ).value.trim();

            const course_code =
                document.getElementById(
                    'add_course_code'
                ).value.trim();

            const program_type =
                document.getElementById(
                    'add_program_type'
                ).value;

            const duration_years =
                document.getElementById(
                    'add_duration_years'
                ).value;

            const strand =
                document.getElementById(
                    'add_strand'
                ).value.trim();

            const formData =
                new FormData();

            formData.append(
                'course_name',
                course_name
            );

            formData.append(
                'course_code',
                course_code
            );

            formData.append(
                'program_type',
                program_type
            );

            formData.append(
                'duration_years',
                duration_years
            );

            formData.append(
                'strand',
                strand
            );

            try {

                const response =
                    await fetch(
                        '../api/admin_insert_course.php', {

                            method: 'POST',

                            body: formData
                        }
                    );

                const data =
                    await response.json();

                if (data.success == 1) {

                    showToast(
                        'Course added successfully.'
                    );

                    closeAddModal();

                    setTimeout(() => {

                        location.reload();

                    }, 1000);

                } else {

                    showToast(
                        data.message,
                        'danger'
                    );
                }

            } catch (error) {

                console.log(error);

                showToast(
                    'Server error.',
                    'danger'
                );
            }
        }

        /* =====================================
           OPEN EDIT MODAL
        ====================================== */

        function openEditModal(
            id,
            course_name,
            course_code,
            program_type,
            duration_years,
            strand
        ) {

            document.getElementById(
                'edit_id'
            ).value = id;

            document.getElementById(
                'edit_course_name'
            ).value = course_name;

            document.getElementById(
                'edit_course_code'
            ).value = course_code;

            document.getElementById(
                'edit_program_type'
            ).value = program_type;

            document.getElementById(
                'edit_duration_years'
            ).value = duration_years;

            document.getElementById(
                'edit_strand'
            ).value = strand;

            document.getElementById(
                'editModal'
            ).style.display = 'flex';
        }

        /* =====================================
           CLOSE MODAL
        ====================================== */

        function closeModal() {

            document.getElementById(
                'editModal'
            ).style.display = 'none';
        }

        /* =====================================
           UPDATE COURSE
        ====================================== */

        async function updateCourse() {

            const id =
                document.getElementById(
                    'edit_id'
                ).value;

            const course_name =
                document.getElementById(
                    'edit_course_name'
                )
                .value
                .trim();

            const course_code =
                document.getElementById(
                    'edit_course_code'
                )
                .value
                .trim();

            const program_type =
                document.getElementById(
                    'edit_program_type'
                )
                .value;

            const duration_years =
                document.getElementById(
                    'edit_duration_years'
                )
                .value;

            const strand =
                document.getElementById(
                    'edit_strand'
                )
                .value
                .trim();

            const formData =
                new FormData();

            formData.append(
                'id',
                id
            );

            formData.append(
                'course_name',
                course_name
            );

            formData.append(
                'course_code',
                course_code
            );

            formData.append(
                'program_type',
                program_type
            );

            formData.append(
                'duration_years',
                duration_years
            );

            formData.append(
                'strand',
                strand
            );

            try {

                const response =
                    await fetch(
                        '../api/admin_update_course.php', {

                            method: 'POST',

                            body: formData
                        }
                    );

                const data =
                    await response.json();

                if (data.success == 1) {

                    showToast(
                        'Course updated successfully.'
                    );

                    closeModal();

                    setTimeout(() => {

                        location.reload();

                    }, 1000);

                } else {

                    showToast(
                        data.message,
                        'danger'
                    );
                }

            } catch (error) {

                console.log(error);

                showToast(
                    'Server error.',
                    'danger'
                );
            }
        }



        /* =====================================
   DELETE COURSE
===================================== */

        async function deleteCourse(id) {

            const confirmation =
                confirm(
                    'Are you sure you want to archive this course?'
                );

            if (!confirmation) {

                return;
            }

            const formData =
                new FormData();

            formData.append(
                'id',
                id
            );

            try {

                const response =
                    await fetch(
                        '../api/admin_delete_course.php', {

                            method: 'POST',

                            body: formData
                        }
                    );

                const data =
                    await response.json();

                if (data.success == 1) {

                    showToast(
                        'Course archived successfully.'
                    );

                    setTimeout(() => {

                        location.reload();

                    }, 1000);

                } else {

                    showToast(
                        data.message,
                        'danger'
                    );
                }

            } catch (error) {

                console.log(error);

                showToast(
                    'Server error.',
                    'danger'
                );
            }
        }
    </script>

</body>

</html>