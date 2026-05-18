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

                        Faculty Profiles

                    </h3>

                    <p class="text-muted mb-0">

                        View all registered faculty profiles.

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
                            id="facultyTable">

                            <thead class="table-primary">

                                <tr>

                                    <th>ID</th>

                                    <th>Username</th>

                                    <th>Email</th>

                                    <th>Faculty Number</th>

                                    <th>Full Name</th>

                                    <th>Gender</th>

                                    <th>Specialization</th>

                                    <th>Employment</th>

                                    <th>Contact</th>

                                    <th>Status</th>

                                </tr>

                            </thead>

                            <tbody id="facultyTableBody">

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <?php include "../globals/admin_scripts.php" ?>

    <script>
        /* =====================================
       FETCH FACULTY
    ====================================== */

        fetch(
                '../api/admin_select_faculty.php'
            )

            .then(
                res => res.json()
            )

            .then(data => {

                const tableBody =
                    document.getElementById(
                        'facultyTableBody'
                    );

                tableBody.innerHTML = '';

                data.data.forEach(faculty => {

                    tableBody.innerHTML += `

            <tr>

                <td>

                    ${faculty.id}

                </td>

                <td>

                    ${faculty.username ?? '-'}

                </td>

                <td>

                    ${faculty.email ?? '-'}

                </td>

                <td>

                    ${faculty.faculty_number ?? '-'}

                </td>

                <td>

                    ${faculty.firstname ?? ''}

                    ${faculty.middlename ?? ''}

                    ${faculty.lastname ?? ''}

                </td>

                <td>

                    ${faculty.gender ?? '-'}

                </td>

                <td>

                    ${faculty.specialization ?? '-'}

                </td>

                <td>

                    ${faculty.employment_status ?? '-'}

                </td>

                <td>

                    ${faculty.contact_number ?? '-'}

                </td>

                <td>

                    ${
                        faculty.account_status == 1

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

                $('#facultyTable').DataTable({

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