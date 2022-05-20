<?php 
// Include config file
require_once "../config.php";

// Initialize the session
if (session_id() == "")
  session_start();

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "GET") {

    //Check all fields have a value
    if (empty($_GET['profit']) || empty($_GET['date'])) {
        //Show Error message, could not save data
    }

    //Check profit is a number
    if (!is_numeric($_GET['profit'])) {
        //Show error message, profit entered was not a number
    }

    //Initialize post data
    $profit = $_GET['profit'];
    $date = $_GET['date'];

    // Prepare an update statement
    $sql = "UPDATE casino SET profit = ? WHERE time_created = ?";
         
    if ($stmt = mysqli_prepare($link, $sql)) {
        
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "ds", $param_profit, $param_time_created);

        // Set parameters
        $param_profit = $profit;
        $param_time_created = $date;

        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            // Success
            
        } else { 
            //Error Message
            echo '<div class="alert alert-danger m-0"> Oops! Something went wrong. Please try again later. </div>';
        }
        
        // Close statement
        mysqli_stmt_close($stmt);

    } else {
        //Error Message
        echo '<div class="alert alert-danger m-0"> Oops! Something went wrong. Please try again later. </div>';
    }
}

?>