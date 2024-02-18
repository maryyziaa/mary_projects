<?php
$localhost = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "justcode";

// Create connection
$conn = new mysqli($localhost, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        .dashboard {
            display: flex;
            height: 100vh;
        }

        .sidebar {
            width: 200px;
            background-color: #333;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-between;
            padding-top: 20px;
        }

        .sidebar a {
            color: #fff;
            text-decoration: none;
            padding: 15px 0;
            text-align: center;
            width: 100%;
            display: block;
            cursor: pointer;
        }

        .main-content {
            flex: 1;
            padding: 20px;
        }

        .header {
            text-align: center;
            color: #333;
            font-size: 32px;
            font-weight: 800;
            margin-bottom: 20px;
        }

        .login-info,
        .uploadedfiles-info {
            display: none;
        }

        .icon-container {
            display: flex;
            flex-direction: column;
        }

        .icon {
            font-size: 16px;
            color: #fff;
            cursor: pointer;
            margin-bottom: 10px;
        }

        .icon:hover {
            background-color: #555;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #333;
            color: #fff;
        }
    </style>
</head>

<body>

    <div class="dashboard">
        <div class="sidebar">
            <div class="icon-container">
                <div class="icon" onclick="showLoginInfo()"><i class="fas fa-lock"></i> Login Information</div>
                <div class="icon" onclick="showUploadedfilesInfo()"><i class="fas fa-book"></i> Upload Information</div>
                <div class="icon" onclick="showtotalusersresourcesInfo()"><i class="fas fa-book"></i> Total Registration & Resources Count</div>
               

            </div>
        </div>

        <div class="main-content">
            <div class="header">ADMIN DASHBOARD</div>

            <div class="login-info">
                <?php
                $sql = "SELECT * FROM user_register";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                ?>
                    <h2>User Information</h2>
                    <table>
                        <tr>
                            <th>Username</th>
                            <th>Email ID</th>
                            <th>Password</th>
                        </tr>

                        <?php
                        while ($row = $result->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td>';
                            echo $row["username"];
                            echo '</td>';
                            echo '<td>';
                            echo $row["emailid"];
                            echo '</td>';
                            echo '<td>';
                            echo $row["password"];
                            echo '</td>';
                            echo '</tr>';
                        }
                        ?>
                    </table>
                <?php
                }
                ?>
            </div>

            <div class="uploadedfiles-info">
                <?php
                $sql = "SELECT * FROM uploaded_files";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                ?>
                <h2>User Uploaded Documents Information</h2>
                    <table>
                        <tr>
                            <th>User Email</th>
                            <th>File Name</th>
                            <th>File Path</th>
                            <th>Upload Date</th>
                        </tr>

                        <?php
                        while ($row = $result->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td>';
                            echo $row["user_emailid"];
                            echo '</td>';
                            echo '<td>';
                            echo $row["file_name"];
                            echo '</td>';
                            echo '<td>';
                            echo $row["file_path"];
                            echo '</td>';
                            echo '<td>';
                            echo $row["upload_date"];
                            echo '</td>';
                            echo '</tr>';
                        }
                        ?>
                    </table>
                <?php
                } else {
                    echo "<p>No uploaded documents found.</p>";
                }
                ?>
            </div>
            <div class="totalusersresources-info">
                <?php
                $sql = "SELECT * FROM tr1";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                ?>
                <h2>User Registration and Resource Count Info</h2>
                    <table>
                        <tr>
                            <th>Total Registered Users</th>
                            <th>Total Resources uploaded</th>
                        </tr>

                        <?php
                        while ($row = $result->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td>';
                            echo $row["total_registered_users"];
                            echo '</td>';
                            echo '<td>';
                            echo $row["total_resources_uploaded"];
                            echo '</td>';
                            echo '</tr>';
                        }
                        ?>
                    </table>
                <?php
                } else {
                    echo "<p>No users or resources found.</p>";
                }
                ?>
            </div>

        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
  
    <script>
         function showLoginInfo() {
        document.querySelector('.login-info').style.display = 'block';
        document.querySelector('.uploadedfiles-info').style.display = 'none';
        document.querySelector('.totalusersresources-info').style.display = 'none';
        }

    // Update the function name to match the one in the HTML
        function showUploadedfilesInfo() {
        document.querySelector('.login-info').style.display = 'none';
        document.querySelector('.uploadedfiles-info').style.display = 'block';
        document.querySelector('.totalusersresources-info').style.display = 'none';
        }

        function showtotalusersresourcesInfo() {
        document.querySelector('.login-info').style.display = 'none';
        document.querySelector('.uploadedfiles-info').style.display = 'none';  
        document.querySelector('.totalusersresources-info').style.display = 'block';
        }
    </script>


</body>

</html>
<?php
// Close the database connection
$conn->close();
?>



           