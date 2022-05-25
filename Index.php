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
                        <input type="text" placeholder="Enter Bookmaker" name="bookmaker" value="'. $row['bookmaker'] .'">
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
            <button class="freebet-button" onclick="editTable('freeBets')">
                <i class="fa-solid fa-pen"></i>
            </button>
            <button class="freebet-button" onclick="addTable('freeBets', 'bookmaker', 'conditions')">
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
            <class id="table-buttons">
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
</section>

<?php
require "bottomNav.php";
?>