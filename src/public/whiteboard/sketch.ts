function addUI() {
    // TODO type für <nav> finden
    (document.getElementById('navbar') as HTMLElement).innerHTML += `
    <div class="callUI" id="callUI">
        <button onclick="joinCall();" class="joinCall fas fa-phone"></button>
    </div>
    `;
}

function leaveCall() {
    (
        document.getElementById('callUI') as HTMLDivElement
    ).innerHTML = `<button onclick="joinCall();" class="joinCall fas fa-phone"></button>`;
    leaveRoom();
}

function joinCall(isUser: boolean = true) {
    (
        document.getElementById('callUI') as HTMLDivElement
    ).innerHTML = `<button onclick="leaveCall();" class="leaveCall fas fa-phone-slash"></button>`;

    if (isUser) {
        startVoiceCall();
    }
}

function startGGRemote() {
    const tmr = setTimeout(() => {
        // HACK kann ignoriert werden, da ggRemote-Class in js-Datei, aber types für GeoGebra-Applet schwierig sind
        //@ts-ignore
        ggRemote.init();
    }, 1000);
}
