var überschrift = document.getElementById("überschrift");
var inhalt = document.getElementById("inhalt");
//var bild = document.getElementById("bild");

function Editor() {
    document.getElementById("editor").hidden = false;
    document.getElementById("vorschau").hidden = true;
}

function Vorschau() {
    document.getElementById("editor").hidden = true;
    document.getElementById("vorschau").hidden = false;
    document.querySelector(".msg.überschrift").innerHTML = überschrift.value;
    document.querySelector(".msg.inhalt").innerHTML = inhalt.value;

    let fr = new FileReader();
    fr.onload = function () {
        document.getElementById("bild").src = fr.result;
    }
    fr.readAsDataURL(document.getElementById("uploadedImage").files[0]);
}