/* Add a new cell to the table */
function addTable(t) {
    const table = document.getElementById(t).getElementsByTagName('tbody')[0];

    // Insert a row at the end of table
    var newRow = table.insertRow();

    // Insert a cell at the end of the row
    var bookies = newRow.insertCell();
    var profit = newRow.insertCell();

    //Create bookie input node
    var inputB = document.createElement("input");
    inputB.type = "text";
    inputB.placeholder = "Enter Bookie"; 
    inputB.setAttribute("name", "bookmaker");

    //add Event listeners to automatically add data into table
    inputB.addEventListener("keyup", (event) => { 
        addInput(inputB);
    });
    
    //Create profit input node
    var inputP = document.createElement("input");
    inputP.type = "text";
    inputP.placeholder = "Enter Profits"; 
    inputP.setAttribute("name", "profit");
    
    //Add event listeners
    inputP.addEventListener("keyup", (event) => {
        addInput(inputP);
    });

    //Create Hidden Date field
    var inputD = document.createElement("input");
    inputD.setAttribute("type", "hidden");
    inputD.setAttribute("name", "date");
    inputD.setAttribute("value", new Date().toLocaleString());

    //Listen to row changes
    newRow.addEventListener('change', (event) => {
        addFreeBet(event);
    });

    // Append an input node to the cell
    bookies.appendChild(inputB);
    profit.appendChild(inputP);
    profit.appendChild(inputD);
}

//Function to validate free bets table and add new inputs to MySQL
function addFreeBet(e) {
    
    const row = e.target.parentElement.parentElement;

    const bookmaker = row.querySelector("[name='bookmaker']");
    const profit = row.querySelector("[name='profit']");
    const date = row.querySelector("[name='date']");

    console.log(bookmaker.value + " | " + profit.value + " | " + date.value);
}

//Add remove buttons to each table list
function editTable(t) {
    //Get all table rows
    const table = document.getElementById(t).querySelectorAll('tbody tr');

    let count = 0;
    //Add remove button for each row
    table.forEach((e) => {
        console.log("here1")
        //Create remove button
        var div = document.createElement("div");
        div.classList.add("list-remove");
        div.onclick = removeTable;
        div.innerText = "x";
        div.setAttribute("value", count);
        e.appendChild(div)
        
        count++;
    })
}

//Remove item from table
function removeTable() {
    event.target.parentElement.remove();
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
function addInput(input, skip) {
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