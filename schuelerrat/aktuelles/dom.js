function createStatement(_title = "", _content = "", _image = "", _target="") {
    /*
    <div class="item2">
        <div class="placeholder"></div>
        <img src="../../assets/email.png">
        <div class="f">Titel</div><br>
        <div class="d">
            Hier könnte ihre Werbung stehen! Hier könnte ihre Werbung stehen! Hier könnte ihre Werbung stehen! Hier könnte ihre Werbung stehen! Hier könnte ihre Werbung stehen! Hier könnte ihre Werbung stehen! Hier könnte ihre Werbung stehen! Hier könnte ihre Werbung
            stehen! Hier könnte ihre Werbung stehen! Hier könnte ihre Werbung stehen! Hier könnte ihre Werbung stehen! Hier könnte ihre Werbung stehen! Hier könnte ihre Werbung stehen! Hier könnte ihre Werbung stehen! Hier könnte ihre Werbung
            stehen! Hier könnte ihre Werbung stehen! Hier könnte ihre Werbung stehen! Hier könnte ihre Werbung stehen! Hier könnte ihre Werbung stehen! Hier könnte ihre Werbung stehen!
        </div>
        <a href="#Protokolle" class="button1">Beitrag anzeigen</a>
    </div>
    */

    const container = document.createElement("div");
    container.classList.add("item2");

    const placeholder = document.createElement("div");
    placeholder.classList.add("placeholder");

    const image = document.createElement("img");
    image.src = _image;

    const title = document.createElement("div");
    title.classList.add("f");
    title.innerText = _title;

    const content = document.createElement("div");
    content.classList.add("d");
    content.innerText = _content;

    const linkToArticle = document.createElement("a");
    linkToArticle.classList.add("button1");
    linkToArticle.href = _target;
    linkToArticle.innerText = "Beitrag anzeigen";

    // ===========================================================
    container.appendChild(placeholder);
    container.appendChild(image);
    container.appendChild(title);
    container.appendChild(document.createElement("br"));
    container.appendChild(content);
    container.appendChild(linkToArticle);
    // ===========================================================

    return container;
}

function createDownloadProtokoll(_title = "", _date = "",  _downloadLocation = "") {
    /*
    <div class="item">
        Protokol 1 <br>
        <div class="d">12.04.2021</div>
        <a href="#Protokolle" class="button">download</a>
    </div>
    */

    const container = document.createElement("div");
    container.classList.add("item");
    container.innerText = _title;

    const date = document.createElement("div");
    date.classList.add("d");
    date.innerText = _date;

    const download = document.createElement("a");
    download.classList.add("button");
    download.href = _downloadLocation;
    download.innerText = "download";

    // ===========================================================
    container.appendChild(document.createElement("br"));
    container.appendChild(date);
    container.appendChild(download);
    // ===========================================================

    return container
}

function createNoContent(_title = "") {
    const container = document.createElement("div");
    // container.classList.add("item2");

    const placeholder = document.createElement("div");
    placeholder.classList.add("placeholder");


    const title = document.createElement("div");
    title.classList.add("f");
    title.innerText = _title;
    title.style.fontStyle = "italic";

    // ===========================================================
    container.appendChild(placeholder);
    container.appendChild(title);
    // ===========================================================

    return container;
}