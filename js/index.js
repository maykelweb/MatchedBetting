//Function to load table data
function loadTable(t, d) {
    //total table price
    let total = 0;

    //Loop through table data and insert rows into table with html data
    d.forEach((element) => { 
        const tr = t.insertRow();
        tr.innerHTML = element;

        let price = element.split("£");
        total += parseFloat(price[1]);
    })
    
    //Add total price count
    t.parentElement.querySelector('#total').innerText = "£" + total;
}

function refreshTable(t, d) {
    removeEdit(t);

    let table = document.getElementById(t).getElementsByTagName('tbody')[0];

    let data = [];
    let prices = [];
    let total = 0;

    Array.from(table.children).forEach(tr => {
        data.push(tr.innerHTML)

        prices.push(tr.innerText.split("£"));
    });

    for(let i = 0; i < prices.length; i++) {
        total += parseFloat(prices[i][1]);
    }
    
    //Add total
    table.parentElement.querySelector('#total').innerText = "£" + total;

    localStorage.removeItem(d);
    localStorage.setItem(d, JSON.stringify(data));
}

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

    //add Event listeners to automatically add data into table
    inputB.addEventListener("keyup", (event) => {
        addInput(inputB);
    });
    inputB.addEventListener('blur', (event) => {
        addInput(inputB, true);
    });
    
    //Create profit input node
    var inputP = document.createElement("input");
    inputP.type = "text";
    inputP.placeholder = "Enter Profits"; 
    
    //Add event listeners
    inputP.addEventListener("keyup", (event) => {
        addInput(inputP);
    });
    inputP.addEventListener('blur', (event) => {
        addInput(inputP, true);
    });

    // Append an input node to the cell
    bookies.appendChild(inputB);
    profit.appendChild(inputP)
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

function removeEdit(t) {
    //Get all table rows
    const table = document.getElementById(t);

    let list = table.querySelectorAll('.list-remove');

    //Add remove button for each row
    list.forEach((e) => {
        e.remove();
    })
}

//Edit Table
function edit(e) {
    //Get Value
    let value = e.innerHTML;

    //Changes HTML to table data with input field
    //addlistener is called to add an event listener
    e.outerHTML = "<td><input type='text' value=" + value + " onclick='addListener(this)''></td>"; 
}

//Add input to table
function addInput(input, skip) {
    //Check enter key is pressed
    if (event.keyCode === 13 || event.keyCode === 27 || skip == true) {
        //Prevent Default Actions
        event.preventDefault();

        //Enter data into table
        let value = input.value;
        input.parentElement.outerHTML = "<td><span onclick='edit(this)'>" + value + "</span></td>";
    }
}

function addListener(e) {
    //Adding event listeners for enter key and out of focus. Both events call add input method
    e.addEventListener("keyup", (event) => {
        addInput(e);
    });
    e.addEventListener('blur', (event) => {
        addInput(e, true);
    });
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