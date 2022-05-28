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
            <span> Withdrawals </span>
            <div id="table-buttons">
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
                        <input type="text" placeholder="Enter Amount" name="amount" value="'. $row['amount'] .'">
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
            <div id="table-buttons">
            <button class="button" onclick="editTable('transfers')">
                <i class="fa-solid fa-pen"></i>
            </button>
            <button class="button" onclick="addTransferTable('transfers', 'amount')">
                <i class="fa-solid fa-plus"></i>
            </button>
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
</section>

<?php
require "bottomNav.php";
?>