<?php
// Assuming you have a connection to your database
include('connection.php');

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Initialize the response array
$response = ['success' => false, 'message' => 'An error occurred'];

// Query to get the latest control number
$query = "SELECT controlNo FROM asset_request_detail ORDER BY controlNo DESC LIMIT 1";
$result = mysqli_query($conn, $query);

if ($result) {
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        
        // Check and format the control number
        $latestControlNo = $row['controlNo'];
        if (preg_match('/^DW-\d+$/', $latestControlNo)) {
            $response = [
                'success' => true,
                'latestControlNo' => $latestControlNo
            ];
        } else {
            $response['message'] = 'Invalid control number format';
        }
    } else {
        $response['message'] = 'No control number found';
    }
} else {
    $response['message'] = 'Query failed: ' . mysqli_error($conn);
}

// Output the JSON response
header('Content-Type: application/json');
echo json_encode($response);

// Close the database connection
mysqli_close($conn);
?>
