<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=
    , initial-scale=1.0">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Matched Betting</title>
</head>
<body>
    <!-- Top Nav -->
    <section id="topNav">
        <div id="navUser">
            User
            <div id="changeUsers" style="display;none;">
                <span> User 2 </span>
                <span> User 3 </span>
                <span> Add New User </span>
            </div>
        </div>
        <a href="profits.php">
            Profit: £1722
        </a>
    </section>

    <!-- Bottom Nav  -->
    <section id="bottomNav">
        <a href="#">
            <i class="fa-solid fa-house"></i>
        </a>
        <a href="add.php" id="addKey">
            <i class="fa-solid fa-plus"></i>
        </a>
        <a href="index.php">
            <i class="fa-solid fa-rotate-left"></i>
        </a>
    </section>

    <script src="js/index.js"></script> 
    <script>
        //Add Top Navigation event listeners
        document.getElementById('navUser').addEventListener("click", (event) => {
            showUsers();
        });
    </script>
</body>
</html>