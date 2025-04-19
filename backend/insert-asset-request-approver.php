<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capture the form data
    $approverUserID = $_POST['approverUserID'];
    $approverRole = $_POST['approverRole'];

    // Include database connection
    include "connection.php";

    // Check if there is already an asset request approver in the table
    $checkSql = "SELECT COUNT(*) FROM asset_request_approver";
    if ($stmt = $conn->prepare($checkSql)) {
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();

        // If there is already an approver in the table, show an alert and do not insert
        if ($count > 0) {
            echo "<script>
                    alert('There is already an approver appointed.');
                    window.location.href = '../appoint-user.php'; // Redirect back to the appoint page
                  </script>";
        } else {
            // Prepare SQL query to insert into asset_request_approver
            $sql = "INSERT INTO asset_request_approver (assetRequestApproverID, assetRequestApprover, roleDescription) 
                    VALUES (NULL, ?, ?)";  // assuming assetRequestApproverID is auto-incremented

            if ($stmt = $conn->prepare($sql)) {
                // Bind parameters (integer for approverUserID, string for roleDescription)
                $stmt->bind_param("is", $approverUserID, $approverRole);

                // Execute the statement
                if ($stmt->execute()) {
                    // Success: Show alert and redirect to appoint-user.php
                    echo "<script>
                            alert('Approver has been successfully appointed.');
                            window.location.href = ../'appoint-user.php'; // Redirect back to the appoint page
                          </script>";
                } else {
                    echo "Error: " . $stmt->error;
                }

                // Close statement
                $stmt->close();
            } else {
                echo "Error preparing the statement.";
            }
        }
    }

    // Close the database connection
    $conn->close();
}
?>
