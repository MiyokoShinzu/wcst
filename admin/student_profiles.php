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

                        Student Profiles

                    </h3>

                    <p class="text-muted mb-0">

                        View all registered students.

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
                            id="studentsTable">

                            <thead class="table-primary">

                                <tr>

                                    <th>ID</th>

                                    <th>Username</th>

                                    <th>Email</th>

                                    <th>Student Number</th>

                                    <th>Full Name</th>

                                    <th>Year Level</th>

                                    <th>Section</th>

                                    <th>School Year</th>

                                    <th>Contact</th>

                                    <th>Status</th>

                                </tr>

                            </thead>

                            <tbody id="studentsTableBody">

                            </tbody>

                        </table>

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
       FETCH STUDENTS
    ====================================== */

        fetch(
                '../api/admin_select_students.php'
            )

            .then(
                res => res.json()
            )

            .then(data => {

                const tableBody =
                    document.getElementById(
                        'studentsTableBody'
                    );

                tableBody.innerHTML = '';

                data.data.forEach(student => {

                    tableBody.innerHTML += `

            <tr>

                <td>

                    ${student.account_id}

                </td>

                <td>

                    ${student.username ?? '-'}

                </td>

                <td>

                    ${student.email ?? '-'}

                </td>

                <td>

                    ${student.student_number ?? '-'}

                </td>

                <td>

                    ${student.firstname ?? ''}

                    ${student.middlename ?? ''}

                    ${student.lastname ?? ''}

                </td>

                <td>

                    ${student.year_level ?? '-'}

                </td>

                <td>

                    ${student.section ?? '-'}

                </td>

                <td>

                    ${student.school_year ?? '-'}

                </td>

                <td>

                    ${student.contact_number ?? '-'}

                </td>

                <td>

                    ${
                        student.account_status == 1

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
                        bg-danger
                        ">
                            Pending Approval
                        </span>`
                    }

                </td>

            </tr>

            `;
                });

                $('#studentsTable').DataTable({

                    dom: 'fQrBtip',

                    responsive: true,

                    buttons: [

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
    </script>

</body>

</html>