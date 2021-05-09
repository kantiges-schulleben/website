function preload() {
        // Reden/Statements ===================================================================================
        for (let i = 0; i < 12; i++) {
            document.getElementById("reden").appendChild(createStatement("Titel", "Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et", "../../../assets/email.png"));
        }
    
        // <a href="./reden/index.php" class="button1">Alle Beiträge anzeigen</a> -->
    
        // const showAllSpeaches = () => {
        //     const elmnt = document.createElement("a");
        //     elmnt.href = "./reden/index.php";
        //     elmnt.classList.add("button1");
        //     elmnt.innerText = "Alle Beiträge anzeigen";
    
        //     return elmnt;
        // };
        // document.getElementById("reden").appendChild(showAllSpeaches());
}