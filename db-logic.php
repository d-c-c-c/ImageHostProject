<?php

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
?>