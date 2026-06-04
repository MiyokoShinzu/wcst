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

                        Manage Faculty Accounts

                    </h3>

                    <p class="text-muted mb-0">

                        View and manage all faculty accounts.

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
                            id="accountsTable">

                            <thead class="table-primary">

                                <tr>

                                    <th>ID</th>

                                    <th>Username</th>

                                    <th>Email</th>


                                    <th>Status</th>

                                    <th>Date Created</th>

                                    <th width="180">

                                        Actions

                                    </th>

                                </tr>

                            </thead>

                            <tbody id="accountsTableBody">

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- =====================================
         CUSTOM EDIT MODAL
    ====================================== -->

    <!-- Insert Modal -->

    <!-- =====================================
     ADD ACCOUNT MODAL
===================================== -->

    <div
        id="addAccountModal"
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

                    Add Account

                </h4>

                <button
                    onclick="closeAddModal()"
                    class="btn-close">
                </button>

            </div>

            <!-- USERNAME -->
            <div class="mb-3">

                <label class="form-label">

                    Username

                </label>

                <input
                    type="text"
                    class="form-control"
                    id="add_username">

            </div>

            <!-- EMAIL -->
            <div class="mb-3">

                <label class="form-label">

                    Email

                </label>

                <input
                    type="email"
                    class="form-control"
                    id="add_email">

            </div>

            <!-- PASSWORD -->
            <div class="mb-3">

                <label class="form-label">

                    Password

                </label>

                <input
                    type="password"
                    class="form-control"
                    id="add_password">

            </div>

            <!-- ROLE -->
            <div class="mb-3">

                <label class="form-label">

                    Role

                </label>

                <select
                    class="form-select"
                    id="add_role">

                    <option value="admin">

                        Admin

                    </option>

                    <option value="faculty">

                        Faculty

                    </option>

                    <option value="student">

                        Student

                    </option>

                </select>

            </div>

            <!-- STATUS -->
            <div class="mb-4">

                <label class="form-label">

                    Status

                </label>

                <select
                    class="form-select"
                    id="add_status">

                    <option value="1">

                        Approved

                    </option>

                    <option value="0">

                        Pending Approval

                    </option>

                </select>

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
                    onclick="insertAccount()"
                    class="
                btn
                btn-primary
                ">

                    Add Account

                </button>

            </div>

        </div>

    </div>

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

                    Edit Account

                </h4>

                <button
                    onclick="closeModal()"
                    class="
                    btn-close
                    ">
                </button>

            </div>

            <!-- ID -->
            <input
                type="hidden"
                id="edit_id">

            <!-- USERNAME -->
            <div class="mb-3">

                <label class="form-label">

                    Username

                </label>

                <input
                    type="text"
                    class="form-control"
                    id="edit_username">

            </div>

            <!-- EMAIL -->
            <div class="mb-3">

                <label class="form-label">

                    Email

                </label>

                <input
                    type="email"
                    class="form-control"
                    id="edit_email">

            </div>

            <!-- ROLE -->
            <div class="mb-3" style="display: none;">

                <label class="form-label">

                    Role

                </label>

                <select
                    class="form-select"
                    id="edit_role">

                    <option value="faculty">

                        Faculty

                    </option>

                    

                </select>

            </div>

            <!-- STATUS -->
            <div class="mb-4" style="display: none;">

                <label class="form-label">

                    Status

                </label>

                <select
                    class="form-select"
                    id="edit_status">

                    <option value="1">
                        Approve
                    </option>

                   

                </select>

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
                    onclick="updateAccount()"
                    class="
                    btn
                    btn-primary
                    ">

                    Save Changes

                </button>

            </div>

        </div>

    </div>

    <!-- =====================================
         TOAST
    ====================================== -->

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









    <!-- student_profile -->
    <!-- =====================================
     VIEW STUDENT PROFILE MODAL
