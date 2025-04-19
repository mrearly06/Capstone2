<?php
// Assuming you have a database connection file
include 'backend/connection.php';

// Fetch asset details and total costs, grouped by month and receivedBy
$query = "
    SELECT 
        DATE_FORMAT(i.date, '%Y-%m') AS month,
        CONCAT(u.lastName, ' ', u.firstName, ', ', u.middleName) AS receivedBy,
        SUM(i.amount) AS totalCost,
        COUNT(i.issuanceID) AS totalAssets
    FROM issuance i
    JOIN user u ON i.receivedBy = u.userID
    GROUP BY month, i.receivedBy
    ORDER BY month DESC
";


$result = mysqli_query($conn, $query);

$months = [];
$receivedBy = [];
$totalAssets = [];
$totalCosts = [];

while ($row = mysqli_fetch_assoc($result)) {
    $months[] = $row['month'];
    $receivedBy[] = $row['receivedBy'];
    $totalAssets[] = $row['totalAssets'];
    $totalCosts[] = $row['totalCost'];
}

// Encode data to JSON
$months_json = json_encode(array_reverse($months));  
$receivedBy_json = json_encode(array_reverse($receivedBy));  // Store receivedBy data
$totalAssets_json = json_encode(array_reverse($totalAssets));
$totalCosts_json = json_encode(array_reverse($totalCosts));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monthly Asset Report</title>

    <!-- Custom Styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <style>
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 250px;
            background-color: #343a40;
            color: #fff;
            transition: all 0.3s;
            overflow-y: auto;
        }
        .sidebar .nav-link {
            color: #fff;
        }
        .sidebar .nav-link:hover {
            background-color: #495057;
            color: #fff;
        }
        .sidebar .nav-item.active .nav-link {
            background-color: #007bff;
        }
        .main-content {
            margin-left: 250px;
            transition: margin-left 0.3s;
            background-color: rgb(240,240,240);
            height: 100vh;
        }
        .sidebar-collapse .main-content {
            margin-left: 0;
        }
        .card {
            background-color: #fff;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            background-color: #f1f3f5;
        }
        .container {
            padding: 80px;
        }
    </style>
</head>
<body>
<div class="main-content">
    <!-- Sidebar Section -->
    <?php include "backend/session-sidebar.php"; ?>

    <!-- Header Section -->
    <?php require "header.php"; ?>

    <!-- Main Content Section -->
    <div class="container">
        <h2>Monthly Report</h2>

            <div class="export-btn d-flex justify-content-end mb-3 gap-2">
                <!-- Button to trigger CSV export -->
                <button class="btn btn-primary" id="export-csv-btn">Export to CSV</button>
                <button class="btn btn-primary btn-pdf">Export to PDF</button>
                <button class="btn btn-primary btn-word">Export to Word</button>
            </div>

        <div class="row">
            <div class="col-12 col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Assets Added per Month</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="assetsChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Total Cost per Month</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="costChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Monthly User Summary Table with Received By -->
        <div class="card mt-4">
            <div class="card-header">
                <h5>Monthly Asset, Cost and Received By Summary</h5>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Month</th>
                            <th>User</th>
                            <th>Total Assets</th>
                            <th>Total Cost ($)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($months as $index => $month): ?>
                            <tr>
                                <td><?php echo $month; ?></td>
                                <td><?php echo $receivedBy[$index]; ?></td>
                                <td><?php echo $totalAssets[$index]; ?></td>
                                <td><?php echo number_format($totalCosts[$index], 2); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Footer Section -->
    <footer class="text-center">
        <p>Report generated on: <span id="report-time"></span></p>
    </footer>

    <!-- JavaScript for Charts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Data from PHP
        const months = <?php echo $months_json; ?>; // Months
        const totalAssets = <?php echo $totalAssets_json; ?>; // Total assets
        const totalCosts = <?php echo $totalCosts_json; ?>; // Total costs

        // Assets Added per Month Chart
        const ctx1 = document.getElementById('assetsChart').getContext('2d');
        const assetsChart = new Chart(ctx1, {
            type: 'line',
            data: {
                labels: months, // Months as labels
                datasets: [{
                    label: 'Assets Added',
                    data: totalAssets, // Total assets as data
                    borderColor: '#007bff',
                    fill: false
                }]
            }
        });

         // Total Cost per Month Chart (Bar Graph)
   
        const ctx2 = document.getElementById('costChart').getContext('2d');
        const costChart = new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: months, // Months as labels
                datasets: [{
                    label: 'Total Cost ($)',
                    data: totalCosts, // Total costs as data
                    backgroundColor: '#ff9f40',
                    borderColor: '#ff6347',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Total Cost ($)'
                        }
                    }
                }
            }
        });


        // Display Report Time
        document.getElementById('report-time').innerHTML = new Date().toLocaleString();
    </script>

<script>
    document.getElementById("export-csv-btn").addEventListener("click", function() {
        // Redirect to the PHP script that generates the CSV
        window.location.href = "backend/export_csv.php"; // Assuming export_csv.php contains the PHP code
    });
</script>

<script>

function sendChartAsImage() {
    const assetsChartImage = assetsChart.toBase64Image();
    const costChartImage = costChart.toBase64Image();

    return fetch('backend/save-chart-images.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
            assetsChart: assetsChartImage,
            costChart: costChartImage
        })
    })
    .then(response => response.json());
}
document.querySelector('.btn-pdf').addEventListener('click', () => {
    sendChartAsImage().then(() => {
        window.location.href = 'backend/export-pdf.php'; // Trigger PDF generation after saving images
    });
});

</script>

<script>
document.querySelector('.btn-word').addEventListener('click', () => {
    sendChartAsImage().then(() => {
        // Programmatically send the POST request to export-docu.php
        const formData = new FormData();
        formData.append("export-docu", true);

        fetch('backend/export-docu.php', {
            method: 'POST',
            body: formData,
        })
        .then(response => {
            if (!response.ok) {
                throw new Error("Failed to generate the Word document");
            }
            return response.blob();
        })
        .then(blob => {
            // Create a download link for the user
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement("a");
            a.href = url;
            a.download = "Report.docx";  // Set the default filename for download
            a.click();
            window.URL.revokeObjectURL(url); // Clean up the URL object
        })
        .catch(error => {
            console.error("Error exporting Word document:", error);
            alert("Failed to download the Word document. Please try again.");
        });
    }).catch(() => {
        alert("Failed to process charts. Please try again.");
    });
});

</script>
</body>
</html>
