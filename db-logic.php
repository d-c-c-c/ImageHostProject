<?php
session_start();

function signUp($username, $email, $password) {
    global $db;
    $profileQuery = "INSERT INTO profile (email, password) VALUES(:email, :password)";
    $usersQuery = "INSERT INTO users (username, karma) VALUES(:username, :karma)";

    $pStmt = $db->prepare($profileQuery);//profile statement
    $pStmt->bindValue(":email", $email);
    $pStmt->bindValue(":password",$password);

    $uStmt = $db->prepare($usersQuery); //users statement
    $uStmt->bindValue(":username",$username);
    $uStmt->bindValue(":karma",0);

    try {
        $pStmt->execute();
        $uStmt->execute();
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
    //PROBLEM: Email, is in profile table, username and password are in users table. It is inconvient to query the two
    //at best, and extremely difficuly at worst
    $query = "SELECT * FROM profile NATURAL JOIN users WHERE email = :email";
    $stmt = $db->prepare($query);
    $stmt->bindValue(":email", $email);
    echo $email;
    try {
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        // echo $row['email'];
        // echo $row['username'];
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

