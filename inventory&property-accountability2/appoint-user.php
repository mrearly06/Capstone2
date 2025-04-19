<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appoint Asset Requisition Approver for Department Head</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/sidebar-content.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <style>
        body, html {
            height: 100vh;
            overflow-y: auto;
        }
        .card {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<!-- Sidebar -->
<?php include "backend/session-sidebar.php"?>

<?php require "header.php"?>

<!-- Main content -->
<div class="main-content">
    <div class="content"> 
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb p-3">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Requisition Management</a></li>
                <li class="breadcrumb-item active" aria-current="page">Appoint Approver for Department Head</li>
            </ol>
        </nav>
        <div class="container-fluid mt-4">
            <div class="row justify-content-center">
                <!-- Card with col-6 -->
                <div class="col-12 col-md-6">
                    <div class="card p-3">
                        <div class="card-header">
                            <h4 class="mb-0">Appoint Asset Requisition Approver for Department Head</h4>
                        </div>
                        <div class="card-body">
                            <form id="appointApproverForm">
                                <div class="row">
                                    <?php     
                                        include "backend/connection.php";
                                        // Fetch users from the 'user' table
                                        $sql = "SELECT userID, firstName, middleName, lastName FROM user";
                                        $result = $conn->query($sql);

                                        $users = [];
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                $users[] = $row;
                                            }
                                        }

                                        $conn->close();
                                    ?>
                                    <!-- Approver dropdown input -->
                                    <div class="mb-3 col-12 col-md-12">
                                        <label for="approverName" class="form-label">Select Approver</label>
                                        <select id="approverName" class="form-select approverName" name="approverName" required>
                                            <option value="" disabled selected>Select approver</option>
                                            <?php
                                            if (!empty($users)) {
                                                foreach ($users as $user) {
                                                    $userName = $user['firstName'] . ' ' . $user['middleName'] . ' ' . $user['lastName'];
                                                    echo "<option value=\"{$user['userID']}\"> (UserID {$user['userID']}) {$userName} </option>";
                                                }
                                            }
                                            ?>
                                        </select>
                                        <input type="hidden" name="approverUserID" class="approverUserID">
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- Role Description text input -->
                                    <div class="mb-3 col-12 col-md-12">
                                        <label for="approverRole" class="form-label">Role Description</label>
                                        <input type="text" id="approverRole" class="form-control" name="approverRole" required placeholder="Enter role description">
                                    </div>
                                </div>
                                <div class="text-center mt-4">
                                    <button type="submit" class="btn btn-primary">Appoint Approver</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Add dynamic fetching logic for departmentHeadName and department if needed.
    });
</script>

</body>
</html>
