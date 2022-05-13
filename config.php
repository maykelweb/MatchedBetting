<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'Z0oUpJ9:Xi');
define('DB_NAME', 'bets');
 
// Attempt to connect to MySQL database 
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Initialize the session
session_start();
 
// Check connection
if($link === false){
    echo "<span id='serverError'> Could not connect to server </span>";
}
?>

<style>

#serverError {
    display: block;
    background: red;
    color: white;
    padding: 10px;
}

</style>