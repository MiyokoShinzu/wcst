<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard NAS</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- FullCalendar -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
    <link rel="icon" href="./assets/logo.jpg">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f8f9fa;
            overflow-x: hidden;
        }

        /* Left Sidebar */
        .sidebar {
            min-height: 100vh;
            background: #ffffff;
            border-right: 1px solid #dee2e6;
            position: fixed;
            top: 0;
            left: 0;
            width: 260px;
            padding: 20px;
            overflow: hidden;
            transition: 0.3s;
            z-index: 1000;
        }

        .sidebar::before {
            content: '';
            position: absolute;
            top: -50px;
            right: -50px;
            width: 150px;
            height: 150px;
            background: rgba(13, 110, 253, 0.1);
            border-radius: 50%;
        }

        .sidebar::after {
            content: '';
            position: absolute;
            bottom: -50px;
            left: -50px;
            width: 150px;
            height: 150px;
            background: rgba(13, 110, 253, 0.1);
            border-radius: 50%;
        }

        .sidebar .sidebar-brand {
            display: flex;
            align-items: center;
            margin-bottom: 40px;
            position: relative;
            z-index: 1;
        }

        .sidebar .sidebar-brand img {
            max-width: 50px;
            margin-right: 10px;
        }

        .sidebar .nav-link {
            color: #6c757d;
            font-weight: 600;
            margin: 5px 0;
            border-radius: 8px;
            position: relative;
            z-index: 1;
            transition: 0.3s;
            display: flex;
            align-items: center;
            font-size: 0.85rem;
            text-align: left;
            padding-left: 10px;
        }

        .sidebar .nav-link i {
            margin-right: 10px;
        }

        .sidebar .nav-link:hover {
            color: #fff;
            background-color: #0d6efd;
        }

        .sidebar .submenu a {
            font-weight: 500;
            padding-left: 35px;
            font-size: 0.8rem;
            text-align: left;
        }

        .sidebar .close-btn {
            display: none;
            font-size: 1.5rem;
            position: absolute;
            top: 15px;
            right: 15px;
            cursor: pointer;
            z-index: 1001;
        }

        /* Main content */
        .content {
            margin-left: 260px;
            padding: 20px;
            transition: 0.3s;
        }

        /* Top Navbar */
        .top-navbar {
            background: #ffffff;
            padding: 10px 20px;
            border-bottom: 1px solid #dee2e6;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .toggle-btn {
            display: none;
            font-size: 1.5rem;
            cursor: pointer;
        }

        /* Cards */
        .card-dashboard {
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s;
            text-align: center;
            position: relative;
            padding-top: 40px;
        }

        .card-dashboard:hover {
            transform: translateY(-5px);
        }

        .card-dashboard h5 {
            font-size: 0.9rem;
            margin-bottom: 12px;
            font-weight: 600;
        }

        .card-dashboard i.card-icon {
            position: absolute;
            top: 15px;
            left: 15px;
            font-size: 1.5rem;
            color: #0d6efd;
        }

        /* Buttons inside cards */
        .card-dashboard .quick-action {
            margin-top: 15px;
        }

        /* Collapse Icon */
        .sidebar .nav-link[data-bs-toggle="collapse"] i.dropdown-icon {
            transition: transform 0.3s;
        }

        .sidebar .nav-link.collapsed i.dropdown-icon {
            transform: rotate(0deg);
        }

        .sidebar .nav-link:not(.collapsed) i.dropdown-icon {
            transform: rotate(90deg);
        }

        /* Floating Button */
        .floating-btn {
            position: fixed;
            left: 20px;
            bottom: 50px;
            z-index: 1050;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #0d6efd;
            color: #fff;
            font-size: 1.5rem;
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        /* Responsive */
        @media(max-width:992px) {
            .sidebar {
                left: -280px;
            }

            .sidebar.show {
                left: 0;
            }

            .sidebar .close-btn {
                display: block;
            }

            .content {
                margin-left: 0;
            }

            .toggle-btn {
                display: block;
                color: #0d6efd;
            }
        }
    </style>
</head>

<body>

    <!-- Left Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="close-btn text-end" id="close-btn"><i class="bi bi-x"></i></div>
        <div class="sidebar-brand">
            <img src="./assets/logo.jpg" alt="Logo">
            <h5>NAS President</h5>
        </div>
        <nav class="nav flex-column">
            <a class="nav-link" href="#"><i class="bi bi-house-fill"></i> Dashboard</a>
            <a class="nav-link collapsed" data-bs-toggle="collapse" href="#studentsSubmenu"><i class="bi bi-people-fill"></i> Manage Students <i class="bi bi-chevron-right dropdown-icon"></i></a>
            <div class="collapse submenu" id="studentsSubmenu">
                <a class="nav-link" href="#">Add Student</a>
                <a class="nav-link" href="#">View Students</a>
            </div>
            <a class="nav-link collapsed" data-bs-toggle="collapse" href="#programsSubmenu"><i class="bi bi-journal-text"></i> Manage Programs <i class="bi bi-chevron-right dropdown-icon"></i></a>
            <div class="collapse submenu" id="programsSubmenu">
                <a class="nav-link" href="#">Add Program</a>
                <a class="nav-link" href="#">View Programs</a>
            </div>
            <a class="nav-link collapsed" data-bs-toggle="collapse" href="#staffSubmenu"><i class="bi bi-person-badge-fill"></i> Manage Staff <i class="bi bi-chevron-right dropdown-icon"></i></a>
            <div class="collapse submenu" id="staffSubmenu">
                <a class="nav-link" href="#">Add Staff</a>
                <a class="nav-link" href="#">View Staff</a>
            </div>
            <a class="nav-link" href="#"><i class="bi bi-calendar-check-fill"></i> Enrollments</a>
            <a class="nav-link" href="#"><i class="bi bi-gear-fill"></i> Settings</a>
            <a class="nav-link" href="logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="content">
        <div class="top-navbar">
            <i class="bi bi-list toggle-btn" id="toggle-btn"></i>
            <span>Admin Dashboard</span>
        </div>

        <div class="container-fluid mt-4">

            <!-- First Row: Cards with Icons and Quick Actions -->
            <div class="row g-4 row-cols-1 row-cols-md-2 row-cols-xl-4">
                <div class="col">
                    <div class="card card-dashboard p-4">
                        <i class="bi bi-people-fill card-icon"></i>
                        <h5>Total Students</h5>
                        <h2>1,250</h2>
                        <button class="btn btn-sm btn-primary quick-action">View Students</button>
                    </div>
                </div>
                <div class="col">
                    <div class="card card-dashboard p-4">
                        <i class="bi bi-journal-text card-icon"></i>
                        <h5>Active Programs</h5>
                        <h2>8</h2>
                        <button class="btn btn-sm btn-primary quick-action">Manage Programs</button>
                    </div>
                </div>
                <div class="col">
                    <div class="card card-dashboard p-4">
                        <i class="bi bi-person-badge-fill card-icon"></i>
                        <h5>Staff Members</h5>
                        <h2>45</h2>
                        <button class="btn btn-sm btn-primary quick-action">Manage Staff</button>
                    </div>
                </div>
                <div class="col">
                    <div class="card card-dashboard p-4">
                        <i class="bi bi-calendar-check-fill card-icon"></i>
                        <h5>Enrollments</h5>
                        <h2>350</h2>
                        <button class="btn btn-sm btn-primary quick-action">View Enrollments</button>
                    </div>
                </div>
            </div>

            <!-- Second Row: Calendar and Alerts -->
            <div class="row g-4 mt-2">
                <div class="col-12 col-xl-6">
                    <div class="card card-dashboard p-3">
                        <h5>Calendar of Activities</h5>
                        <div id="calendar"></div>
                    </div>
                </div>
                <div class="col-12 col-xl-6">
                    <div class="card card-dashboard p-3">
                        <h5>Alerts</h5>
                        <div class="alert alert-primary">Enrollment deadline approaching</div>
                        <div class="alert alert-success">New program added</div>
                        <div class="alert alert-warning">Maintenance scheduled</div>
                        <div class="alert alert-danger">Server downtime alert</div>
                        <div class="alert alert-info">New event created</div>
                    </div>
                </div>
            </div>

            <!-- Third Row: Charts -->
            <div class="row g-4 mt-2">
                <div class="col-12 col-lg-6">
                    <div class="card card-dashboard p-3">
                        <h5>Enrollment Distribution</h5>
                        <canvas id="enrollmentPieChart"></canvas>
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="card card-dashboard p-3">
                        <h5>Enrollments Over Time</h5>
                        <canvas id="enrollmentLineChart"></canvas>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Floating Message Button -->
    <div class="floating-btn" data-bs-toggle="modal" data-bs-target="#messagesModal">
        <i class="bi bi-envelope-fill"></i>
    </div>

    <!-- Messages Modal -->
    <div class="modal fade" id="messagesModal" tabindex="-1" aria-labelledby="messagesModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="messagesModalLabel">Messages</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="background:#f1f3f5;">
                    <div style="display:flex; flex-direction:column; gap:12px;">

                        <!-- Message Example -->
                        <div style="display:flex; align-items:flex-start; gap:10px;">
                            <div style="width:40px; height:40px; background:#0d6efd; border-radius:50%; display:flex; align-items:center; justify-content:center; color:white; font-weight:bold;">TS</div>
                            <div style="background:#ffffff; border-radius:12px; padding:10px 12px; flex:1; box-shadow:0 2px 5px rgba(0,0,0,0.1);">
                                <div style="font-weight:600; font-size:0.9rem; display:flex; justify-content:space-between;">
                                    <span>Test Student 1</span>
                                    <span style="font-size:0.7rem; color:#6c757d;">10:30 AM</span>
                                </div>
                                <div style="font-size:0.85rem; margin-top:3px;">Enrollment confirmation received.</div>
                            </div>
                        </div>

                        <div style="display:flex; align-items:flex-start; gap:10px;">
                            <div style="width:40px; height:40px; background:#6c757d; border-radius:50%; display:flex; align-items:center; justify-content:center; color:white; font-weight:bold;">TS</div>
                            <div style="background:#ffffff; border-radius:12px; padding:10px 12px; flex:1; box-shadow:0 2px 5px rgba(0,0,0,0.1);">
                                <div style="font-weight:600; font-size:0.9rem; display:flex; justify-content:space-between;">
                                    <span>Test Student 2</span>
                                    <span style="font-size:0.7rem; color:#6c757d;">11:15 AM</span>
                                </div>
                                <div style="font-size:0.85rem; margin-top:3px;">Program inquiry.</div>
                            </div>
                        </div>

                        <div style="display:flex; align-items:flex-start; gap:10px;">
                            <div style="width:40px; height:40px; background:#198754; border-radius:50%; display:flex; align-items:center; justify-content:center; color:white; font-weight:bold;">AD</div>
                            <div style="background:#ffffff; border-radius:12px; padding:10px 12px; flex:1; box-shadow:0 2px 5px rgba(0,0,0,0.1);">
                                <div style="font-weight:600; font-size:0.9rem; display:flex; justify-content:space-between;">
                                    <span>Admin</span>
                                    <span style="font-size:0.7rem; color:#6c757d;">09:45 AM</span>
                                </div>
                                <div style="font-size:0.85rem; margin-top:3px;">Maintenance notification.</div>
                            </div>
                        </div>

                        <div style="display:flex; align-items:flex-start; gap:10px;">
                            <div style="width:40px; height:40px; background:#0dcaf0; border-radius:50%; display:flex; align-items:center; justify-content:center; color:white; font-weight:bold;">SA</div>
                            <div style="background:#ffffff; border-radius:12px; padding:10px 12px; flex:1; box-shadow:0 2px 5px rgba(0,0,0,0.1);">
                                <div style="font-weight:600; font-size:0.9rem; display:flex; justify-content:space-between;">
                                    <span>Student A</span>
                                    <span style="font-size:0.7rem; color:#6c757d;">12:20 PM</span>
                                </div>
                                <div style="font-size:0.85rem; margin-top:3px;">Payment receipt uploaded.</div>
                            </div>
                        </div>

                        <div style="display:flex; align-items:flex-start; gap:10px;">
                            <div style="width:40px; height:40px; background:#ffc107; border-radius:50%; display:flex; align-items:center; justify-content:center; color:white; font-weight:bold;">SB</div>
                            <div style="background:#ffffff; border-radius:12px; padding:10px 12px; flex:1; box-shadow:0 2px 5px rgba(0,0,0,0.1);">
                                <div style="font-weight:600; font-size:0.9rem; display:flex; justify-content:space-between;">
                                    <span>Student B</span>
                                    <span style="font-size:0.7rem; color:#6c757d;">01:05 PM</span>
                                </div>
                                <div style="font-size:0.85rem; margin-top:3px;">Request for transcript.</div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <input type="text" class="form-control" placeholder="Type a message..." style="flex:1;">
                    <button class="btn btn-primary ms-2">Send</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Sidebar toggle
        const toggleBtn = document.getElementById('toggle-btn');
        const sidebar = document.getElementById('sidebar');
        const closeBtn = document.getElementById('close-btn');
        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('show');
        });
        closeBtn.addEventListener('click', () => {
            sidebar.classList.remove('show');
        });

        // FullCalendar
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                height: 400,
                events: [{
                        title: 'Enrollment Deadline',
                        start: '2025-12-10',
                        color: '#0d6efd'
                    },
                    {
                        title: 'Staff Meeting',
                        start: '2025-12-15',
                        color: '#6c757d'
                    },
                    {
                        title: 'Orientation',
                        start: '2025-12-20',
                        color: '#198754'
                    },
                    {
                        title: 'Holiday',
                        start: '2025-12-25',
                        color: '#dc3545'
                    },
                    {
                        title: 'Maintenance',
                        start: '2025-12-22',
                        color: '#ffc107'
                    },
                    {
                        title: 'New Event',
                        start: '2025-12-30',
                        color: '#0dcaf0'
                    }
                ]
            });
            calendar.render();
        });

        // Charts
        var ctxPie = document.getElementById('enrollmentPieChart').getContext('2d');
        var enrollmentPieChart = new Chart(ctxPie, {
            type: 'pie',
            data: {
                labels: ['CSS NC II', 'EPS NC II', 'Driving NC II', 'Japanese LC II'],
                datasets: [{
                    data: [50, 30, 40, 20],
                    backgroundColor: ['#0d6efd', '#198754', '#ffc107', '#dc3545']
                }]
            },
            options: {
                responsive: true
            }
        });

        var ctxLine = document.getElementById('enrollmentLineChart').getContext('2d');
        var enrollmentLineChart = new Chart(ctxLine, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Enrollments',
                    data: [50, 60, 55, 70, 65, 80],
                    borderColor: '#0d6efd',
                    backgroundColor: 'rgba(13,110,253,0.2)',
                    tension: 0.3
                }]
            },
            options: {
                responsive: true
            }
        });
    </script>

</body>

</html>