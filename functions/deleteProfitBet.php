<?php 
// Include config file
require_once "../config.php";

// Initialize the session
if (session_id() == "")
  session_start();

if(!isset($_SESSION['activeUser']) || empty($_SESSION['activeUser'])) {
    $_SESSION['activeUser'] = "All";
}

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "GET") {

    //Check all fields have a value
    if (empty($_GET['bookmaker']) || empty($_GET['profit']) || empty($_GET['date'])) {
        //Show Error message, could not save data
    }

    //Initialize post data
    $bookmaker = $_GET['bookmaker'];
    $profit = $_GET['profit'];
    $date = $_GET['date'];
    $user = $_SESSION['activeUser'];

    
    //Add freebet to archived table
    // Prepare an insert statement
    $sql = "INSERT INTO profitbetsdeleted (bookmaker, profit, time_created, account) VALUES (?, ?, ?, ?)";
         
    if ($stmt = mysqli_prepare($link, $sql)) {
        
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "sdss", $param_bookmaker, $param_profit, $param_time_created, $param_account);

        // Set parameters
        $param_bookmaker = $bookmaker;
        $param_profit = $profit;
        $param_time_created = $date;
        $param_account = $user;

        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            // Success
            // Prepare a delete statement to delete old data from free bets table
            $sql = "DELETE FROM profitbets WHERE time_created = ?";
    
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