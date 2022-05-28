/* Add a new cell to the table */
function addTable(t, r1, r2) {
    //Get table
    const table = document.getElementById(t).getElementsByTagName('tbody')[0];

    // Insert a row at the end of table
    var newRow = table.insertRow();

    // Insert a cell at the end of the row
    var row1 = newRow.insertCell();
    var row2 = newRow.insertCell();

    //Create input node 1
    var inputA = document.createElement("input");
    inputA.type = "text";
    inputA.placeholder = "Enter " + r1.charAt(0).toUpperCase() + r1.slice(1); //Short code to uppercase first character 
    inputA.setAttribute("name", r1);

    //add Event listeners to automatically add data into table
    inputA.addEventListener("keyup", (event) => { 
        addInput(inputA);
    });
    
    //Create input node 2
    var inputB = document.createElement("input");
    inputB.type = "text";
    //Uppercase first letter in name
    inputB.placeholder = "Enter " + r2.charAt(0).toUpperCase() + r2.slice(1);
    inputB.setAttribute("name", r2);
    
    //Add event listeners
    inputB.addEventListener("keyup", (event) => {
        addInput(inputB);
    });

    //Create Hidden Date field
    var inputD = document.createElement("input");
    inputD.setAttribute("type", "hidden");
    inputD.setAttribute("name", "date");
    inputD.setAttribute("value", new Date().toLocaleString().replace(/ /g, ":"));

    //Listen to row changes
    newRow.addEventListener('change', (event) => {
        //Change command depending on table
        switch(t) {
            case "freeBets":
                addFreeBet(event);
                break;
            case "profitBets":
                addProfitBets(event);
                break;
            case "bank":
                addToBank(event);
                break;
            case "casinoEV":
                addCasino(event);
                break;
        }
    });

    // Append an input node to the cell
    row1.appendChild(inputA);
    row2.appendChild(inputB);
    row2.appendChild(inputD);
}

function addTransferTable(t, r) {
    //Get table
    const table = document.getElementById(t).getElementsByTagName('tbody')[0];

    // Insert a row at the end of table
    var newRow = table.insertRow();

    // Insert a cell at the end of the row
    var row = newRow.insertCell();

    //Create amount row
    var inputA = document.createElement("input");
    inputA.type = "text";
    inputA.placeholder = "Enter " + r.charAt(0).toUpperCase() + r.slice(1); //Short code to uppercase first character 
    inputA.setAttribute("name", r);

    //add Event listeners to automatically add data into table
    inputA.addEventListener("keyup", (event) => { 
        addInput(inputA);
    });

    //Create Hidden Date field
    var inputD = document.createElement("input");
    inputD.setAttribute("type", "hidden");
    inputD.setAttribute("name", "date");
    inputD.setAttribute("value", new Date().toLocaleString().replace(/ /g, ":"));

    //Listen to row changes
    newRow.addEventListener('change', (event) => {
        //Add changed table to mySQL
        addTransfer(event);
    });

    // Append an input node to the cell
    row.appendChild(inputA);
    row.appendChild(inputD);
}

//Function to validate free bets table and add new inputs to MySQL
function addFreeBet(e) {
    //Get the active row
    const row = e.target.parentElement.parentElement;
    
    //Get row data
    const bookmaker = row.querySelector("[name='bookmaker']").value;
    const conditions = row.querySelector("[name='conditions']").value;
    const date = row.querySelector("[name='date']").value;
    var freebet;
    
    //Check input for £ as Key for value
    try { //Try to find £ value indicator
        const words = conditions.split('£'); //Split at the £
        const value = words[1].split(' '); //Split again to get only the first word
        freebet = value[0]; //This is the value
    } catch (e) { //If no £ sign, set profit to 0
        freebet = 0;
    }

    if (bookmaker != "" && conditions != "" && date != "") {
        //Ajax request to save data into MySQL
        $.ajax({
            url: "functions/addFreeBet.php",
            data: {bookmaker: bookmaker,
                   condition: conditions,
                   freebet: freebet,
                   date: date
                },
            success: function(){
                // Success refresh windows
                location.reload();
            },
            error: function (request, status, error) {
                alert("Could not save data:");
                //Show error message could not save data
            }
        });
    }
}

