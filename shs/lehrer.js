var zeit;
var Startzeit;
var stunde
var minute

let regexName = /^([^ \u00c0-\u01ffa-zA-Z\.' \-]{3,})+$/;

/*window.onload = function () {
    zeit = setInterval(Startzeit, 60000);
    a = new Date();
    stunde = a.getHours();
    minute = a.getMinutes();
    stunde.toString();
    minute.toString();
    if (stunde <= 10) {
        startzeit = "0" + stunde + ":" + minute
        document.getElementById("startzeit").value = startzeit;
    }
    else if (minute <= 10) {
        startzeit =stunde + ":" + "0" + minute
        document.getElementById("startzeit").value = startzeit;
    }
    else {
        document.getElementById("startzeit").value = startzeit;
    }
}

function Startzeit () {
    a = new Date();
    stunde = a.getHours();
    minute = a.getMinutes();
    stunde.toString();
    minute.toString();
    if (stunde <= 10) {
        startzeit = "0" + stunde + ":" + minute
        document.getElementById("startzeit").value = startzeit;
    }
    else if (minute <= 10) {
        startzeit =stunde + ":" + "0" + minute
        document.getElementById("startzeit").value = startzeit;
    }
    else {
        document.getElementById("startzeit").value = startzeit;
    }
}*/


function sendToBackend() {
    document.getElementById('space').style.visibility = "visible";
    /*endzeit = document.getElementById("endzeit").value
    startzeit1 = startzeit.slice(0,2);
    endzeit1 = endzeit.slice(0,2);
    stundendauer = endzeit1 - startzeit1
    if (startzeit > endzeit) {
        console.log("falsch");
        evt.preventDefault();
        document.querySelector(".msg.zeiten").innerHTML = "Die Endzeit muss später als die Startzeit sein!";
    }
    else if (stundendauer != 1) {
        console.log("falsch");
        evt.preventDefault();
        document.querySelector(".msg.zeiten").innerHTML = "Die Nachhilfe muss eine Stunde gehen";
    }*/
    console.log("click");
    let Titel = document.getElementById('titel');
    if (Titel.value.match(regexName)) {
        console.log("falsch");
        alert("Dein Titel darf nur Zahlen und Buchstaben beinhalten und muss darf nicht mit einer Zahl beginnen.")
        document.getElementById('space').style.visibility = "hidden";
    } else if (Titel.value == "") {
        console.log("falsch");
        alert("Bitte gib einen Titel ein.");
        document.getElementById('space').style.visibility = "hidden";
    } else {
        console.log(Titel.value);
        $.post('lehrer.php', {
            data: Titel.value
        }, function (data) {
            console.log(data);
            if (data[0] == "0") { // weiterleiten
                window.location = data.substring(1, data.length);
            } else if (data[0] == "1") { //information
                alert(data.substring(1, data.length));
            }
        });
    }
    console.log("click done");
}

function reset() {
    document.getElementById('titel').value = "";
    document.getElementById('titel').focus();
}