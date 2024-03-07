<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="index.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@600&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">


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
?>
    <div class = "container">
    <form action="" method="post" class="form">



        <div class = "owner_information_container">
            <h2>Owner Information</h2>
            <input type="text" id="first_name" name="first_name" class = "firstname input" placeholder = "First Name" required ><br>
            <input type="text" id="last_name" name="last_name" class = "lastname input" placeholder = "Last Name" required><br>
            <input type="text" id="middle_name" name="middle_name" class = "middlename input" placeholder = "Middle Name" required><br>
            <input type="extended_name" id="extended_name" name="extended_name" class = "extended_name input" placeholder = "Extended Name" required><br>
            <input type="tel" id="phone_number" name="phone_number" class = "phone input" placeholder = "Phone Number" required><br>
            <input type="email" id="email" name="email" class = "email input" placeholder = "Email " required><br>
            <label for="appointment_date">Date of Birth:</label>
            <input type="date" id="DOB" name="DOB" class = "date" required><br>
            <input type="birthplace" id="birthplace" name="birthplace" class = "birthplace input" placeholder = "Birthplace" required><br>
            <input type="nationality" id="nationality" name="nationality" class = "nationality input" placeholder = "Nationality" required><br>
            <input type="marital_status" id="marital_status" name="marital_status" class = "marital_status input" placeholder = "Marital Status" required><br>
            <input type="blood_type" id="blood_type" name="blood_type" class = "blood_type input" placeholder = "Blood Type" required><br>
            <input type="address" id="address" name="address" class = "address input" placeholder = "Address" required><br>
        </div>
    



        <div class = "pet_information_container">
            <h2>Pet Information</h2>
            <input type="text" id="pet_name" name="pet_name" class = "petname input" placeholder = "Pet Name" required><br>
            <input type="text" id="species" name="species" class = "species input" placeholder = "Species" required><br>
            <input type="text" id="breed" name="breed" class = "breed input" placeholder = "Breed" required><br>
            <input type="number" id="age" name="age" class = "age input" placeholder = "Age" required><br>
            <label for="gender" class = "gender_label">Gender:</label>
            <select id="gender" name="gender" class = "gender input" required>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select><br>
        </div>



        <div class = "appointment_information_container">
            <h2>Appointment Information</h2>
            <label for="veterinarian" class = "vet_label">Veterinarian:</label>

            <select id="veterinarian" name="veterinarian" class = "veterinarian input" required>
                <?php
                $stmt = $conn->prepare("SELECT veterinarian_id, CONCAT(first_name, ' ', last_name) AS name FROM Veterinarians_tbl");
                $stmt->execute();
                $result = $stmt->get_result();
                while ($row = $result->fetch_assoc()) {
                    echo '<option value="' . $row['veterinarian_id'] . '">' . $row['name'] . '</option>';
                }
                ?>
            </select><br>

            <label for="appointment_date">Appointment Date:</label>
            <input type="date" id="appointment_date" name="appointment_date" class = "date" required><br>
            <label for="appointment_time">Appointment Time:</label>
            <input type="time" id="appointment_time" name="appointment_time" class = "time" required><br>
            <label for="service" class = "service_label">Service:</label>

            <select id="service" name="service" class = "service" required>

                <?php
                $stmt = $conn->prepare("SELECT service_id, name FROM Services_tbl");
                $stmt->execute();
                $result = $stmt->get_result();
                while ($row = $result->fetch_assoc()) {
                    echo '<option value="' . $row['service_id'] . '">' . $row['name'] . '</option>';
                }
                ?>
            </select><br>

            <label for="reason" class = "reason_label" >Reason:</label>
            <textarea id="reason" name="reason" required></textarea><br>

            <input type="submit" value="Submit" class = "button">
            </div>
        </form>

            <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "veterinary_db";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $stmt = $conn->prepare("INSERT INTO owners_tbl (first_name, last_name, phone_number, email, middle_name, DOB) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $first_name, $last_name, $phone_number, $email, $middle_name, $DOB);

        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $phone_number = $_POST['phone_number'];
        $email = $_POST['email'];
        $middle_name = $_POST['middle_name'];
        $DOB = $_POST['DOB'];
        $nationality = $_POST['nationality'];
        $marital_status = $_POST['marital_status'];
        $blood_type = $_POST['blood_type'];
        $extended_name = $_POST['extended_name'];
        $birthplace = $_POST['birthplace'];
        $address = $_POST['address'];
        $stmt->execute();

        $owner_id = $conn->insert_id;

        $stmt = $conn->prepare("INSERT INTO patients_tbl (name, species, breed, age, gender, owner_id) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssiss", $pet_name, $species, $breed, $age, $gender, $owner_id);

        $pet_name = $_POST['pet_name'];
        $species = $_POST['species'];
        $breed = $_POST['breed'];
        $age = $_POST['age'];
        $gender = $_POST['gender'];
        $stmt->execute();

        $patient_id = $conn->insert_id;

        $stmt = $conn->prepare("INSERT INTO appointments_tbl (patient_id, veterinarian_id, appointment_date, appointment_time, reason, service_id) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iissss", $patient_id, $veterinarian_id, $appointment_date, $appointment_time, $reason, $service_id);

        $veterinarian_id = $_POST['veterinarian'];
        $appointment_date = $_POST['appointment_date'];
        $appointment_time = $_POST['appointment_time'];
        $reason = $_POST['reason'];
        $service_id = $_POST['service'];
        $stmt->execute();

        $stmt = $conn->prepare("INSERT INTO invoices_tbl (appointment_id, date_created, service_id) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $appointment_id, $date_created, $service_id);
        $appointment_id = $conn->insert_id;

        $date_created = date("Y-m-d");
        $stmt->execute();

        echo "<p class = 'success'>Appointment successfully submitted!</p>";

        $stmt->close();
        $conn->close();
    }
    ?>
    </div>

    

</body>
</html>
