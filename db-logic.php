<?php
session_start();


function buildDB() {
    global $db;
    query("create table if not exists users (
        username text not null,
        email text not null,
        password text not null,
        karma int not null default 0,
        primary key (username(255))
    );");

    query("create table if not exists posts (
        postID int not null auto_increment,
        like_tally int not null default 0,
        datetime_posted TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        image_data longblob,
        tag text not null,
        primary key (postID)
    );");

    query("create table if not exists votes (
        voteID text not null,
        postID int not null ,
        username text not null,
        vote int not null default 0,
        primary key (voteID(255))
    );");
}

function query($query, $bparam=null, ...$params) {
    global $db;
    $stmt = $db->prepare($query);

    if ($bparam != null)
        $stmt->bind_param($bparam, ...$params);

    if (!$stmt->execute()) {
        return false;
    }

    return true;
}

function newPost($imageData) {
    global $db;
    #$query = "INSERT INTO posts (like_tally, datetime_posted, image_data) VALUES (0, NOW(), $imageData)";
    #query($query);
    $like_tally = 0;
    $stmt = $db->prepare("INSERT INTO posts (like_tally, datetime_posted, image_data) VALUES (:like_tally, NOW(), :image_data)");
    $stmt->bindValue(":like_tally", $like_tally);
    $stmt->bindValue(":image_data", $imageData);
    $stmt->execute();
}

function getPosts() {
    global $db;
    $posts = $db->query("SELECT * FROM posts");
    return $posts->fetchAll(PDO::FETCH_ASSOC);
}

function deletePost($postID) {
    global $db;
    $stmt = $db->query("DELETE FROM posts WHERE postID = '$postID'");
    $stmt2 = $db->query("DELETE FROM votes WHERE postID = '$postID'");
}

function updateVotes($postID, $username, $vote) {
    global $db;
    $stmt = $db->prepare("INSERT INTO votes (voteID, postID, username, vote)
    VALUES (:voteID, :postID, :username, :vote)
    ON DUPLICATE KEY UPDATE vote = :vote");
    $stmt->bindValue(":voteID", $postID . '_' . $username);
    $stmt->bindValue(":postID", $postID);
    $stmt->bindValue(":username", $username);
    $stmt->bindValue(":vote", $vote); 
    $stmt->execute();
}

function getDisplayVotes() {
    global $db;
    $votes = $db->query("SELECT postID, sum(vote) as totalVotes FROM votes GROUP BY postID");
    return $votes->fetchAll(PDO::FETCH_ASSOC);
}

function getUserVotes($username) {
    global $db;
    $stmt = $db->query("SELECT postID, vote FROM votes WHERE username = '$username'");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function signUp($username, $email, $password) {
    global $db;
    $usersQuery = "INSERT INTO users (username, email, password, karma) VALUES(:username, :email, :password, :karma)";

    //TODO: create a function to verify a user's password is 8 characters long, has 1 upper case letter, 
    // 1 number and 1 special character

    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    $uStmt = $db->prepare($usersQuery); //users statement
    $uStmt->bindValue(":username",$username);
    $uStmt->bindValue(":email", $email);
    $uStmt->bindValue(":password",$hashed_password);
    $uStmt->bindValue(":karma",0);

    try {
        $uStmt->execute();
        $_SESSION['email'] = $email;
        $_SESSION['username'] = $username;
        $_SESSION['karma'] = 0;
        $_SESSION['isLoggedIn'] = true;
        // Success
        echo "<div class='alert alert-success' style='margin-top:10px'>Successfully Signed Up!</div>";
        header("refresh:1;url=home.php");
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
            
            if (password_verify($password, $row['password'])) {
                // Password is correct, set session variables
                $_SESSION['email'] = $row['email'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['karma'] = $row['karma'];
                $_SESSION['isLoggedIn'] = true;
                echo "<div class='alert alert-success' style='margin-top:10px'>You are now Logged In!</div>";
               header("refresh:1;url=home.php");
            } else {
                // Incorrect password
                echo "<div class='alert alert-danger' style='margin-top:10px'>Incorrect password. Please Try Again.</div>";
            }
        } else {
            // User not found
            echo "<div class='alert alert-danger' style='margin-top:10px'>User Not Found. Please Check Your email and Try Again.</div>";
        }
    } catch (PDOException $e) {
        // Handle exception
        echo "Error: " . $e->getMessage();
    }
}


function logOut() {
    //Check if there is an active session
    if (session_status() === PHP_SESSION_ACTIVE) {
        session_unset();
        session_destroy();
    }
    //Unset isLoggedIn variable so users not logged in can't create posts
    $_SESSION['isLoggedIn'] = false;
    header("Location: home.php");
}

buildDB();
?>

