<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: error_page.php");
    exit;
}
include 'db.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Admin Control</title>

    <!-- Fonts and Icons -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,700,900" rel="stylesheet" />
    <script src="vendor/jquery/jquery.min.js"></script> <!-- jQuery FIRST -->
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script> <!-- THEN Bootstrap -->

    <!-- Styles -->
    <link href="css/sb-admin-2.css" rel="stylesheet" />
    <link href="css/custom.css" rel="stylesheet" />
</head>

<body id="page-top" style="background-color: #212529;">
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav sidebar sidebar-dark bg-dark accordion" id="accordionSidebar">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="mx-3">Dashboard</div>
            </a>

            <hr class="sidebar-divider" />

            <li class="nav-item">
                <a class="nav-link" href="charts.php">
                    <i class="fas fa-calendar-check"></i>
                    <span>Analytics</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="dashboard_bookings.php">
                    <i class="fas fa-calendar-check"></i>
                    <span>Booking Management</span>
                </a>
            </li>

            <li class="nav-item ">
                <a class="nav-link" href="dashboard_events.php">
                    <i class="fas fa-calendar-alt"></i>
                    <span>Event Management</span>
                </a>
            </li>

            <li class="nav-item active">
                <a class="nav-link" href="privilege.php">
                    <i class="fas fa-user-shield"></i>
                    <span>Privilege</span>
                </a>
            </li>

            <hr class="sidebar-divider d-none d-md-block" />

            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include("includes/navbar.php"); ?>

                <!-- Page Content -->
                <div class="container-fluid ">
                    <h1 class="h3 mb-4 text-white">User Management</h1>

                    <!-- Tabs -->
                    <ul class="nav nav-tabs bg-dark p-2 rounded" id="userTabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link text-white active" id="admin-tab" data-toggle="tab" href="#admin" role="tab" style="background-color: transparent !important;">System Admins</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" id="users-tab" data-toggle="tab" href="#users" role="tab" style="background-color: transparent !important;">Site Users</a>
                        </li>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content mt-4" id="userTabsContent">

                        <!-- Admins Tab -->
                        <div class="tab-pane fade show active" id="admin" role="tabpanel">
                            <div class="card bg-dark text-white mb-4 shadow">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <span>System Admins</span>
                                    <a href="add_admin.php" class="btn btn-sm btn-primary">
                                        <i class="fas fa-plus"></i> Add Admin
                                    </a>
                                </div>
                                <div class="card-body p-0">
                                    <table class="table table-dark table-striped mb-0">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $stmt = $pdo->prepare("SELECT * FROM users WHERE role='admin'");
                                            $stmt->execute();
                                            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                            foreach ($users as $row) {
                                            ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($row['name']) ?></td>
                                                    <td><?= htmlspecialchars($row['email']) ?></td>
                                                    <td>
                                                        <a href="edit_admin.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                                                        <a href="delete_user.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger">Delete</a>
                                                    </td>
                                                </tr>
                                            <?php } ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Users Tab -->
                        <div class="tab-pane fade" id="users" role="tabpanel">
                            <div class="card bg-dark text-white shadow">
                                <div class="card-header">Site Users</div>
                                <div class="card-body p-0">
                                    <table class="table table-dark table-striped mb-0">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $stmt = $pdo->prepare("SELECT * FROM users WHERE role='user'");
                                            $stmt->execute();
                                            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                            foreach ($users as $row) {
                                            ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($row['name']) ?></td>
                                                    <td><?= htmlspecialchars($row['email']) ?></td>
                                                    <td><?= $row['status'] ?? 'active' ?></td>
                                                    <td>
                                                        <a href="edit_user.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                                                        <?php if (($row['status'] ?? 'active') === 'active') { ?>
                                                            <a href="block_user.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger">Block</a>
                                                        <?php } else { ?>
                                                            <a href="unblock_user.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-success">Unblock</a>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Footer -->
            <?php //include("includes/footer.php"); 
            ?>
        </div>
    </div>

    <!-- Scroll to Top -->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Scripts -->
    <script>
        $(document).ready(function() {
            function loadEvents() {
                const name = $('#filter-event-name').val();
                const category = $('#filter-event-category').val();

                $('#event-grid').html('<div class="col-12 text-white">Loading events...</div>');

                $.post('event_controller.php', {
                    name: name,
                    category: category
                }, function(data) {
                    $('#event-grid').html(data);
                });
            }

            // Initial load
            loadEvents();

            // Search button
            $('#btn-search-events').click(function() {
                loadEvents();
            });
        });
    </script>
    <script>
        $(document).on('click', '.btn-delete-event', function() {
            if (!confirm('Are you sure you want to delete this event?')) return;

            const btn = $(this);
            const eventId = btn.data('id');

            $.post('delete_event.php', {
                event_id: eventId
            }, function(res) {
                if (res.success) {
                    btn.closest('.col-md-4').fadeOut(300, function() {
                        $(this).remove();
                    });
                } else {
                    alert('Error: ' + res.message);
                }
            }, 'json').fail(function() {
                alert('Failed to connect to server.');
            });
        });
    </script>


    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>
    <script src="vendor/chart.js/Chart.min.js"></script>
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>
</body>

</html>