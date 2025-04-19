<?php
// add_columns.php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Decode JSON data from the request body
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['fieldNames']) && is_array($data['fieldNames'])) {
        $fieldNames = $data['fieldNames'];

        // Database connection setup (replace with your actual DB connection details)
        $conn = new mysqli('localhost', 'username', 'password', 'database');

        // Check connection
        if ($conn->connect_error) {
            die(json_encode(['success' => false, 'message' => 'Database connection failed']));
        }

        // Start SQL query to add columns
        $query = "ALTER TABLE item ";

        // Loop through field names and create the SQL for each column
        $columns = [];
        foreach ($fieldNames as $field) {
            $sanitizedField = preg_replace('/[^a-zA-Z0-9_]/', '_', $field); // Sanitize field name to prevent SQL injection
            $columns[] = "ADD COLUMN `$sanitizedField` VARCHAR(255)"; // You can change VARCHAR(255) based on the expected data type
        }

        // Concatenate all column changes to a single query
        $query .= implode(", ", $columns);

        // Execute the query
        if ($conn->query($query) === TRUE) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error adding columns: ' . $conn->error]);
        }

        // Close the connection
        $conn->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid field names']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>
