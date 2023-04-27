<?php
session_start();

function signUp($username, $email, $password) {
    global $db;
    $usersQuery = "INSERT INTO users (username, email, password, karma) VALUES(:username, :email, :password, :karma)";

    $uStmt = $db->prepare($usersQuery); //users statement
    $uStmt->bindValue(":username",$username);
    $uStmt->bindValue(":email", $email);
    $uStmt->bindValue(":password",$password);
    $uStmt->bindValue(":karma",0);

    try {
        $uStmt->execute();
        $_SESSION['email'] = $email;
        $_SESSION['username'] = $username;
        $_SESSION['karma'] = 0;
        // Success
        echo "<div class='alert alert-success' style='margin-top:10px'>Successfully Signed Up!</div>";
        header("refresh:1;url=index.php");
    } catch (PDOException $e) {
        // Handle exception
        echo "Error: " . $e->getMessage();
    }
}

function login($email, $password) {
    global $db;
    //Find the matching email in the DB that the user input
    $query = "SELECT * FROM users WHERE email = :email";
    $stmt = $db->prepare($query);
    $stmt->bindValue(":email", $email);
    try {
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            // Verify password
            //Come back and use password_verify
            //Make a function to encrypt a password on sign up
            if ($password == $row['password']) {
                // Password is correct, set session variables
                $_SESSION['email'] = $row['email'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['karma'] = $row['karma'];
                echo "<div class='alert alert-success' style='margin-top:10px'>You are now logged in!</div>";
               header("refresh:1;url=index.php");
            } else {
                // Incorrect password
                echo "<div class='alert alert-danger' style='margin-top:10px'>Incorrect password. Please try again.</div>";
            }
        } else {
            // User not found
            echo "<div class='alert alert-danger' style='margin-top:10px'>User not found. Please check your email and try again.</div>";
        }
    } catch (PDOException $e) {
        // Handle exception
        echo "Error: " . $e->getMessage();
    }
}


function logOut() {
    session_unset();
    session_destroy();
    header("url=index.php;");
}
?>

