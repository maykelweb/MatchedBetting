<?php
require "config.php";
require "header.php";
require "topNav.php";
?>
<section id="casino">
        
    <h1> Casino </h1>

    <table>
        <thead>
            <tr>
                <th>Casino</th>
                <th>Expected Value</th>
            </tr>
        </thead>
        <tbody>

        <?php
        //Prepare statement to select all free bets
        $sql = "SELECT * FROM casino";
        $result = mysqli_query($link, $sql);

        //Loop through all rows and display data
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            echo '
            <tr>
                <td>
                    <input type="text" placeholder="Enter Bookie" name="casino" value='. $row['casino'] .'>
                <td>
                    <input type="text" placeholder="Enter Profits" name="ev" value='. $row['ev'] .'>
                    <input type="hidden" name="date" value='. $row['time_created'] .'>
                </td>
            </tr>'
            ;
        }
        ?>
                
        </tbody>
        <tfoot>
            <tr>
                <th>Total </th>
                <td id="total"> £0 </td>
            </tr>
        </tfoot>
    </table>

    <div id="table-buttons">
        <button class="button" onclick="editTable('casino', 'casinoData')">
            <i class="fa-solid fa-pen"></i>
        </button>
        <button class="button" onclick="addTable('casino', 'casino', 'ev')">
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
                addCasino(event);
            });
        });
    </script>
</section>

<?php
require "bottomNav.php";
?>