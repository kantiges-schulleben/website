var überschrift = document.getElementById("überschrift");
var inhalt = document.getElementById("inhalt");
var bild = document.getElementById("bild");

document.getElementById("editorButton").style.background='#38d39f';
document.getElementById("previewButton").style.background='white';
document.getElementById("previewButton").style.color='#38d39f';
document.getElementById("vorschau").hidden = true;

function Editor() {
    document.getElementById("editor").hidden = false;
    document.getElementById("editorButton").style.background='#38d39f';
    document.getElementById("previewButton").style.background='white';
    document.getElementById("previewButton").style.color='#38d39f';
    document.getElementById("editorButton").style.color='white';
    document.getElementById("vorschau").hidden = true;
}

function Vorschau() {
    document.getElementById("editor").hidden = true;
    document.getElementById("previewButton").style.background='#38d39f';
    document.getElementById("previewButton").style.color='white';
    document.getElementById("editorButton").style.background='white';
    document.getElementById("editorButton").style.color='#38d39f';
    document.getElementById("vorschau").hidden = false;
    document.querySelector(".msg.überschrift").innerHTML = überschrift.value;
    document.querySelector(".msg.inhalt").innerHTML = inhalt.value;
    if (!(tags.value == "" || tags.value == " ")){
        document.querySelector(".msg.tags").innerHTML = "#" + tags.value.replaceAll(" ", " #");
    } else {
        document.querySelector(".msg.tags").innerHTML = "keine Tags"
    }
    var d = new Date();
    var months = ["Januar", "Februar", "März", "April", "Mai", "Juni", "Juli", "August", "September", "Oktober", "November", "Dezember"];
    document.querySelector(".msg.datum").innerHTML = String(d.getDate()) + ". " + months[d.getMonth()] + " " + String(d.getFullYear());

    let fr = new FileReader();
    fr.onload = function () {
        document.getElementById("bild").src = fr.result;
    }
    fr.readAsDataURL(document.getElementById("uploadedImage").files[0]);
}