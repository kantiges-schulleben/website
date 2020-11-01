var prüfen;

window.onload = function () {
    prüfen = setInterval(abfrage, 10000);//60000);
    this.abfrage();
}

function abfrage() {
    console.log("abfrage");
    $.get("schueler.php", function(data){
        console.log("Data: " + data);
        if (data.length > 1){
            console.log("bereit");
            // document.getElementById("weiterleiten").disabled = false;
            // document.getElementById("weiterleitenLINK").href = data;
            window.location.href = data;
        }
        else {
            console.log("nicht bereit");
        }
    });
}