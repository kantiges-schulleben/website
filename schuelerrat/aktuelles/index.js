function preload() {
    // Reden/Statements ===================================================================================
    $.post("../../blog/get.php", {
        blogname: "reden",
        page: "0"
    }, (data) => {
        const json = JSON.parse(data);

        var count = 0;
        if (json.length > 0) {
            for (article of json) {
                console.log(article.image);
                document.getElementById("reden").appendChild(createStatement(decodeURIComponent(article.title), decodeURIComponent(article.content), "../" + ((decodeURIComponent(article.image) != "../images/") ? decodeURIComponent(article.image) : "../assets/email.png"), "../../blog/get.php?id=" + decodeURIComponent(article.id)));
                if (count == 2) {
                    break;
                }
                count++
            }

            // <a href="./reden/index.php" class="button1">Alle Beiträge anzeigen</a> -->
            const showAllSpeaches = () => {
                const elmnt = document.createElement("a");
                elmnt.href = "./reden/index.php";
                elmnt.classList.add("button1");
                elmnt.innerText = "Alle Beiträge anzeigen";

                return elmnt;
            };
            document.getElementById("redenParent").appendChild(showAllSpeaches());
        } else {
            document.getElementById("reden").appendChild(createNoContent("Das sind nicht die Reden, die du suchst."));
        }
    });

    // Relevantes ===================================================================================
    $.post("../../blog/get.php", {
        blogname: "schuelerrat",
        page: "0"
    }, (data) => {
        const json = JSON.parse(data);

        var count = 0;
        if (json.length > 0) {
            for (article of json) {
                console.log(article.image);
                document.getElementById("relevantes").appendChild(createStatement(decodeURIComponent(article.title), decodeURIComponent(article.content),  "../" + ((decodeURIComponent(article.image) != "../images/") ? decodeURIComponent(article.image) : "../assets/email.png"), "../../blog/get.php?id=" + decodeURIComponent(article.id)));
                if (count == 2) {
                    break;
                }
                count++
            }

            // <a href="./reden/index.php" class="button1">Alle Beiträge anzeigen</a> -->
            const showAllSpeaches = () => {
                const elmnt = document.createElement("a");
                elmnt.href = "./relevantes/index.php";
                elmnt.classList.add("button1");
                elmnt.innerText = "Alle Beiträge anzeigen";

                return elmnt;
            };
            document.getElementById("relevantesParent").appendChild(showAllSpeaches());
        } else {
            document.getElementById("relevantes").appendChild(createNoContent("Gehen Sie weiter. Hier gibt es nichts relevantes zu sehen!"));
        }
    });

    // Protokolle ===================================================================================
    document.getElementById("protokolle").appendChild(createNoContent("Unmöglich. Vielleicht sind die Archive unvollständig."));
    return;
    for (let i = 0; i < 9; i++) {
        document.getElementById("protokolle").appendChild(createDownloadProtokoll(`Protokoll ${i}`, "09.05.2021", "#Protokolle"));
    }
}