<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <link rel="stylesheet" href="index.css">
    <style>
        .table-container {
            margin-bottom:  20px; /* Adjust the space between tables as needed */
        }
    </style>
</head>
<body>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "veterinary_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data from all tables
$tables = ['Owners_tbl', 'Patients_tbl', 'Appointments_tbl', 'Invoices_tbl'];

foreach ($tables as $table) {
    echo "<div class='table-container'>";
    echo "<h2>$table</h2>";
    $query = "SELECT * FROM $table";
    $result = $conn->query($query);

    if ($result === false) {
        // Check for errors in the SQL query
        echo "Error: " . $conn->error;
    } elseif ($result->num_rows >   0) {
        echo "<table border='1'>";
        // Output table header
        $row = $result->fetch_assoc();
        echo "<tr>";
        foreach ($row as $key => $value) {
            echo "<th>$key</th>";
        }
        echo "</tr>";
        // Output table data
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            foreach ($row as $value) {
                echo "<td>$value</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "0 results";
    }
    echo "</div>"; // Closing the div for each table
}

$conn->close();
?>

</body>
</html>
