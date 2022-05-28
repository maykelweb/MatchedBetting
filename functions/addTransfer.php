<?php 
// Include config file
require_once "../config.php";

// Initialize the session
if (session_id() == "")
  session_start();

//Check active user is selected for transfer
if(!isset($_SESSION['activeUser']) || empty($_SESSION['activeUser'])) {
    //Error message and exit
    exit();
}

//Check active user is specific and not set to 'all'
if($_SESSION['activeUser'] == "All") {
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

    // Prepare a select statement to check if data is already in MySQL
    $sql = "SELECT time_created FROM transfers WHERE time_created = ?";
    
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
                    $sql = "UPDATE transfers SET amount = ? WHERE time_created = ?";
         
                    if ($stmt = mysqli_prepare($link, $sql)) {
                        
                        // Bind variables to the prepared statement as parameters
                        mysqli_stmt_bind_param($stmt, "d", $param_amount);

                        // Set parameters
                        $param_amount = $amount;

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
                    $sql = "INSERT INTO transfers (account, amount, time_created) VALUES (?, ?, ?)";
         
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