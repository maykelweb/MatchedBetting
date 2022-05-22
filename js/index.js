/* Add a new cell to the table */
function addTable(t, r1, r2) {
    const table = document.getElementById(t).getElementsByTagName('tbody')[0];

    // Insert a row at the end of table
    var newRow = table.insertRow();

    // Insert a cell at the end of the row
    var row1 = newRow.insertCell();
    var row2 = newRow.insertCell();

    //Create bookie input node
    var inputB = document.createElement("input");
    inputB.type = "text";
    inputB.placeholder = "Enter " + r1.charAt(0).toUpperCase() + r1.slice(1); //Short code to uppercase first character 
    inputB.setAttribute("name", r1);

    //add Event listeners to automatically add data into table
    inputB.addEventListener("keyup", (event) => { 
        addInput(inputB);
    });
    
    //Create profit input node
    var inputP = document.createElement("input");
    inputP.type = "text";
    inputP.placeholder = "Enter " + r2.charAt(0).toUpperCase() + r2.slice(1);
    inputP.setAttribute("name", r2);
    
    //Add event listeners
    inputP.addEventListener("keyup", (event) => {
        addInput(inputP);
    });

    //Create Hidden Date field
    var inputD = document.createElement("input");
    inputD.setAttribute("type", "hidden");
    inputD.setAttribute("name", "date");
    inputD.setAttribute("value", new Date().toLocaleString().replace(/ /g, ":"));

    //Listen to row changes
    newRow.addEventListener('change', (event) => {
        if (r1 == "bookmaker") {
            addFreeBet(event);
        }
        if (r1 == "casino") {
            addCasino(event);
        }
    });

    // Append an input node to the cell
    row1.appendChild(inputB);
    row2.appendChild(inputP);
    row2.appendChild(inputD);
}

//Function to validate free bets table and add new inputs to MySQL
function addFreeBet(e) {
    const row = e.target.parentElement.parentElement;

    const bookmaker = row.querySelector("[name='bookmaker']").value;
    const conditions = row.querySelector("[name='conditions']").value;
    const date = row.querySelector("[name='date']").value;
    var profit;

    //Check profit input for number value
    try { //Try to find £ value indicator
        const words = conditions.split('£'); //Split at the £
        const value = words[1].split(' '); //Split again after first space
        profit = Number(value[0].replace(/[^\d]/g, "")); //Replace all characters except numbers
    } catch (e) { //If no value, set profit to 0
        profit = 0;
    }

    if (bookmaker != "" && conditions != "" && date != "") {
        //Ajax request to save data into MySQL
        console.log(profit);
        $.ajax({
            url: "functions/addFreeBet.php",
            data: {bookmaker: bookmaker,
                   condition: conditions,
                   profit: profit,
                   date: date
                },
            success: function(){
                // Success
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
    const ev = row.querySelector("[name='ev']").value;
    const date = row.querySelector("[name='date']").value;

    if (casino != "" && ev != "" && date != "") {
        //Ajax request to save data into MySQL
        $.ajax({
            url: "functions/addCasino.php",
            data: {casino : casino,
                   ev: ev,
                   date: date
                },
            success: function(){
                // Success
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

    let count = 0;
    //Add remove button for each row
    table.forEach((e) => {
        //Create remove button
        var div = document.createElement("div");
        div.classList.add("list-remove");
        div.onclick = removeTable;
        div.innerText = "x";
        div.setAttribute("value", count);
        e.appendChild(div);

        if (t == "casino") {
            var tick = document.createElement("span");
            tick.classList.add("list-done");
            tick.onclick = completeTable;
            tick.innerHTML = '<i class="fa-solid fa-check"></i>';
            tick.setAttribute("value", count);
            e.appendChild(tick);
        }
        
        count++;
    })
}

//Remove item from table
function removeTable() {
    event.target.parentElement.remove();
}

function completeTable() {
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

}

//Remove delete buttons
function removeEdit(t) {
    //Get all table rows
    const table = document.getElementById(t);

    let list = table.querySelectorAll('.list-remove');

    //Add remove button for each row
    list.forEach((e) => {
        e.remove();
    })
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

function changeUser() {
    alert("here")
}