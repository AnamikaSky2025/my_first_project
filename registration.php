<?php
// Database connection details
$host = "localhost";
$dbname = "university_portal";
$username = "root";
$password = "";

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Collect form data
    $full_name = $_POST['Fullname'];
    $father_name = $_POST['Fathername'];
    $mother_name = $_POST['Mothername'];
    $student_id = $_POST['Studentid'];
    $email = $_POST['email'];
    $phone_number = $_POST['Pnumber'];
    $password = password_hash($_POST['Password'], PASSWORD_BCRYPT);
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $semester = $_POST['semester'];
    $department = $_POST['Department'];

    // Insert data into the database
    $sql = "INSERT INTO students (full_name, father_name, mother_name, student_id, email, phone_number, password, dob, gender, semester, department) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssssss", $full_name, $father_name, $mother_name, $student_id, $email, $phone_number, $password, $dob, $gender, $semester, $department);

    if ($stmt->execute()) {
        // Display a confirmation page
        echo "
        <!DOCTYPE html>
        <html lang='en'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Confirmation Page</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f4f4f4;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    height: 100vh;
                    margin: 0;
                }
                .confirmation-container {
                    background-color: white;
                    padding: 40px;
                    border-radius: 10px;
                    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
                    text-align: center;
                    width: 500px;
                }
                h2 {
                    margin-bottom: 20px;
                    color: #007bff;
                }
                p {
                    font-size: 16px;
                    margin-bottom: 10px;
                }
                button {
                    padding: 10px 20px;
                    background-color: #007bff;
                    color: white;
                    border: none;
                    border-radius: 5px;
                    font-size: 16px;
                    cursor: pointer;
                }
                button:hover {
                    background-color: #0056b3;
                }
            </style>
        </head>
        <body>
            <div class='confirmation-container'>
                <h2>Registration Successful!</h2>
                <p><strong>Full Name:</strong> $full_name</p>
                <p><strong>Father's Name:</strong> $father_name</p>
                <p><strong>Mother's Name:</strong> $mother_name</p>
                <p><strong>Student ID:</strong> $student_id</p>
                <p><strong>Email:</strong> $email</p>
                <p><strong>Phone Number:</strong> $phone_number</p>
                <p><strong>Date of Birth:</strong> $dob</p>
                <p><strong>Gender:</strong> $gender</p>
                <p><strong>Semester:</strong> $semester</p>
                <p><strong>Department:</strong> $department</p>
                <button onclick=\"location.href='Results.html'\">Go to CGPA Calculator</button>
            </div>
        </body>
        </html>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
