<?php
session_start();

//Check for active user changes
if (isset($_GET['activeUser'])) {
    $_SESSION['activeUser'] = $_GET['activeUser'];
}
?>

<body>
    <!-- Top Nav -->
    <section id="topNav">
        <div>
            <?php // Check activeUser is set or set it to all
                if(!isset($_SESSION['activeUser']) || empty($_SESSION['activeUser'])) {
                    $_SESSION['activeUser'] = "All";
                }
                //Active User
                echo "<span id='navUser'> ". $_SESSION['activeUser']. "</span>";
            ?>
            <input type="text" name="activeUser" value="<?php echo $_SESSION['activeUser'] ?>">
            <div id="changeUsers" style="display:none;">
                <?php
                    //Get list of all accounts
                    $query = "SELECT * FROM accounts";
                    $result = mysqli_query($link, $query);
                    if ($result->num_rows > 0) { //Display all accounts
                        while($row = $result->fetch_assoc()) {
                            if ($row['name'] != $activeUser) { //Don't show active user
                                echo '<span class="changeUser">'. $row["name"] .'</span>';
                            }
                        }
                    } else {
                        echo "<span> Add Account </span>";
                    }
                ?>
            </div>
        </div>
        <a href="profits.php">
            Profit: £1722
        </a>
    </section>
    
    <script>
        //Add Top Navigation event listeners
        document.getElementById('navUser').addEventListener("click", (event) => {
            showUsers();
        });

        //Change User Event Listener
        const users = document.querySelectorAll('.changeUser');
        const activeUser = document.querySelector("[name='activeUser']");
        users.forEach(user => {
            user.addEventListener('click', function handleClick(event) {
                $.ajax({
                    url: "index.php",
                    data: {
                        activeUser: event.target.innerText
                    },
                    success: function(){
                        // Success
                    },
                    error: function (request, status, error) {
                        // Error
                        alert("hereree");
                    }
                });
            });
        });
    </script>