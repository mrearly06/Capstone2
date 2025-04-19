<?php



include "connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $departmentName = $_POST['departmentName'];
    $campus = $_POST['campus'];

    $sql = "INSERT INTO department (departmentName, campus) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ss", $departmentName, $campus);
        if ($stmt->execute()) {
            // Redirect with success status
            header("Location: ../department-list.php?status=success");
            exit();
        } else {
            // Redirect with error status
            header("Location: department-list.php?status=error");
            exit();
        }
        $stmt->close();
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
}
?>
