<?php 
// Include config file
require_once "../config.php";

// Initialize the session
if (session_id() == "")
  session_start();

if(!isset($_SESSION['activeUser']) || empty($_SESSION['activeUser'])) {
    //Error message and exit
    exit();
}

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "GET") {

    //Check all fields have a value
    if (empty($_GET['amount']) || empty($_GET['amount'])) {
        //Show Error message, could not save data
    }

    //Initialize post data
    $amount = $_GET['amount'];
    $date = $_GET['date'];
    $account = $_SESSION['activeUser'];

    //Add transfer to archive table
    // Prepare an insert statement
    $sql = "INSERT INTO deletedtransfers (account, amount, time_created) VALUES (?, ?, ?)";
         
    if ($stmt = mysqli_prepare($link, $sql)) {
        
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "sds", $param_account, $param_amount, $param_time_created);

        // Set parameters
        $param_account = $account;
        $param_amount = $amount;
        $param_time_created = $date;

        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            // Success
            // Prepare a delete statement to delete old data from free bets table
            $sql = "DELETE FROM transfers WHERE time_created = ?";
    
            if ($stmt = mysqli_prepare($link, $sql)) {
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "s", $param_time_created);
            
                // Set parameters
                $param_time_created = $date;
            
                // Attempt to execute the prepared statement
                if (mysqli_stmt_execute($stmt)) {
                    //Success
                } else {
                    //Error message, could not save data
                    echo '<div class="alert alert-danger"> Oops! Something went wrong. Please try again later. </div>';
                }

                 // Close statement
                mysqli_stmt_close($stmt);
            }
        } else { 
            //Error Message
            echo '<div class="alert alert-danger m-0"> Oops! Something went wrong. Please try again later. </div>';
        }
    }
}

?>