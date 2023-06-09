<?php
// Remember to start the database server (or GCP SQL instance) before trying to connect to it
///////////////////////////////////////////

/** S23, PHP (on GCP, local XAMPP, or CS server) connect to MySQL (on local XAMPP) **/
$username = 'root';
$password = ''; #n8YrEtTVsU8QBhw
$host = 'localhost:3306';           // default phpMyAdmin port = 3306
$dbname = 'image_host';
$dsn = "mysql:host=$host;dbname=$dbname";
  
/** connect to the database **/
try 
{
//  $db = new PDO("mysql:host=$hostname;dbname=db-demo", $username, $password);
   $db = new PDO($dsn, $username, $password);
   
   // dispaly a message to let us know that we are connected to the database 
   //echo "<p>You are connected to the database: $dsn</p>";
}
catch (PDOException $e)     // handle a PDO exception (errors thrown by the PDO library)
{
   // Call a method from any object, use the object's name followed by -> and then method's name
   // All exception objects provide a getMessage() method that returns the error message 
   $error_message = $e->getMessage();        
   echo "<p>An Error Occurred while Connecting to the Database: $error_message </p>";
}
catch (Exception $e)       // handle any type of exception
{
   $error_message = $e->getMessage();
   echo "<p>Error Message: $error_message </p>";
}

?>