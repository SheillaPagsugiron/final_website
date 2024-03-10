<?php
require_once "config.php"; // Make sure to include your database configuration file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['email'], $_POST['text'])) {
        $email = $_POST['email'];
        $comment = $_POST['text'];

        try {
            // Prepare the INSERT statement to insert into the 'comments' table
            $stmt = $link->prepare("INSERT INTO comments (email, comment) VALUES (?, ?)");
            $stmt->bind_param("ss", $email, $comment);
            $stmt->execute();

            // You can add additional logic or error handling here
            echo 'Comment stored successfully in the database!';
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
}
?>
