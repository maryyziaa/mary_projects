<?php
include 'connection.php';

$response = array();

// Error reporting for debugging (remove in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();
    $user_emailid = isset($_SESSION['user_emailid']) ? $_SESSION['user_emailid'] : null;

    if ($user_emailid) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["myfile"]["name"]);
        $uploadOk = 1;

        // Check if file already exists
        if (file_exists($target_file)) {
            $response['error'] = "File already exists.";
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["myfile"]["size"] > 5000000) {
            $response['error'] = "File is too large.";
            $uploadOk = 0;
        }

        // Allow only certain file formats
        $allowed_types = array("pdf", "docx");
        $file_extension = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        if (!in_array($file_extension, $allowed_types)) {
            $response['error'] = "Invalid file type. Allowed types: " . implode(", ", $allowed_types);
            $uploadOk = 0;
        }

        if ($uploadOk == 0) {
            $response['error'] = "Sorry, your file was not uploaded.";
        } else {
            // Try to move the uploaded file
            if (move_uploaded_file($_FILES["myfile"]["tmp_name"], $target_file)) {
                $file_name = $_FILES["myfile"]["name"];
                $file_path = $target_file;

                // Insert file information into the database
                $query = "INSERT INTO uploaded_files (user_emailid, file_name, file_path) VALUES (?, ?, ?)";
                $stmt = $connect->prepare($query);

                if ($stmt) {
                    $stmt->bind_param("sss", $user_emailid, $file_name, $file_path);

                    if ($stmt->execute()) {
                        $response['success'] = "The file " . htmlspecialchars($file_name) . " has been uploaded.";
                    } else {
                        $response['error'] = "Error storing file information in the database: " . $stmt->error;
                    }

                    $stmt->close();
                } else {
                    $response['error'] = "Error preparing statement: " . $connect->error;
                }
            } else {
                $response['error'] = "Sorry, there was an error uploading your file.";
            }
        }
    } else {
        $response['error'] = "User not logged in.";
    }
}

// Send the JSON-encoded response back to the client
echo json_encode($response);
?>
