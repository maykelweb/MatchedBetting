<?php
require "config.php";
require "header.php";
require "topNav.php";
?>
<section class="midSection">
        
    <div id="freeBets">
        <h1> Free Bets <?php echo $_SESSION['activeUser'] ?> </h1>

        <table>
            <thead>
                <tr>
                    <th>Bookies</th>
                    <th>Free Bet</th>
                </tr>
            </thead>
            <tbody>

            <?php
            //Prepare statement to select all free bets
            $sql = "SELECT * FROM freebets";
            $result = mysqli_query($link, $sql);
            $total = 0;

            //Loop through all rows and display data
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                echo '
                <tr>
                    <td>
                        <input type="text" placeholder="Enter Bookie" name="bookmaker" value="'. $row['bookmaker'] .'">
                    <td>
                        <input type="text" placeholder="Enter Conditions" name="conditions" value="'. $row['conditions'] .'">
                        <input type="hidden" name="date" value="'. $row['time_created'] .'">
                    </td>
                </tr>'
                ;
                $total += $row['profit'];
            }
            ?>
            
            </tbody>
            <tfoot>
                <tr>
                    <th>Total </th>
                    <td id="total"> £<?php echo $total ?> </td>
                </tr>
            </tfoot>
        </table>

        <div id="table-buttons">
            <button class="button" onclick="editTable('freeBets', 'freeBetsData')">
                <i class="fa-solid fa-pen"></i>
            </button>
            <button class="button" onclick="addTable('freeBets', 'bookmaker', 'conditions')">
                <i class="fa-solid fa-plus"></i>
            </button>
        </div>

        <script>
            //Add event listeners to every input
            document.body.querySelectorAll('input').forEach( input => {
                input.addEventListener("keyup", (event) => {
                    addInput(input);
                });
            });

            //Add event listeners to every tr
            document.body.querySelectorAll('tr').forEach( input => {
                input.addEventListener("change", (event) => {
                    addFreeBet(event);
                });
            });
        </script>
    </div>
</section>

<?php
require "bottomNav.php";
?>