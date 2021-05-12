var überschrift = document.getElementById("überschrift");
var inhalt = document.getElementById("inhalt");
var bild = document.getElementById("bild");
var tags = document.getElementById("tags");

document.getElementById("editorButton").style.background='#16cc68';
document.getElementById("previewButton").style.background='white';
document.getElementById("previewButton").style.color='#16cc68';
document.getElementById("vorschau").hidden = true;
document.getElementById("deleteThumbnailButton").hidden = true;


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
    document.getElementById("deleteThumbnailButton").hidden = false;
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
    document.getElementById("deleteThumbnailButton").hidden = true;
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

function removeJustThumbnail(){
    var überschriftValue = überschrift.value;
    var inhaltValue = inhalt.value;
    var tagsValue = tags.value;

    document.getElementById("Abbrechen").click();

    überschrift.value = überschriftValue;
    inhalt.value = inhaltValue;
    tags.value = tagsValue;
}

function Editor() {
    document.getElementById("editor").hidden = false;
    document.getElementById("editorButton").style.background='#16cc68';
    document.getElementById("previewButton").style.background='white';
    document.getElementById("previewButton").style.color='#16cc68';
    document.getElementById("editorButton").style.color='white';
    document.getElementById("vorschau").hidden = true;
}

function Vorschau() {
    document.getElementById("editor").hidden = true;
    document.getElementById("previewButton").style.background='#16cc68';
    document.getElementById("previewButton").style.color='white';
    document.getElementById("editorButton").style.background='white';
    document.getElementById("editorButton").style.color='#16cc68';
    document.getElementById("vorschau").hidden = false;

    if (!(überschrift.value == "")){
        document.querySelector(".msg.überschrift").innerHTML = überschrift.value;
    } else{
        document.querySelector(".msg.überschrift").innerHTML = "Noch keine Überschrift";
    }
    
    if (!(inhalt.value == "")){
        document.querySelector(".msg.inhalt").innerHTML = parseMarkdown(inhalt.value);
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

    if(document.getElementById("uploadedImage").files[0]){
        let fr = new FileReader();
        fr.onload = function () {
            document.getElementById("bild").src = fr.result;
        }
        fr.readAsDataURL(document.getElementById("uploadedImage").files[0]);
    }
}

function parseMarkdown(content = "") {
    let contentToOutput = "";
        
    let boldStart = true;
    let italicStart = true;
    let durchStart = true;
    let underLineStart = true;
    let headlineStart = true;
    let ignoreNext = false;

    for (let i = 0; i < content.length; i++){
        const char = content[i];
        switch (char) {
            // Zeilenumbruch
            case '\\':
                if (content[i + 1] == " ") {
                    contentToOutput += char;
                } else {
                    contentToOutput += "<br>";
                }
                break;
            // fett
            case '*':
                if (content[i + 1] == " " && boldStart === true) {
                    contentToOutput += char;
                } else {
                    contentToOutput += "<" + ((boldStart === true) ? "" : "/") + "b>";
                    boldStart = !boldStart;
                }
                break;
            // kursiv
            case '~':
                if (content[i + 1] == " " && italicStart === true) {
                    contentToOutput += char;
                } else {
                    contentToOutput += "<" + ((italicStart === true) ? "" : "/") + "i>";
                    italicStart = !italicStart;
                }
                break;
            // durchgestrichen
            case '-':
                if (content[i + 1] == " " && durchStart === true) {
                    contentToOutput += char;
                } else {
                    contentToOutput += "<" + ((durchStart === true) ? "" : "/") + "s>";
                    durchStart = !durchStart;
                }
                break;
            // unterstrichen
            case '_':
                if (content[i + 1] == " " && underLineStart === true) {
                    contentToOutput += char;
                } else {
                    contentToOutput += "<" + ((underLineStart === true) ? "" : "/") + "u>";
                    underLineStart = !underLineStart;
                }
                break;
            // horizontale Linie
            case '=':
                if (ignoreNext === false) {
                    if (content[i + 1] !== "=") {
                        contentToOutput += char;
                    } else {
                        contentToOutput += "<hr>";
                        ignoreNext = true;
                    }
                } else {
                    ignoreNext = false;
                }
                break;
            // Übershrift
            case '#':
                if (content[i + 1] == " " && headlineStart === true) {
                    contentToOutput += char;
                } else {
                    contentToOutput += "<" + ((headlineStart === true) ? "" : "/") + "h5><hr>";
                    headlineStart = !headlineStart;
                }
                break;
            // Rest
            default:
                contentToOutput += char;
                break;
        }
    }

    if (boldStart === false) {
        contentToOutput += "</b>";
    }
    if (italicStart === false) {
        contentToOutput += "</i>";
    }
    if (durchStart === false) {
        contentToOutput += "</s>";
    }
    if (underLineStart === false) {
        contentToOutput += "</u>";
    }
    if (headlineStart === false) {
        contentToOutput += "</h5><hr>";
    }
    
    return contentToOutput;
}