//Function to validate profit bets table and add new inputs to MySQL
function addProfitBets(e) {
    const row = e.target.parentElement.parentElement;

    const bookmaker = row.querySelector("[name='bookmaker']").value;
    const profit = row.querySelector("[name='profit']").value.replace(/£/g, " "); //remove £ sign from value
    const date = row.querySelector("[name='date']").value;

    console.log(profit)

    if (bookmaker != "" && profit != "" && date != "") {
        //Ajax request to save data into MySQL
        $.ajax({
            url: "functions/addProfitBet.php",
            data: {bookmaker: bookmaker,
                   profit: profit,
                   date: date
                },
            success: function(){
                // Success refresh window
                location.reload();
            },
            error: function (request, status, error) {
                alert("Could not save data:");
                //Show error message could not save data
            }
        });
    }
}

//Function to validate bank transfer table and add new inputs to MySQL
function addToBank(e) {
    const row = e.target.parentElement.parentElement;

    const bookmaker = row.querySelector("[name='bookmaker']").value;
    const description = row.querySelector("[name='description']").value;
    const date = row.querySelector("[name='date']").value;
    var amount;

    //Check profit input for number value
    try { //Try to find £ value indicator
        const words = description.split('£'); //Split at the £
        const value = words[1].split(' '); //Split again after first space
        amount = value[0];
    } catch (e) { //If no value, set profit to 0
        amount = 0;
    }

    if (bookmaker != "" && description != "" && date != "") {
        //Ajax request to save data into MySQL
        $.ajax({
            url: "functions/addToBank.php",
            data: {bookmaker: bookmaker,
                   description: description,
                   amount: amount,
                   date: date
                },
            success: function(){
                // Success refresh windows
                location.reload();
            },
            error: function (request, status, error) {
                alert("Could not save data:");
                //Show error message could not save data
            }
        });
    }
}

//Add casino table data to mysql
function addCasino(e) {
    const row = e.target.parentElement.parentElement;

    const casino = row.querySelector("[name='casino']").value;
    const description = row.querySelector("[name='Expected Value']").value;
    const date = row.querySelector("[name='date']").value;
    var ev;

    //Check profit input for number value
    try { //Try to find £ value indicator
        const words = description.split('£'); //Split at the £
        const value = words[1].split(' '); //Split again after first space
        ev = value[0];
    } catch (e) { //If no value, set profit to 0
        ev = 0;
    }

    if (casino != "" && description != "" && date != "") {
        //Ajax request to save data into MySQL
        $.ajax({
            url: "functions/addCasino.php",
            data: {casino: casino,
                   description: description,
                   ev: ev,
                   date: date
                },
            success: function(){
                // Success refresh windows
                location.reload();
            },
            error: function (request, status, error) {
                alert("Could not save data:");
                //Show error message could not save data
            }
        });
    }
}

function addTransfer(e) {
    const row = e.target.parentElement.parentElement;

    const amount = row.querySelector("[name='amount']").value;
    const date = row.querySelector("[name='date']").value;

    if (amount != "" && date != "") {
        //Ajax request to save data into MySQL
        $.ajax({
            url: "functions/addTransfer.php",
            data: {amount: amount,
                   date: date
                },
            success: function(){
                // Success refresh windows
                location.reload();
            },
            error: function (request, status, error) {
                alert("Could not save data:");
                //Show error message could not save data
            }
        });
    }
}

//Add remove buttons to each table list
function editTable(t) {
    //Get all table rows
    const table = document.getElementById(t).querySelectorAll('tbody tr');

    //Add remove button for each row
    table.forEach((e) => {
        //Create remove button
        var div = document.createElement("div");
        div.classList.add("list-remove");
        div.innerText = "x";

        //Check which table this relates to and add onclick function
        switch(t) {
            case "freeBets":
                div.onclick = deleteFreeBet;
                break;
            case "profitBets":
                div.onclick = deleteProfitBet;
                break;
            case "bank":
                div.onclick = archiveBankTransfer;
                break;
            case "casinoEV":
                div.onclick = completeCasinoEV;
                break;
            case "transfers":
                div.onclick = deleteTransfer;
                break;
        }

        e.appendChild(div);
        
    })
}

