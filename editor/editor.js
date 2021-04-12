var überschrift = document.getElementById("überschrift");
var inhalt = document.getElementById("inhalt");
var bild = document.getElementById("bild");

document.getElementById("editorButton").style.background='#38d39f';
document.getElementById("previewButton").style.background='white';
document.getElementById("previewButton").style.color='#38d39f';
document.getElementById("vorschau").hidden = true;


document.querySelectorAll(".drop-zone__input").forEach(inputElement => {
    const dropZoneElement = inputElement.closest(".drop-zone");

    dropZoneElement.addEventListener("click", e => {
        inputElement.click();
    });

    inputElement.addEventListener("change", e => {
        if (inputElement.files.length) {
            var file = inputElement.files[0];
            updateThumbnail(dropZoneElement, file);
        }
    });

    dropZoneElement.addEventListener("dragover", e => {
        e.preventDefault();
        dropZoneElement.classList.add("drop-zone--over");
    });

    ["dragleave", "dragend"].forEach(type => {
        dropZoneElement.addEventListener(type, e => {
            dropZoneElement.classList.remove("drop-zone--over");
        });
    });
    dropZoneElement.addEventListener("drop", e => {
        e.preventDefault();

        if(e.dataTransfer.files.length) {
            if (e.dataTransfer.files[0].type.startsWith("image/")){
                inputElement.files = e.dataTransfer.files;
                var file = e.dataTransfer.files[0];
                e.dataTransfer.files = [];
                updateThumbnail(dropZoneElement, file);
            }
        }

        dropZoneElement.classList.remove("drop-zone--over");
    });
});

function updateThumbnail(dropZoneElement, file) {
    let thumbnailElement = dropZoneElement.querySelector(".drop-zone__thumb");

    if (dropZoneElement.querySelector(".drop-zone__prompt")) {
        dropZoneElement.querySelector(".drop-zone__prompt").remove();
    }

    if (!thumbnailElement) {
        thumbnailElement = document.createElement("div");
        thumbnailElement.classList.add("drop-zone__thumb");
        dropZoneElement.appendChild(thumbnailElement);
    }

    var fileName = file.name;
    if (fileName.length > 16) {
        fileName = file.name.substring(0, 13) + "...";
    }
    thumbnailElement.dataset.label = fileName;

    const reader = new FileReader();
    reader.readAsDataURL(file);
    reader.onload = () => {
        thumbnailElement.style.backgroundImage = `url('${ reader.result }')`
    };
}

function removeThumbnail() {
    document.querySelectorAll(".drop-zone__input").forEach(inputElement => {
        const dropZoneElement = inputElement.closest(".drop-zone");
        dropZoneElement.classList.remove("drop-zone--over");
        dropZoneElement.querySelector(".drop-zone__thumb").remove();
        promptElement = document.createElement("span");
        promptElement.classList.add("drop-zone__prompt");
        promptElement.innerHTML = "Lege es hier ab <br>oder klicke zum Auswählen"
        dropZoneElement.appendChild(promptElement);
    });
}

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

    if (!(überschrift.value == "")){
        document.querySelector(".msg.überschrift").innerHTML = überschrift.value;
    } else{
        document.querySelector(".msg.überschrift").innerHTML = "Noch keine Überschrift";
    }
    
    if (!(inhalt.value == "")){
        document.querySelector(".msg.inhalt").innerHTML = inhalt.value;
    } else{
        document.querySelector(".msg.inhalt").innerHTML = "Noch kein Textinhalt";
    }
    var tagsControlled = tags.value.replaceAll(" ", "")
    if (!(tagsControlled == "")){
        document.querySelector(".msg.tags").innerHTML = "#" + tags.value.replaceAll(" ", " #");
    } else {
        document.querySelector(".msg.tags").innerHTML = "keine Tags"
    }
    var d = new Date();
    var months = ["Januar", "Februar", "März", "April", "Mai", "Juni", "Juli", "August", "September", "Oktober", "November", "Dezember"];
    document.querySelector(".msg.datum").innerHTML = String(d.getDate()) + ". " + months[d.getMonth()] + " " + String(d.getFullYear());

    document.getElementById("bild").src = "";

    let fr = new FileReader();
    fr.onload = function () {
        document.getElementById("bild").src = fr.result;
        console.log(fr.result);
    }
    fr.readAsDataURL(document.getElementById("uploadedImage").files[0]);
}