<!-- Sidebar -->
<div class="sidebar">
    <div class="d-flex title-logo p-3">
        <a class="navbar-brand ps-3" href="#">
            <img src="image/dwcl-logo.png" alt="Logo" width="70" height="70" class="">
        </a>
        <h4 class="text-center p-3">DWCL</h4>
    </div>
    
    <ul class="nav flex-column">
        <li class="nav-item p-1">
            <a class="nav-link active" href="dashboard.php">
                <i class="fas fa-home"></i> Dashboard
            </a>
        </li>
        
        <!-- Inventory Collapsible -->
        <li class="nav-item p-1">
            <a class="nav-link" href="#inventoryCollapse" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="inventoryCollapse">
                <i class="fas fa-box"></i> Inventory 
                <i class="fas fa-chevron-down ms-auto" style="font-size:12px;"></i>
            </a>
            <ul class="collapse list-unstyled ms-4" id="inventoryCollapse">
                <li><a class="nav-link" href="item.php">Items/Equipments</a></li>
                <li><a class="nav-link" href="item-list.php">Inventory List</a></li>
            </ul>
        </li>

        <!-- Users Collapsible -->
        <li class="nav-item p-1">
            <a class="nav-link" href="#usersCollapse" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="usersCollapse">
                <i class="fas fa-users"></i> Users
                <i class="fas fa-chevron-down ms-auto" style="font-size:12px;"></i>
            </a>
            <ul class="collapse list-unstyled ms-4" id="usersCollapse">
                <li><a class="nav-link" href="user-list.php">User's List</a></li>
                <li><a class="nav-link" href="issuance-list.php">Issuance List</a></li>
                <li><a class="nav-link" href="appoint-user.php">Appoint User</a></li>
            </ul>
        </li>

        <!-- Department Nav Item -->
        <li class="nav-item p-1">
            <a class="nav-link" href="department-list.php">
                <i class="fas fa-building"></i> Department
            </a>
        </li>

        <!-- Requests Collapsible -->
        <li class="nav-item p-1">
            <a class="nav-link" href="#requestCollapse" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="requestCollapse">
                <i class="fas fa-envelope"></i> Requests 
                <i class="fas fa-chevron-down ms-auto" style="font-size:12px;"></i>
            </a>
            <ul class="collapse list-unstyled ms-4" id="requestCollapse">
                <li><a class="nav-link" href="incoming-inventory-request.php">Incoming Request</a></li>
                <li><a class="nav-link" href="request-list-admin.php">Request List</a></li>
                <li><a class="nav-link" href="requisition-form.php">Requisition Form</a></li>
            </ul>
        </li>

        <!-- Reports Nav Item  -->
        <li class="nav-item p-1">
            <a class="nav-link" href="reports.php">
                <i class="fas fa-file-alt"></i> Reports
            </a>
        </li>
       

        <!-- Logout Nav Item -->
        <li class="nav-item p-1">
            <a class="nav-link" href="backend/logout.php">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </li>
    </ul>
</div>
<!-- End Sidebar -->
