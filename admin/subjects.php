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

                        Manage Subjects

                    </h3>

                    <p class="text-muted mb-0">

                        View and manage all subjects.

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

                                    <th>ID</th>

                                    <th>Subject Code</th>

                                    <th>Subject Name</th>

                                    <th>Year Level</th>

                                    <th>Semester</th>

                                    <th>Units</th>
                                    <th>Description</th>

                                    <th>Status</th>

                                    <th>Date Created</th>

                                    <th width="180">

                                        Actions

                                    </th>

                                </tr>

                            </thead>

                            <tbody id="subjectsTableBody">

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- =====================================
     ADD SUBJECT MODAL
===================================== -->

    <div
        id="addModal"
        class="custom-modal">

        <div class="custom-modal-content">

            <div class="
        d-flex
        justify-content-between
        align-items-center
        mb-4">

                <h4 class="fw-bold mb-0">

                    Add Subject

                </h4>

                <button
                    onclick="closeAddModal()"
                    class="btn-close">
                </button>

            </div>

            <!-- SUBJECT CODE -->
            <div class="mb-3">

                <label class="form-label">

                    Subject Code

                </label>

                <input
                    type="text"
                    class="form-control"
                    id="add_subject_code">

            </div>

            <!-- SUBJECT NAME -->
            <div class="mb-3">

                <label class="form-label">

                    Subject Name

                </label>

                <input
                    type="text"
                    class="form-control"
                    id="add_subject_name">

            </div>

            <!-- YEAR LEVEL -->
            <div class="mb-3">

                <label class="form-label">

                    Year Level

                </label>

                <select
                    class="form-select"
                    id="add_year_level">

                    <option value="">

                        None

                    </option>

                    <option value="Grade 7">Grade 7</option>
                    <option value="Grade 8">Grade 8</option>
                    <option value="Grade 9">Grade 9</option>
                    <option value="Grade 10">Grade 10</option>

                    <option value="Grade 11">Grade 11</option>
                    <option value="Grade 12">Grade 12</option>

                    <option value="1st Year">1st Year</option>
                    <option value="2nd Year">2nd Year</option>
                    <option value="3rd Year">3rd Year</option>
                    <option value="4th Year">4th Year</option>

                </select>

            </div>

            <!-- SEMESTER -->
            <div class="mb-3">

                <label class="form-label">

                    Semester

                </label>

                <select
                    class="form-select"
                    id="add_semester">

                    <option value="1st Semester">

                        1st Semester

                    </option>

                    <option value="2nd Semester">

                        2nd Semester

                    </option>

                    <option value="Summer">

                        Summer

                    </option>

                </select>

            </div>

            <!-- UNITS -->
            <div class="mb-3">

                <label class="form-label">

                    Units

                </label>

                <input
                    type="number"
                    step="0.01"
                    class="form-control"
                    id="add_units">

            </div>

            <!-- DESCRIPTION -->
            <div class="mb-4">

                <label class="form-label">

                    Description

                </label>

                <textarea
                    class="form-control"
                    rows="3"
                    id="add_description"></textarea>

            </div>

            <!-- ACTIONS -->
            <div class="
        d-flex
        justify-content-end
        gap-2">

                <button
                    onclick="closeAddModal()"
                    class="
                btn
                btn-secondary
                ">

                    Cancel

                </button>

                <button
                    onclick="insertSubject()"
                    class="
                btn
                btn-primary
                ">

                    Add Subject

                </button>

            </div>

        </div>

    </div>

    <!-- =====================================
     EDIT MODAL
