<?php
    
    require('connect-db.php');
    require('db-logic.php');

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        if(!empty($_POST['signupBtn'])) {
            signUp($_POST['username'], $_POST['email'], $_POST['password']);
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Sign Up</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous"> 
    </head>
    <body>
        <div class="container" style="margin-top: 15px;">
            <div class="row col-xs-8">
                <h1 style="text-align:center">Sign Up</h1>
            </div>
            <div class="row justify-content-center">
                <div class="col-4">
                <form action="" method="post">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email"/>
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="username" class="form-control" name="username"/>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" name="password"/>
                    </div>
                        <button type="submit" class="btn btn-dark" name="signupBtn" value="submit sign up info">Sign Up</button>
                        <a class="btn btn-danger" href="index.php">Cancel</a>
                    </div>
                </form>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    </body>
</html>