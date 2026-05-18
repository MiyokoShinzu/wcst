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

        max-width: 500px;

        border-radius: 20px;

        padding: 30px;

        box-shadow:
            0 10px 40px rgba(0, 0, 0, 0.2);
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

                        Manage School Years

                    </h3>

                    <p class="text-muted mb-0">

                        View and manage school years.

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
                            id="schoolYearTable">

                            <thead class="table-primary">

                                <tr>

                                    <th>ID</th>

                                    <th>School Year</th>

                                    <th>Semester</th>

                                    <th>Status</th>

                                    <th>Date Created</th>

                                    <th width="180">

                                        Actions

                                    </th>

                                </tr>

                            </thead>

                            <tbody id="schoolYearTableBody">

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- =====================================
     ADD MODAL
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

                    Add School Year

                </h4>

                <button
                    onclick="closeAddModal()"
                    class="btn-close">
                </button>

            </div>

            <!-- SCHOOL YEAR -->
            <div class="mb-3">

                <label class="form-label">

                    School Year

                </label>

                <input
                    type="text"
                    class="form-control"
                    id="add_school_year"
                    placeholder="2025-2026">

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

            <!-- ACTIVE -->
            <div class="mb-4">

                <label class="form-label">

                    Active

                </label>

                <select
                    class="form-select"
                    id="add_is_active">

                    <option value="1">

                        Active

                    </option>

                    <option value="0">

                        Inactive

                    </option>

                </select>

            </div>

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
                    onclick="insertSchoolYear()"
                    class="
                btn
                btn-primary
                ">

                    Add School Year

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

                    Edit School Year

                </h4>

                <button
                    onclick="closeModal()"
                    class="btn-close">
                </button>

            </div>

            <input
                type="hidden"
                id="edit_id">

            <!-- SCHOOL YEAR -->
            <div class="mb-3">

                <label class="form-label">

                    School Year

                </label>

                <input
                    type="text"
                    class="form-control"
                    id="edit_school_year">

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

            <!-- ACTIVE -->
            <div class="mb-4">

                <label class="form-label">

                    Active

                </label>

                <select
                    class="form-select"
                    id="edit_is_active">

                    <option value="1">

                        Active

                    </option>

                    <option value="0">

                        Inactive

                    </option>

                </select>

            </div>

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
                    onclick="updateSchoolYear()"
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
           FETCH SCHOOL YEARS
        ====================================== */

        fetch(
                '../api/admin_select_school_years.php'
            )

            .then(
                res => res.json()
            )

            .then(data => {

                const tableBody =
                    document.getElementById(
                        'schoolYearTableBody'
                    );

                tableBody.innerHTML = '';

                data.data.forEach(sy => {

                    const date =
                        new Date(
                            sy.date_created
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

                    ${sy.id}

                </td>

                <td>

                    ${sy.school_year}

                </td>

                <td>

                    ${sy.semester}

                </td>

                <td>

                    ${
                        sy.is_active == 1

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
                        bg-secondary
                        ">
                            Inactive
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
                            ${sy.id},
                            '${sy.school_year}',
                            '${sy.semester}',
                            '${sy.is_active}'
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
                        deleteSchoolYear(${sy.id})
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

                $('#schoolYearTable').DataTable({

                    dom: 'fQrBtip',

                    responsive: true,

                    buttons: [

                        {
                            text: 'Add School Year',

                            className: 'add_school_year'
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
        ====================================== */

        $(document).on(
            'click',
            '.add_school_year',
            function() {

                document.getElementById(
                    'addModal'
                ).style.display = 'flex';
            }
        );

        function closeAddModal() {

            document.getElementById(
                'addModal'
            ).style.display = 'none';
        }

        /* =====================================
           INSERT
        ====================================== */

        async function insertSchoolYear() {

            const school_year =
                document.getElementById(
                    'add_school_year'
                ).value.trim();

            const semester =
                document.getElementById(
                    'add_semester'
                ).value;

            const is_active =
                document.getElementById(
                    'add_is_active'
                ).value;

            const formData =
                new FormData();

            formData.append(
                'school_year',
                school_year
            );

            formData.append(
                'semester',
                semester
            );

            formData.append(
                'is_active',
                is_active
            );

            const response =
                await fetch(
                    '../api/admin_insert_school_year.php', {

                        method: 'POST',

                        body: formData
                    }
                );

            const data =
                await response.json();

            if (data.success == 1) {

                showToast(
                    'School year added successfully.'
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
        ====================================== */

        function openEditModal(
            id,
            school_year,
            semester,
            is_active
        ) {

            document.getElementById(
                'edit_id'
            ).value = id;

            document.getElementById(
                'edit_school_year'
            ).value = school_year;

            document.getElementById(
                'edit_semester'
            ).value = semester;

            document.getElementById(
                'edit_is_active'
            ).value = is_active;

            document.getElementById(
                'editModal'
            ).style.display = 'flex';
        }

        /* =====================================
           CLOSE EDIT MODAL
        ====================================== */

        function closeModal() {

            document.getElementById(
                'editModal'
            ).style.display = 'none';
        }

        /* =====================================
           UPDATE
        ====================================== */

        async function updateSchoolYear() {

            const id =
                document.getElementById(
                    'edit_id'
                ).value;

            const school_year =
                document.getElementById(
                    'edit_school_year'
                ).value.trim();

            const semester =
                document.getElementById(
                    'edit_semester'
                ).value;

            const is_active =
                document.getElementById(
                    'edit_is_active'
                ).value;

            const formData =
                new FormData();

            formData.append(
                'id',
                id
            );

            formData.append(
                'school_year',
                school_year
            );

            formData.append(
                'semester',
                semester
            );

            formData.append(
                'is_active',
                is_active
            );

            const response =
                await fetch(
                    '../api/admin_update_school_year.php', {

                        method: 'POST',

                        body: formData
                    }
                );

            const data =
                await response.json();

            if (data.success == 1) {

                showToast(
                    'School year updated successfully.'
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
           DELETE
        ====================================== */

        async function deleteSchoolYear(id) {

            const confirmation =
                confirm(
                    'Are you sure you want to archive this school year?'
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
                    '../api/admin_delete_school_year.php', {

                        method: 'POST',

                        body: formData
                    }
                );

            const data =
                await response.json();

            if (data.success == 1) {

                showToast(
                    'School year archived successfully.'
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