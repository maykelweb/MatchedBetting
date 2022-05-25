<?php
require "config.php";
require "header.php";
require "topNav.php";
?>
<section class="midSection">
        
    <h1 id="title"> Casino Hub </h1>

    <div id="casino-container">

        <table id="casinoEV">
            <thead>
                <tr>
                    <th>Casino</th>
                    <th>Expected Value</th>
                </tr>
            </thead>
            <tbody>

            <?php 
            //Short table filter
            if ($_SESSION['activeUser'] == "All") { //If activeUser == All, show all bets
                //Prepare SQL statement
                $statement = $link->prepare("SELECT * FROM casino WHERE profit IS NULL");
            } else { //Otherwise limit table elements connected to the active user
                $statement = $link->prepare("SELECT * FROM casino WHERE account = ?, profit IS NULL");
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
                        <input type="text" placeholder="Enter Casino" name="casino" value="'. $row['casino'] .'">
                    <td>
                        <input type="text" placeholder="Enter Expected Value" name="Expected Value" value="'. $row['description'] .'">
                        <input type="hidden" name="date" value="'. $row['time_created'] .'">
                    </td>
                </tr>'
                ;$total += $row['ev'];
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
            <button class="freebet-button" onclick="editTable('casinoEV')">
                <i class="fa-solid fa-pen"></i>
            </button>
            <button class="freebet-button" onclick="addTable('casinoEV', 'casino', 'Expected Value')">
                <i class="fa-solid fa-plus"></i>
            </button>
            </div>
        </div>
    </div>

    <script>
        //Add event listeners to every input
        document.getElementById('casinoEV').querySelectorAll('input').forEach( input => {
            input.addEventListener("keyup", (event) => {
                addInput(input);
            });
        });

        //Add event listeners to every tr
        document.getElementById('casinoEV').querySelectorAll('tr').forEach( input => {
            input.addEventListener("change", (event) => {
                addCasino(event);
            });
        });
    </script>
</section>

<?php
require "bottomNav.php";
?>