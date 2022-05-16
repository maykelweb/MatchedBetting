<?php 
// Include config file
require_once "../config.php";

// Initialize the session
if (session_id() == "")
  session_start();

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    //Check all fields have a value
    if (empty($_GET['bookmaker']) || empty($_GET['profit']) || empty($_GET['date'])) {
        //Show Error message, could not save data
    }

    //Initialize post data
    $bookmaker = $_GET['bookmaker'];
    $profit = $_GET['profit'];
    $date = $_GET['date'];

    // Prepare a select statement to check if data is already in MySQL
    $sql = "SELECT bookmaker, time_created FROM freebets WHERE bookmaker = ? && time_created = ?";
    
        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_bookmaker, $param_time_created);
            
            // Set parameters
            $param_bookmaker = $bookmaker;
            $param_time_created = $date;
            
            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if row data already exists
                if (mysqli_stmt_num_rows($stmt) == 1) {                    
                    //Table row already exists, update existing instead of insert new row

                    // Prepare an update statement
                    $sql = "UPDATE freebets SET price = ? WHERE bookmaker = ? && time_created = ?";
         
                    if ($stmt = mysqli_prepare($link, $sql)) {
                        
                        // Bind variables to the prepared statement as parameters
                        mysqli_stmt_bind_param($stmt, "sss", $param_rofit, $param_ookmaker, $param_ime_created);

                        // Set parameters
                        $param_ookmaker = $bookmaker;
                        $param_rofit = $profit;
                        $param_ime_created = $date;
            
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
                    $sql = "INSERT INTO freebets (bookmaker, price, time_created) VALUES (?, ?, ?)";
         
                    if ($stmt = mysqli_prepare($link, $sql)) {
                        
                        // Bind variables to the prepared statement as parameters
                        mysqli_stmt_bind_param($stmt, "sss", $param_b, $param_p, $param_t);

                        // Set parameters
                        $param_b = $bookmaker;
                        $param_p = $profit;
                        $param_t = $date;
            
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