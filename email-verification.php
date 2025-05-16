<?php
 $conn = new mysqli("localhost", "root", "", "sakhibazaar");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
    if (isset($_POST["verify_button"]))
    {
        $email = $_POST["email"];
        $verification_code = $_POST["otp"];
 
        // connect with database

        // mark email as verified
        $sql = "UPDATE users SET email_verified_at = NOW() WHERE email = '" . $email . "' AND verification_code = '" . $verification_code . "'";
        $result  = mysqli_query($conn, $sql);
 
        if (mysqli_affected_rows($conn) == 0)
        {
            die("Verification code failed.");
        }
 
        echo "E-mail verified";
        exit();
    }

 $conn->close();
?>