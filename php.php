<?php
// Check if form is submitted
if (isset($_POST['submit'])) {
    // File upload directory
    $targetDir = "uploads/";
    // Get the file name
    $fileName = basename($_FILES["file"]["name"]);
    // Set the file path
    $targetFilePath = $targetDir . $fileName;
    // Get the file extension
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    // Check if file is a valid image
    $allowTypes = array('jpg', 'jpeg', 'png', 'gif');
    if (in_array($fileType, $allowTypes)) {
        // Upload file to server
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {
            echo "The file " . $fileName . " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    } else {
        echo "Sorry, only JPG, JPEG, PNG, and GIF files are allowed.";
    }
}
?>

<?php
// Connect to MySQL database
$mysqli = new mysqli("localhost", "username", "password", "database_name");

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];

    // Validate email
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Insert email into database
        $sql = "INSERT INTO subscribers (email) VALUES ('$email')";
        if ($mysqli->query($sql) === TRUE) {
            echo "Thank you for subscribing!";
        } else {
            echo "Error: " . $sql . "<br>" . $mysqli->error;
        }
    } else {
        echo "Invalid email format";
    }
}

// Close MySQL connection
$mysqli->close();
?>
