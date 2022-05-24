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
    if (empty($_GET['bookmaker']) || empty($_GET['description']) || empty($_GET['amount']) || empty($_GET['date'])) {
        //Show Error message, could not save data
    }

    //Initialize post data
    $bookmaker = $_GET['bookmaker'];
    $description = $_GET['description'];
    $amount = $_GET['amount'];
    $date = $_GET['date'];
    $user = $_SESSION['activeUser'];

    // Prepare a select statement to check if data is already in MySQL
    $sql = "SELECT time_created FROM bank WHERE time_created = ?";
    
        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_time_created);
            
            // Set parameters
            $param_time_created = $date;
            
            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if row data already exists
                if (mysqli_stmt_num_rows($stmt) == 1) {                    
                    //Table row already exists, update existing instead of insert new row

                    // Prepare an update statement
                    $sql = "UPDATE bank SET bookmaker = ?, `description` = ?, amount = ? WHERE time_created = ?";
         
                    if ($stmt = mysqli_prepare($link, $sql)) {
                        
                        // Bind variables to the prepared statement as parameters
                        mysqli_stmt_bind_param($stmt, "ssds", $param_bookmaker, $param_description, $param_amount, $param_time_created);

                        // Set parameters
                        $param_bookmaker = $bookmaker;
                        $param_description = $description;
                        $param_amount = $amount;
                        $param_time_created = $date;

            
                        // Attempt to execute the prepared statement
                        if (mysqli_stmt_execute($stmt)) {
                            // Success
                            
                        } else { 
                            //Error Message
                            echo '<div class="alert alert-danger m-0"> Oops! Something went wrong. Please try again later. </div>';
                        }
                    }

                } else { //Add data to table

                    // Prepare an insert statement
                    $sql = "INSERT INTO bank (bookmaker, `description`, amount, time_created, account) VALUES (?, ?, ?, ?, ?)";
         
                    if ($stmt = mysqli_prepare($link, $sql)) {
                        
                        // Bind variables to the prepared statement as parameters
                        mysqli_stmt_bind_param($stmt, "ssdss", $param_bookmaker, $param_description, $param_amount, $param_time_created, $param_account);

                        // Set parameters
                        $param_bookmaker = $bookmaker;
                        $param_description = $description;
                        $param_amount = $amount;
                        $param_time_created = $date;
                        $param_account = $user;
            
                        // Attempt to execute the prepared statement
                        if (mysqli_stmt_execute($stmt)) {
                            // Success
                            
                        } else { 
                            //Error Message
                            echo '<div class="alert alert-danger m-0"> Oops! Something went wrong. Please try again later. </div>';
                        }
                    }
                }
            } else {
                //Error message, could not save data
                echo '<div class="alert alert-danger"> Oops! Something went wrong. Please try again later. </div>';
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

?>