<?php
require "config.php";
require "header.php";
require "topNav.php";
?>
<section class="midSection">
    
    <h1 id="title"> Welcome <?php echo $_SESSION['activeUser'] ?> </h1>
        
    <div>
        <table id="freeBets">
            <thead>
                <tr>
                    <th>Bookmaker</th>
                    <th>Free Bet</th>
                </tr>
            </thead>
            <tbody>

            <?php 
            //Short table filter
            if ($_SESSION['activeUser'] == "All") { //If activeUser == All, show all bets
                //Prepare SQL statement
                $statement = $link->prepare("SELECT * FROM freebets");
            } else { //Otherwise limit table elements connected to the active user
                $statement = $link->prepare("SELECT * FROM freebets WHERE account = ?");
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
                        <input type="text" placeholder="Enter Bookmaker" name="bookmaker" value="'. $row['bookmaker'] .'">';

                        //Show linked account when viewing all
                        if ($_SESSION['activeUser'] == "All") {
                            echo '
                            <span class="account-hidden">'. $row['account'] .'</span>';
                        }
                echo'
                    <td>
                        <input type="text" placeholder="Enter Conditions" name="conditions" value="'. $row['conditions'] .'">
                        <input type="hidden" name="date" value="'. $row['time_created'] .'">
                    </td>
                </tr>'
                ;$total += $row['freebet'];
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
            <span> Free Bets </span>
            <div class="table-buttons">
            <button class="button" onclick="editTable('freeBets')">
                <i class="fa-solid fa-pen"></i>
            </button>
            <button class="button" onclick="addTable('freeBets', 'bookmaker', 'conditions')">
                <i class="fa-solid fa-plus"></i>
            </button>
            </div>
        </div>

        <script>
            //Add event listeners to every input
            document.getElementById('freeBets').querySelectorAll('input').forEach( input => {
                input.addEventListener("keyup", (event) => {
                    addInput(input);
                });
            });

            //Add event listeners to every tr
            document.getElementById('freeBets').querySelectorAll('tr').forEach( input => {
                input.addEventListener("change", (event) => {
                    addFreeBet(event);
                });
            });
        </script>
        
        <table id="profitBets">
            <thead>
                <tr>
                    <th>Bookmaker</th>
                    <th>Profit</th>
                </tr>
            </thead>
            <tbody>

            <?php 
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
            while ($row = $result->fetch_assoc()) //Loop through and display table data
            {
                echo '
                <tr>
                    <td>
                        <input type="text" placeholder="Enter Bookmaker" name="bookmaker" value="'. $row['bookmaker'] .'">
                        <input type="hidden" name="user" value="'. $row['account'] .'">
                    <td>
                        <input type="text" placeholder="Enter Profit" name="profit" value="£'. $row['profit'] .'">
                        <input type="hidden" name="date" value="'. $row['time_created'] .'">
                    </td>
                </tr>'
                ;$total += $row['profit'];
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
            <span> Profits </span>
            <div class="table-buttons">
            <button class="button" onclick="editTable('profitBets')">
                <i class="fa-solid fa-pen"></i>
            </button>
            <button class="button" onclick="addTable('profitBets', 'bookmaker', 'profit')">
                <i class="fa-solid fa-plus"></i>
            </button>
            </div>
        </div>

        <script>
            //Add event listeners to every input
            document.getElementById('profitBets').querySelectorAll('input').forEach( input => {
                input.addEventListener("keyup", (event) => {
                    addInput(input);
                });
            });

            //Add event listeners to every tr
            document.getElementById('profitBets').querySelectorAll('tr').forEach( input => {
                input.addEventListener("change", (event) => {
                    addProfitBets(event);
                });
            });
        </script>
    </div>

    <div id="bank-container">
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
            <button class="bank-button" onclick="editTable('bank')">
                <i class="fa-solid fa-pen"></i>
            </button>
            <button class="bank-button" onclick="addTable('bank', 'bookmaker', 'description')">
                <i class="fa-solid fa-plus"></i>
            </button>
            </div>
        </div>

        <?php
        //Statement to get all profits
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

        //Today
        $today = date("d-m-Y", strtotime('today'));

        // Total Profits Counter
        $profit_today = 0; 
        $profit_week = 0;

        //Loop through all bets
        while ($row = $result->fetch_assoc()) //Loop through and display table data
        {

            //String example: 27/05/2022:12:00:01
            $date = str_replace(",", "", $row['time_created']); //Remove , for space in date string
            $date = substr($date, 0, 10); //Remove everything after :
            $date = str_replace("/", "-", $date); //Remove / for - to work with datetime 
            $time_created = DateTime::createFromFormat('d-m-Y', $date)->format('d-m-Y');

            //Porift Today
            if ($today == $time_created) {
                $profit_today += $row['profit'];
            }

            //Profit Week
            $lastWeek = date("Y-m-d", strtotime('last week'));  
            if  ($time_created <= $lastWeek) {
                $profit_week += $row['profit'];
            }

            //Profit Month
            $lastMonth = date("Y-m-d", strtotime('last month'));
            if  ($time_created >= $lastMonth) {
                $profit_month += $row['profit'];
                echo $time_created . "   ";
            }
        }
        ?>

        <div id="profitGraph">
            <span>Profit Today: <?php echo $profit_today?></span>
            <span>Profit This Week: <?php echo $profit_week?></span>
            <span>Profit This Month: <?php echo $profit_month?></span>
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
</section>

<?php
require "bottomNav.php";
?>