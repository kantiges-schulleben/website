// Variablen================================================================================================================================================
let inputs = ["txtName", "txtKlasse", "txtMail", "txtTelefon", "selectGebenNehmen", "txtFacher", "txtZeiten", "selectArt", "txtText"];
let timer;

// setup====================================================================================================================================================
function setup() {
    timer = window.setInterval(count, 10000);
    count();
}

// get======================================================================================================================================================
function get() {
    //get value of inputs and send request to get.php
    //output recieved data in table

    document.getElementById('results').innerHTML = "";

    $.post('get.php', {
        mode: "0",
        data: document.getElementById('txtVorname').value + " " + document.getElementById('txtNachname').value
    }, function (data) {
        if (data == "") {
            alert("Kein Ergebnis.");
        } else {
            let tmp = "";

            for (let i = 0; i < data.length; i++) {
                if (data[i] == ':') {
                    add(tmp);
                    tmp = "";
                } else {
                    tmp += data[i];
                }
            }
        }
    });
}

// add======================================================================================================================================================
function add(name) {
    let tr = document.createElement("tr");
    let tdBTTN = document.createElement("td");
    tr.className = "results";


    let button = document.createElement("button");
    button.addEventListener("click", openEditor);
    // button.className = "ListButton button";
    let text = document.createTextNode(name.replace('+', ' '));
    button.appendChild(text);
    button.className = "results";


    tdBTTN.appendChild(button);
    tr.appendChild(tdBTTN);

    document.getElementById("results").appendChild(tr);
}

// openEditor===============================================================================================================================================
function openEditor() {
    $.post('get.php', {
        mode: "1",
        data: event.target.innerHTML
    }, function (data) {
        if (data == "") {
            alert("Es ist ein Fehler aufgetreten.");
        } else {
            let tmp = "";
            let personalData = [];

            for (let i = 0; i < data.length; i++) {
                if (data[i] == ':') {
                    personalData.push(tmp);
                    tmp = "";
                } else {
                    tmp += data[i];
                }
            }

            for (let i = 0; i < inputs.length; i++) {
                document.getElementById(inputs[i]).value = personalData[i];
                document.getElementById(inputs[i]).disabled = false;
            }

            document.getElementById('txtName').disabled = true;

            document.getElementById("bttnPut").disabled = false;
            document.getElementById('mydiv').style.visibility = "visible";
        }
    });
}

// put======================================================================================================================================================
function put() {
    let personalData = [];

    for (let i = 0; i < inputs.length; i++) {
        personalData.push(document.getElementById(inputs[i]).value);
    }

    console.log(personalData);

    $.post('put.php', {
        data: personalData
    }, function (data) {
        if (data == "") {
            alert("Es ist ein Fehler aufgetreten.");
        } else {
            document.getElementById('mydiv').style.visibility = "collapse";

            for (let i = 0; i < inputs.length; i++) {
                document.getElementById(inputs[i]).value = "";
                document.getElementById(inputs[i]).disabled = true;
            }

            document.getElementById("bttnPut").disabled = true;
        }
    });
}

// count====================================================================================================================================================
function count() {
    $.get('count.php', function (data) {
        if (data == "") {
            alert("Es ist ein Fehler aufgetreten.");
            window.clearInterval(timer);
        } else {
            console.log(data);
            document.getElementById('counter').innerText = JSON.parse(data).count + " angemeldete Schüler";
        }
    });
}
// start script=============================================================================================================================================
function startScript() {
    if (confirm("Bist du dir sicher?")) {
        $.get('start.php', function (data) {
            if (data == "") {
                alert("Es ist ein Fehler aufgetreten.");
            } else {
                document.getElementById('output').innerHTML = data;
            }
        });
    } else {
        alert("Auch ok.");
    }
}