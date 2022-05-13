<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=
    , initial-scale=1.0">
    <link rel="stylesheet" href="css/index.css">
    <title>Matched Betting</title>
</head>
<body>

    <h1> Matched Betting</h1>

    <section id="todo">
        <h2> Free Bets </h2>
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

          <div>
                <button class="button" onclick="addTable('todo')"> Add </button>
                <button class="button" onclick="editTable('todo', 'tododata')"> Edit </button>
                <button class="button" onclick="refreshTable('todo', 'tododata')"> Save </button>
          </div>
    </section>

    <!--  -->
    <section>
    </section>

    <script src="js/index.js"></script> 
</body>
</html>