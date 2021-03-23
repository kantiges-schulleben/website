// Variablen================================================================================================================================================
let timer;

// setup====================================================================================================================================================
function setup() {
    timer = window.setInterval(count, 10000);
    count();
}
// count====================================================================================================================================================
function count() {
    $.get('count.php', function (data) {
        if (data == "") {
            window.clearInterval(timer);
        } else {
            console.log(data);
            document.getElementById('counter').innerText = JSON.parse(data).count + " angemeldete Schüler";
        }
    });
}
// start script=============================================================================================================================================
function startScript() {
    if (confirm("Auswertung starten?")) {
        document.getElementById("output").innerText = "auswertung gestartet...";
        $.get('start.php', function (data) {
            if (data == "") {
                alert("Es ist ein Fehler aufgetreten.");
            } else {
                document.getElementById('output').innerText = data;
            }
        });
    }
}
