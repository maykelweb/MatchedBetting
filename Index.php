<?php
require "config.php";
require "header.php";
require "topNav.php";
?>
<section id="freeBets">
        
    <h1> Free Bets </h1>

    <table>
        <thead>
            <tr>
                <th>Bookies</th>
                <th>Free</th>
            </tr>
        </thead>
        <tbody>
                
        </tbody>
        <tfoot>
            <tr>
                <th>Total </th>
                <td id="total"> £0 </td>
            </tr>
        </tfoot>
    </table>

    <div id="table-buttons">
        <button class="button" onclick="editTable('freeBets', 'freeBetsData')">
            <i class="fa-solid fa-pen"></i>
        </button>
        <button class="button" onclick="addTable('freeBets')">
            <i class="fa-solid fa-plus"></i>
        </button>
    </div>
</section>

<script src="js/index.js"></script>
<script>
    //Load todo list
    const todoData = JSON.parse(localStorage.getItem("freeBetsData"));
    const todoTable = document.getElementById('freeBets').getElementsByTagName('tbody')[0];
    loadTable(todoTable, todoData); 
</script> 
<?php
require "bottomNav.php";
?>