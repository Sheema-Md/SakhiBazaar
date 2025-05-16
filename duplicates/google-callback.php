/*<?php
require_once 'vendor/autoload.php';
require_once 'config.php';


session_start();

$client = new Google_Client();


if (isset($_GET['code'])) {
    // Fetch the access token using the authorization code
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);

    // Check if there is no error in the token responses
    if (!isset($token['error'])) {
        // Set the access token on the client
        $client->setAccessToken($token['access_token']);

        // Create OAuth2 service instance
        $oauth2 = new Google\Service\Oauth2($client);

        // Get the user's Google account information
        $google_account_info = $oauth2->userinfo->get();

        // Extract user information
        $email = $google_account_info->email;
        $name = $google_account_info->name;

        // Check if the email exists in the database
        $stmt = $conn->prepare("SELECT id, role FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // If user exists, get user details and assign them to session
            $stmt->bind_result($user_id, $role);
            $stmt->fetch();

            $_SESSION['user_id'] = $user_id;
            $_SESSION['role'] = $role;

            // Redirect based on user role
            header("Location: {$role}_dashboard.php");
            exit();
        } else {
            // If user does not exist, register them as a buyer by default
            $role = 'buyer'; // Default role
            $status = 'verified';

            // Insert the new user into the database
            $insert_stmt = $conn->prepare("INSERT INTO users (name, email, verification_code, status, role) VALUES (?, ?, '', ?, ?)");
            $insert_stmt->bind_param("ssss", $name, $email, $status, $role);
            $insert_stmt->execute();

            // Assign session variables
            $_SESSION['user_id'] = $insert_stmt->insert_id;
            $_SESSION['role'] = $role;

            // Redirect to buyer dashboard
            header("Location: buyer_dashboard.php");
            exit();
        }
    } else {
        // Handle authentication failure
        echo "Authentication failed: " . $token['error'];
    }
} else {
    // Handle the case when no code is received
    echo "No code received.";
}
?>
*/