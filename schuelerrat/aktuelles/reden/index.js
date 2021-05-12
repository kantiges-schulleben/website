var page = 0;

function preload() {
    // Reden/Statements ===================================================================================
    $.post("../../../blog/get.php", {
        blogname: "reden",
        page: "0"
    }, (data) => {
        const json = JSON.parse(data);
        console.log(json);

        var count = 0;
        if (json.length > 0) {
            for (article of json) {
                document.getElementById("reden").appendChild(createStatement(decodeURIComponent(article.title), decodeURIComponent(article.content), "../../" + ((decodeURIComponent(article.image) != "../images/") ? decodeURIComponent(article.image) : "../assets/email.png"), "../../../blog/get.php?id=" + decodeURIComponent(article.id)));
                if (count == 5) {
                    break;
                }
                count++
            }

            // <a href="./reden/index.php" class="button1">Alle Beiträge anzeigen</a> -->
            const showAllSpeaches = () => {
                const elmnt = document.createElement("a");
                elmnt.href = "javascript:void(0);";
                elmnt.addEventListener("click", () => {
                    page ++;
                    makeCallAndUpdateDOM();
                });
                elmnt.classList.add("button1");
                elmnt.innerText = "weitere Beiträge anzeigen";

                return elmnt;
            };
            document.getElementById("redenParent").appendChild(showAllSpeaches());
        } else {
            document.getElementById("reden").appendChild(createNoContent("Das sind nicht die Reden, die du suchst."));
        }
    });
}

function makeCallAndUpdateDOM() {
    $.post("../../../blog/get.php", {
        blogname: "reden",
        page: page
    }, (data) => {
        const json = JSON.parse(data);
        console.log(json);

        var count = 0;
        if (json.length > 0) {
            for (article of json) {
                document.getElementById("reden").appendChild(createStatement(decodeURIComponent(article.title), decodeURIComponent(article.content), "../../../assets/email.png", "../../../blog/get.php?id=" + decodeURIComponent(article.id)));
                if (count == 5) {
                    break;
                }
                count++
            }
        }
    });
}