===================================== -->

    <div
        id="editModal"
        class="custom-modal">

        <div class="custom-modal-content">

            <div class="
        d-flex
        justify-content-between
        align-items-center
        mb-4">

                <h4 class="fw-bold mb-0">

                    Edit Subject

                </h4>

                <button
                    onclick="closeModal()"
                    class="btn-close">
                </button>

            </div>

            <input
                type="hidden"
                id="edit_id">

            <!-- SUBJECT CODE -->
            <div class="mb-3">

                <label class="form-label">

                    Subject Code

                </label>

                <input
                    type="text"
                    class="form-control"
                    id="edit_subject_code">

            </div>

            <!-- SUBJECT NAME -->
            <div class="mb-3">

                <label class="form-label">

                    Subject Name

                </label>

                <input
                    type="text"
                    class="form-control"
                    id="edit_subject_name">

            </div>

            <!-- YEAR LEVEL -->
            <div class="mb-3">

                <label class="form-label">

                    Year Level

                </label>

                <select
                    class="form-select"
                    id="edit_year_level">

                    <option value="">None</option>

                    <option value="Grade 7">Grade 7</option>
                    <option value="Grade 8">Grade 8</option>
                    <option value="Grade 9">Grade 9</option>
                    <option value="Grade 10">Grade 10</option>

                    <option value="Grade 11">Grade 11</option>
                    <option value="Grade 12">Grade 12</option>

                    <option value="1st Year">1st Year</option>
                    <option value="2nd Year">2nd Year</option>
                    <option value="3rd Year">3rd Year</option>
                    <option value="4th Year">4th Year</option>

                </select>

            </div>

            <!-- SEMESTER -->
            <div class="mb-3">

                <label class="form-label">

                    Semester

                </label>

                <select
                    class="form-select"
                    id="edit_semester">

                    <option value="1st Semester">

                        1st Semester

                    </option>

                    <option value="2nd Semester">

                        2nd Semester

                    </option>

                    <option value="Summer">

                        Summer

                    </option>

                </select>

            </div>

            <!-- UNITS -->
            <div class="mb-3">

                <label class="form-label">

                    Units

                </label>

                <input
                    type="number"
                    step="0.01"
                    class="form-control"
                    id="edit_units">

            </div>

            <!-- DESCRIPTION -->
            <div class="mb-4">

                <label class="form-label">

                    Description

                </label>

                <textarea
                    class="form-control"
                    rows="3"
                    id="edit_description"></textarea>

            </div>

            <!-- ACTIONS -->
            <div class="
        d-flex
        justify-content-end
        gap-2">

                <button
                    onclick="closeModal()"
                    class="
                btn
                btn-secondary
                ">

                    Cancel

                </button>

                <button
                    onclick="updateSubject()"
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
   FETCH SUBJECTS
