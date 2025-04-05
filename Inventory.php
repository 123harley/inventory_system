<?php
include('db.php');  // Include your DB connection

class Inventory {

    // Check if email exists
    public function checkEmailExists($email) {
        global $conn;

        $sql = "SELECT COUNT(*) FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();

        return $count > 0;  // If email exists, return true, else false
    }

    // Register Admin Account (only once)
    public function registerAdmin($email, $password) {
        global $conn;

        // Hash the password before storing it
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert the new admin account into the database
        $sql = "INSERT INTO users (email, password, role) VALUES (?, ?, 'admin')";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $email, $hashed_password);

        return $stmt->execute();
    }

    // Login function for admin
    public function login($email, $password) {
        global $conn;

        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            // Verify password
            if (password_verify($password, $user['password']) && $user['role'] == 'admin') {
                return [$user];  // Return user data if login is successful
            }
        }

        return [];  // Return empty if login fails
    }

    // Store the password reset token in the password_resets table
    public function storePasswordResetToken($email, $token) {
        global $conn;

        // SQL query to insert the reset token into the password_resets table
        $sql = "INSERT INTO password_resets (email, token, created_at) VALUES (?, ?, NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $email, $token);
        
        return $stmt->execute();  // Return true if insertion is successful
    }

    // Other methods you might have...
}
?>
