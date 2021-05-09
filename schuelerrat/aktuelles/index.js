function preload() {
    // Reden/Statements ===================================================================================
    for (let i = 0; i < 3; i++) {
        document.getElementById("reden").appendChild(createStatement("Titel", "Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et", "../../assets/email.png"));
    }

    // <a href="./reden/index.php" class="button1">Alle Beiträge anzeigen</a> -->

    const showAllSpeaches = () => {
        const elmnt = document.createElement("a");
        elmnt.href = "./reden/index.php";
        elmnt.classList.add("button1");
        elmnt.innerText = "Alle Beiträge anzeigen";

        return elmnt;
    };
    document.getElementById("reden").appendChild(showAllSpeaches());

    // Relevantes ===================================================================================
    for (let i = 0; i < 3; i++) {
        document.getElementById("relevantes").appendChild(createStatement("Titel", "Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et", "../../assets/info.jpg"));
    }

    // <a href="./relevantes/index.php" class="button1">Alle Beiträge anzeigen</a>

    const showAllRelevant = () => {
        const elmnt = document.createElement("a");
        elmnt.href = "./relevantes/index.php";
        elmnt.classList.add("button1");
        elmnt.innerText = "Alle Beiträge anzeigen";

        return elmnt;
    };
    document.getElementById("relevantes").appendChild(showAllRelevant());

    // Protokolle ===================================================================================
    for (let i = 0; i < 9; i++) {
        document.getElementById("protokolle").appendChild(createDownloadProtokoll(`Protokoll ${i}`, "09.05.2021", "#Protokolle"));
    }
}