===================================== */

        fetch(
                '../api/admin_select_subjects.php'
            )

            .then(
                res => res.json()
            )

            .then(data => {

                const tableBody =
                    document.getElementById(
                        'subjectsTableBody'
                    );

                tableBody.innerHTML = '';

                data.data.forEach(subject => {

                    const date =
                        new Date(
                            subject.date_created
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

                ${subject.id}

            </td>

            <td>

                ${subject.subject_code}

            </td>

            <td>

                ${subject.subject_name}

            </td>

            <td>

                ${subject.year_level ?? '-'}

            </td>

            <td>

                ${subject.semester}

            </td>

            <td>

                ${subject.units}

            </td>
            <td>

                ${subject.description}

            </td>

            <td>

                ${
                    subject.status == 1

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
                        ${subject.id},
                        '${subject.subject_code}',
                        '${subject.subject_name}',
                        '${subject.year_level}',
                        '${subject.semester}',
                        '${subject.units}',
                        \`${subject.description ?? ''}\`
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
                    deleteSubject(${subject.id})
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

                $('#subjectsTable').DataTable({

                    dom: 'fQrBtip',

                    responsive: true,

                    buttons: [

                        {
                            text: 'Add Subject',

                            className: 'add_subject'
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
                    ]
                });

            });

        /* =====================================
           OPEN ADD MODAL
        ===================================== */

        $(document).on(
            'click',
            '.add_subject',
            function() {

                document.getElementById(
                    'addModal'
                ).style.display = 'flex';
            }
        );

        /* =====================================
           CLOSE ADD MODAL
        ===================================== */

        function closeAddModal() {

            document.getElementById(
                'addModal'
            ).style.display = 'none';
        }

        /* =====================================
           INSERT SUBJECT
        ===================================== */

        async function insertSubject() {

            const subject_code =
                document.getElementById(
                    'add_subject_code'
                ).value.trim();

            const subject_name =
                document.getElementById(
                    'add_subject_name'
                ).value.trim();

            const year_level =
                document.getElementById(
                    'add_year_level'
                ).value;

            const semester =
                document.getElementById(
                    'add_semester'
                ).value;

            const units =
                document.getElementById(
                    'add_units'
                ).value;

            const description =
                document.getElementById(
                    'add_description'
                ).value.trim();

            const formData =
                new FormData();

            formData.append(
                'subject_code',
                subject_code
            );

            formData.append(
                'subject_name',
                subject_name
            );

            formData.append(
                'year_level',
                year_level
            );

            formData.append(
                'semester',
                semester
            );

            formData.append(
                'units',
                units
            );

            formData.append(
                'description',
                description
            );

            const response =
                await fetch(
                    '../api/admin_insert_subject.php', {

                        method: 'POST',

                        body: formData
                    }
                );

            const data =
                await response.json();

            if (data.success == 1) {

                showToast(
                    'Subject added successfully.'
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
        }

        /* =====================================
           OPEN EDIT MODAL
        ===================================== */

        function openEditModal(
            id,
            subject_code,
            subject_name,
            year_level,
            semester,
            units,
            description
        ) {

            document.getElementById(
                'edit_id'
            ).value = id;

            document.getElementById(
                'edit_subject_code'
            ).value = subject_code;

            document.getElementById(
                'edit_subject_name'
            ).value = subject_name;

            document.getElementById(
                'edit_year_level'
            ).value = year_level;

            document.getElementById(
                'edit_semester'
            ).value = semester;

            document.getElementById(
                'edit_units'
            ).value = units;

            document.getElementById(
                'edit_description'
            ).value = description;

            document.getElementById(
                'editModal'
            ).style.display = 'flex';
        }

        /* =====================================
           CLOSE EDIT MODAL
        ===================================== */

        function closeModal() {

            document.getElementById(
                'editModal'
            ).style.display = 'none';
        }

        /* =====================================
           UPDATE SUBJECT
        ===================================== */

        async function updateSubject() {

            const id =
                document.getElementById(
                    'edit_id'
                ).value;

            const subject_code =
                document.getElementById(
                    'edit_subject_code'
                ).value.trim();

            const subject_name =
                document.getElementById(
                    'edit_subject_name'
                ).value.trim();

            const year_level =
                document.getElementById(
                    'edit_year_level'
                ).value;

            const semester =
                document.getElementById(
                    'edit_semester'
                ).value;

            const units =
                document.getElementById(
                    'edit_units'
                ).value;

            const description =
                document.getElementById(
                    'edit_description'
                ).value.trim();

            const formData =
                new FormData();

            formData.append(
                'id',
                id
            );

            formData.append(
                'subject_code',
                subject_code
            );

            formData.append(
                'subject_name',
                subject_name
            );

            formData.append(
                'year_level',
                year_level
            );

            formData.append(
                'semester',
                semester
            );

            formData.append(
                'units',
                units
            );

            formData.append(
                'description',
                description
            );

            const response =
                await fetch(
                    '../api/admin_update_subject.php', {

                        method: 'POST',

                        body: formData
                    }
                );

            const data =
                await response.json();

            if (data.success == 1) {

                showToast(
                    'Subject updated successfully.'
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
        }

        /* =====================================
           DELETE SUBJECT
        ===================================== */

        async function deleteSubject(id) {

            const confirmation =
                confirm(
                    'Are you sure you want to archive this subject?'
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

            const response =
                await fetch(
                    '../api/admin_delete_subject.php', {

                        method: 'POST',

                        body: formData
                    }
                );

            const data =
                await response.json();

            if (data.success == 1) {

                showToast(
                    'Subject archived successfully.'
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
        }
    </script>



</body>

</html>