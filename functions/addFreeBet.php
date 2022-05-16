<?php 
// Include config file
require_once "config.php";

// Initialize the session
if (session_id() == "")
  session_start();

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    //Check all fields have a value
    if (empty($_POST['bookmaker']) || empty($_POST['profit']) || empty($_POST['date'])) {
        //Show Error message, could not save data
    }

    //Initialize post data
    $bookmaker = $_POST['bookmaker'];
    $profit = $_POST['profit'];
    $date = $_POST['date'];

    // Prepare a select statement to check if data is already in MySQL
    $sql = "SELECT bookmaker, time_created FROM freebets";
        
        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_bookmaker, $param_date);
            
            // Set parameters
            $param_bookmaker = $bookmaker;
            $param_date = $date;
            
            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if row data already exists
                if (mysqli_stmt_num_rows($stmt) == 1) {                    
                    
                    //Do whatever with this


                } else {
                    //Add data to table

                    // Prepare an insert statement
                    $inputSql = "INSERT INTO freebets (bookmaker, price, time_created) VALUES (?, ?, ?)";
         
                    if ($inputStmt = mysqli_prepare($link, $inputSql)) {
                        // Bind variables to the prepared statement as parameters
                        mysqli_stmt_bind_param($stmt, "sss", $param_bookmaker, $param_profit, $param_date);

                        // Set parameters
                        $param_bookmaker = $bookmaker;
                        $param_profit = $profit;
                        $param_date = $date;
            
                        // Attempt to execute the prepared statement
                        if (mysqli_stmt_execute($stmt)) {
                            // Success
                        } else { 
                            //Error Message
                            echo '<div class="alert alert-danger m-0"> Oops! Something went wrong. Please try again later. </div>';
                        }

                        // Close statement
                        mysqli_stmt_close($inputStmt);
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