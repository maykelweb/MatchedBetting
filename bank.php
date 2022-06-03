<?php
require "config.php";
require "header.php";
require "topNav.php";
?>
<section class="midSection">
    
    <h1 id="title"> Bank <?php echo $_SESSION['activeUser'] ?> </h1>
        
    <div>
        <table id="bank">
            <thead>
                <tr>
                    <th>Bookmaker</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>

            <?php 
            //Short table filter
            if ($_SESSION['activeUser'] == "All") { //If activeUser == All, show all bets
                //Prepare SQL statement
                $statement = $link->prepare("SELECT * FROM bank");
            } else { //Otherwise limit table elements connected to the active user
                $statement = $link->prepare("SELECT * FROM bank WHERE account = ?");
                $user = $_SESSION['activeUser'];
                $statement->bind_param("s", $user);
            }

            //Execute SQL statement
            $statement->execute();
            $result = $statement->get_result();

            $total = 0; //table total
            while ($row = $result->fetch_assoc()) //Loop through and display table data
            {
                echo '
                <tr>
                    <td>
                        <input type="text" placeholder="Enter Bookmaker" name="bookmaker" value="'. $row['bookmaker'] .'">
                    <td>
                        <input type="text" placeholder="Enter Amount" name="description" value="'. $row['description'] .'">
                        <input type="hidden" name="date" value="'. $row['time_created'] .'">
                    </td>
                </tr>'
                ;$total += $row['amount'];
            }?>
            
            </tbody>
            <tfoot>
                <tr>
                    <th>Total </th>
                    <td id="total"> £<?php echo $total ?> </td>
                </tr>
            </tfoot>
        </table>

        <div id="tableSettings">
            <span> Withdrawals </span>
            <div class="table-buttons">
            <button class="button" onclick="editTable('bank')">
                <i class="fa-solid fa-pen"></i>
            </button>
            <button class="button" onclick="addTable('bank', 'bookmaker', 'description')">
                <i class="fa-solid fa-plus"></i>
            </button>
            </div>
        </div>

        <script>
            //Add event listeners to every input
            document.getElementById('bank').querySelectorAll('input').forEach( input => {
                input.addEventListener("keyup", (event) => {
                    addInput(input);
                });
            });

            //Add event listeners to every tr
            document.getElementById('bank').querySelectorAll('tr').forEach( input => {
                input.addEventListener("change", (event) => {
                    addToBank(event);
                });
            });
        </script>
    </div>

    <div id="bank-container">
        <table id="transfers">
            <thead>
                <tr>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>

            <?php 
            //Short table filter
            if ($_SESSION['activeUser'] == "All") { //If activeUser == All, show all bets
                //Prepare SQL statement
                $statement = $link->prepare("SELECT * FROM transfers");
            } else { //Otherwise limit table elements connected to the active user
                $statement = $link->prepare("SELECT * FROM transfers WHERE account = ?");
                $user = $_SESSION['activeUser'];
                $statement->bind_param("s", $user);
            }

            //Execute SQL statement
            $statement->execute();
            $result = $statement->get_result();

            $total = 0; //table total
            while ($row = $result->fetch_assoc()) //Loop through and display table data
            {
                echo '
                <tr>
                    <td>
                        <input type="text" placeholder="Enter Amount" name="amount" value="£'. $row['amount'] .'">
                        <input type="hidden" name="date" value="'. $row['time_created'] .'">
                    </td>
                </tr>'
                ;$total += $row['amount'];
            }?>
            
            </tbody>
            <tfoot>
                <tr>
                    <td id="total">Total £<?php echo $total ?> </td>
                </tr>
            </tfoot>
        </table>

        <div id="tableSettings">
            <span> Sent </span>
            
            <div class="table-buttons">
            <button class="button" onclick="editTable('transfers')">
                <i class="fa-solid fa-pen"></i>
            </button>
            <button class="button" onclick="addTransferTable('transfers', 'amount')">
                <i class="fa-solid fa-plus"></i>
            </button>
            </div>
            <div id="time-filter">
            <a id="show-day">
                <i class="fa-solid fa-calendar-day"></i>
            </a>
            <a id="show-week">
                <i class="fa-solid fa-calendar-week"></i>
            </a>
            <a id="show-month">
                <i class="fa-solid fa-calendar-days"></i>
            </a>
            </div>
        </div>

        <script>
            //Add event listeners to every input
            document.getElementById('transfers').querySelectorAll('input').forEach( input => {
                input.addEventListener("keyup", (event) => {
                    addInput(input);
                });
            });

            //Add event listeners to every tr
            document.getElementById('transfers').querySelectorAll('tr').forEach( input => {
                input.addEventListener("change", (event) => {
                    addTransfer(event);
                });
            });
        </script>
    </div>

    <div>
        
        
        <?php
        //Show Daily Profit
        //Short table filter
        if ($_SESSION['activeUser'] == "All") { //If activeUser == All, show all bets
            //Prepare SQL statement
            $statement = $link->prepare("SELECT * FROM profitbets");
        } else { //Otherwise limit table elements connected to the active user
            $statement = $link->prepare("SELECT * FROM profitbets WHERE account = ?");
            $user = $_SESSION['activeUser'];
            $statement->bind_param("s", $user);
        }

        //Execute SQL statement
        $statement->execute();
        $result = $statement->get_result();

        $total = 0; //table total

        //Today
        $current_time = DateTime::createFromFormat('d-m-Y', '27-05-2022')->format('d-m-Y');
        while ($row = $result->fetch_assoc()) //Loop through and display table data
        {

            //String example: 27/05/2022:12:00:01
            $date = str_replace(",", "", $row['time_created']); //Remove , for space in, date string
            $date = substr($date, 0, 10); //Remove everything after :
            $date = str_replace("/", "-", $date); //Remove / for - to work with datetime
            $time_created = DateTime::createFromFormat('d-m-Y', $date)->format('d-m-Y');

            if ($current_time == $time_created) {
                echo '
                    <div>
                        <span>'. $row['bookmaker'] .'</span>
                        <span>£'. $row['profit'] .'</span>
                    </div>';
                $total += $row['profit'];
            }
            
        }
        echo $total;
        ?>
    </div>
</section>

<?php
require "bottomNav.php";
?>