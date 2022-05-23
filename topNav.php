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
            <form id="changeUserForm" action="">
                <input type="hidden" name="activeUser" value="<?php echo $_SESSION['activeUser'] ?>">
            </form>
            <ul id="changeUsers" style="display:none;">
                <?php
                    //Get list of all accounts
                    $query = "SELECT * FROM accounts";
                    $result = mysqli_query($link, $query);
                    if ($result->num_rows > 0) { //Display all accounts
                        while($row = $result->fetch_assoc()) {
                            if ($row['name'] != $_SESSION['activeUser']) { //Don't show active user
                                echo '<li class="changeUser">'. $row["name"] .'</li>';
                            }
                        }
                        //Add 'All' option at end
                        
                        if ("All" != $_SESSION['activeUser']) { //If not already viewing All
                            echo '<li class="changeUser"> All </li>';
                        }
                    } else {
                        //No Accounts
                        echo "<li> Add Account </li>";
                    }
                ?>
            </ul>
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

        //Initialize user variables
        const users = document.querySelectorAll('.changeUser');
        const form = document.getElementById('changeUserForm');
        const activeUser = document.querySelector("[name='activeUser']");

        //Change User Event Listener
        users.forEach(user => { //Add event listener to every user list
            user.addEventListener('click', function handleClick(event) { //On click
                activeUser.value = event.target.innerText //change active user input value
                form.submit(); //reload page and change active user
            });
        });
    </script>