function deleteFreeBet() {
    //Get row as target of clicked event
    row = event.target.parentElement; //Initialize table variables

    const bookmaker = row.querySelector("[name='bookmaker']").value;
    const conditions = row.querySelector("[name='conditions']").value;
    const date = row.querySelector("[name='date']").value;
    var freebet;

    //Check profit input for number value
    try { //Try to find £ value indicator
        const words = conditions.split('£'); //Split at the £
        const value = words[1].split(' '); //Split again after first space
        freebet = value[0];
    } catch (e) { //If no value, set profit to 0
        freebet = 0;
    }

    if (bookmaker != "" && conditions != "" && date != "") {
        //Ajax request to save data into MySQL
        $.ajax({
            url: "functions/removeFreeBet.php",
            data: {bookmaker: bookmaker,
                   condition: conditions,
                   freebet: freebet,
                   date: date
                },
            success: function(){
                // Success refresh windows
                location.reload();
            },
            error: function (request, status, error) {
                alert("Could not save data:");
                //Show error message could not save data
            }
        });
    }
    
    //Remove row from table
    event.target.parentElement.remove();
}

//Delete info from bank table and place into archived table
function archiveBankTransfer(row) {
    
    //Get row as target of clicked event
    row = event.target.parentElement; //Initialize table variables

    const bookmaker = row.querySelector("[name='bookmaker']").value;
    const description = row.querySelector("[name='description']").value;
    const date = row.querySelector("[name='date']").value;
    var amount;

    //Check profit input for number value
    try { //Try to find £ value indicator
        const words = description.split('£'); //Split at the £
        const value = words[1].split(' '); //Split again after first space
        amount = value[0];
    } catch (e) { //If no value, set profit to 0
        amount = 0;
    }

    if (bookmaker != "" && description != "" && date != "") {
        //Ajax request to save data into MySQL
        $.ajax({
            url: "functions/archiveBank.php",
            data: {bookmaker: bookmaker,
                   description: description,
                   amount: amount,
                   date: date
                },
            success: function(){
                // Success refresh windows
                location.reload();
            },
            error: function (request, status, error) {
                alert("Could not save data:");
                //Show error message could not save data
            }
        });
    }
    
    //Remove row from table
    event.target.parentElement.remove();
}

function deleteProfitBet() {

    //Get row as target of clicked event
    row = event.target.parentElement; //Initialize table variables
    const bookmaker = row.querySelector("[name='bookmaker']").value;
    const profit = row.querySelector("[name='profit']").value;
    const date = row.querySelector("[name='date']").value;

    //Check variables are not empty to perform AJAX request
    if (bookmaker != "" && profit != "" && date != "") {
        //Ajax request to MySQL
        $.ajax({ //Delete table data
            url: "functions/deleteProfitBet.php",
            data: {bookmaker: bookmaker,
                   profit: profit,
                   date: date
                },
            success: function(){
                // Success refresh windows
                location.reload();
            },
            error: function (request, status, error) {
                alert("Could not save data:");
                //Show error message could not save data
            }
        });
    }
    
    //Remove row from table
    event.target.parentElement.remove();
}

function completeCasinoEV() {
    //Get current row
    const row = event.target.parentElement.parentElement;

    //Get current row date
    const date = row.querySelector("[name='date']").value;

    //Prompt user to enter real profit value
    let profit = prompt('Enter profit');

    console.log(profit + date);

    //Ajax request to update data into MySQL
    $.ajax({
        url: "functions/updateCasino.php",
        data: {profit: profit,
               date: date
            },
        success: function(){
            //Reload window to refresh table
            window.location.reload();
        },
        error: function (request, status, error) {
            alert("Could not save data");
            //Show error message could not save data
        }
    });
    
    //Remove row from table
    event.target.parentElement.remove();
}


//Delete info from transfer table and place into archived table
function deleteTransfer(row) {
    
    //Get row as target of clicked event
    row = event.target.parentElement; //Initialize table variables

    const amount = row.querySelector("[name='amount']").value;
    const date = row.querySelector("[name='date']").value;

    if (amount != "" && date != "") {
        //Ajax request to save data into MySQL
        $.ajax({
            url: "functions/deleteTransfer.php",
            data: {amount: amount,
                   date: date
                },
            success: function(){
                // Success refresh windows
            },
            error: function (request, status, error) {
                alert("Could not save data:");
                //Show error message could not save data
            }
        });
    }
    
    //Remove row from table
    event.target.parentElement.remove();
}


//Small UX code to blur out of focus after pressing enter
function addInput(input) {
    //Check enter key is pressed or escape key is pressed
    if (event.keyCode === 13 || event.keyCode === 27) {
        //Prevent Default Actions
        event.preventDefault();
        input.blur();
    }
}

/* New Additions */
function showUsers() {
    const users = document.getElementById('changeUsers');

    if (changeUsers.style.display == "none" || changeUsers.style.display == "") {
        changeUsers.style.display = "block";
    } else {
        changeUsers.style.display = "none"
    }
}