===================================== -->

 
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
           FETCH ACCOUNTS
        ====================================== */

        fetch(
                '../api/admin_select_accounts_faculty.php'
            )

            .then(
                res => res.json()
            )

            .then(data => {

                const tableBody =
                    document.getElementById(
                        'accountsTableBody'
                    );

                tableBody.innerHTML = '';

                data.data.forEach(account => {

                    const date =
                        new Date(
                            account.date_created
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

                        ${account.id}

                    </td>

                    <td>

                        ${account.username}

                    </td>

                    <td>

                        ${account.email}

                    </td>

                  

                    <td>

                        ${
                            account.status == 1

                            ?

                            `<span class="
                            badge
                            bg-success
                            ">
                                Approved
                            </span>`

                            :

                            `<span class="
                            badge
                            bg-warning
                            ">
                                Pending
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
                                ${account.id},
                                '${account.username}',
                                '${account.email}',
                                '${account.role}',
                                '${account.status}'
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
                            deleteAccount(${account.id})
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
                         ${
    account.role == 'student'

    ?

    `
    <!-- VIEW STUDENT PROFILE -->
    <button
        onclick="
        viewStudentProfile(${account.id})
        "
        class="
        btn
        btn-success
        text-white
        btn-sm
        rounded-pill
        shadow-sm
        " title="View Student Profile">

        <i class="
        bi bi-person-vcard-fill
        "></i>

    </button>
    `

    :

    ''
}

                    </td>

                </tr>

                `;
                });

                /* =====================================
                   KEEP YOUR EXACT DATATABLE
                ====================================== */

                $('#accountsTable').DataTable({

                    dom: 'frBtip',

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

        /* =====================================
           OPEN MODAL
        ====================================== */

        function openEditModal(
            id,
            username,
            email,
            role,
            status
        ) {

            document.getElementById(
                'edit_id'
            ).value = id;

            document.getElementById(
                'edit_username'
            ).value = username;

            document.getElementById(
                'edit_email'
            ).value = email;

            document.getElementById(
                'edit_role'
            ).value = role;

            document.getElementById(
                'edit_status'
            ).value = status;

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
           UPDATE ACCOUNT
        ====================================== */

        async function updateAccount() {

            const id =
                document.getElementById(
                    'edit_id'
                ).value;

            const username =
                document.getElementById(
                    'edit_username'
                )
                .value
                .trim();

            const email =
                document.getElementById(
                    'edit_email'
                )
                .value
                .trim();

            const role =
                document.getElementById(
                    'edit_role'
                )
                .value;

            const status =
                document.getElementById(
                    'edit_status'
                )
                .value;

            const formData =
                new FormData();

            formData.append(
                'id',
                id
            );

            formData.append(
                'username',
                username
            );

            formData.append(
                'email',
                email
            );

            formData.append(
                'role',
                role
            );

            formData.append(
                'status',
                status
            );

            try {

                const response =
                    await fetch(
                        '../api/admin_update_account.php', {

                            method: 'POST',

                            body: formData
                        }
                    );

                const data =
                    await response.json();

                if (data.success == 1) {

                    showToast(
                        'Account updated successfully.'
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
   OPEN ADD ACCOUNT MODAL
===================================== */

        $(document).on(
            'click',
            '.add_account',
            function() {

                document.getElementById(
                    'addAccountModal'
                ).style.display = 'flex';
            }
        );

        /* =====================================
           CLOSE ADD ACCOUNT MODAL
        ===================================== */

        function closeAddModal() {

            document.getElementById(
                'addAccountModal'
            ).style.display = 'none';
        }

        /* =====================================
           INSERT ACCOUNT
        ===================================== */

        async function insertAccount() {

            const username =
                document.getElementById(
                    'add_username'
                )
                .value
                .trim();

            const email =
                document.getElementById(
                    'add_email'
                )
                .value
                .trim();

            const password =
                document.getElementById(
                    'add_password'
                )
                .value
                .trim();

            const role =
                document.getElementById(
                    'add_role'
                )
                .value;

            const status =
                document.getElementById(
                    'add_status'
                )
                .value;

            /* VALIDATION */

            if (

                username == '' ||

                email == '' ||

                password == ''

            ) {

                showToast(
                    'All fields are required.',
                    'danger'
                );

                return;
            }

            const formData =
                new FormData();

            formData.append(
                'username',
                username
            );

            formData.append(
                'email',
                email
            );

            formData.append(
                'password',
                password
            );

            formData.append(
                'role',
                role
            );

            formData.append(
                'status',
                status
            );

            try {

                const response =
                    await fetch(
                        '../api/admin_insert_account.php', {

                            method: 'POST',

                            body: formData
                        }
                    );

                const data =
                    await response.json();

                if (data.success == 1) {

                    showToast(
                        'Account added successfully.'
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
   DELETE ACCOUNT
===================================== */

        async function deleteAccount(id) {

            const confirmation =
                confirm(
                    'Are you sure you want to archive this account?'
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
                        '../api/admin_delete_account.php', {

                            method: 'POST',

                            body: formData
                        }
                    );

                const data =
                    await response.json();

                if (data.success == 1) {

                    showToast(
                        'Account archived successfully.'
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




        /* =====================================
   VIEW STUDENT PROFILE
===================================== */

        async function viewStudentProfile(account_id) {

            try {

                const response =
                    await fetch(
                        `../api/admin_view_student.php?account_id=${account_id}`
                    );

                const data =
                    await response.json();

                if (data.success == 1) {

                    const student =
                        data.data;

                    document.getElementById(
                            'view_student_number'
                        ).innerHTML =
                        student.student_number ?? '-';

                    document.getElementById(
                            'view_fullname'
                        ).innerHTML =
                        `
            ${student.firstname ?? ''}
            ${student.middlename ?? ''}
            ${student.lastname ?? ''}
            `;

                    document.getElementById(
                            'view_year_level'
                        ).innerHTML =
                        student.year_level ?? '-';

                    document.getElementById(
                            'view_section'
                        ).innerHTML =
                        student.section ?? '-';

                    document.getElementById(
                            'view_school_year'
                        ).innerHTML =
                        student.school_year ?? '-';

                    document.getElementById(
                            'view_contact_number'
                        ).innerHTML =
                        student.contact_number ?? '-';

                    document.getElementById(
                            'view_address'
                        ).innerHTML =
                        student.address ?? '-';

                    document.getElementById(
                        'viewStudentModal'
                    ).style.display = 'flex';

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
           CLOSE STUDENT MODAL
        ===================================== */

        function closeStudentModal() {

            document.getElementById(
                'viewStudentModal'
            ).style.display = 'none';
        }
    </script>

</body>

</html>