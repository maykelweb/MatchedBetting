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