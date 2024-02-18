
<?php
session_start();
$localhost="127.0.0.1";
$username = "root";
$password = "";
$dbname = "justcode";

$conn = new mysqli($localhost, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $email = mysqli_real_escape_string($conn, $email);
    $password = mysqli_real_escape_string($conn, $password);

    $sql = "SELECT * FROM user_register WHERE emailid='$email'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Check if the entered password matches the password from the database
        if ($password == $row['password']) {
            
            echo "Login successful.";
            header("Location:http://127.0.0.1/JustCode/index2.html ");
            exit();
        
        } else {
            echo "Login failed. Invalid password.";
            exit();
        }
    } else 
    {
        echo "Login failed. User not found.";
        exit();
    }
}

$conn->close();
?>
