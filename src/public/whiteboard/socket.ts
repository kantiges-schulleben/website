type obj = {
    [key: string]: any;
};

const enum dataType {
    text,
    picture,
}

const enum typingState {
    start,
    end,
}

let socket: any = undefined;
let channelId: string = '';
let fromName: string = '';
let socketId: string = '';
let callPartner: string = '';

let roomCountWasTwo = false;

function checkIfInvite() {
    $.get('/whiteboard/joinRoom', (data: obj) => {
        console.log(data);
        if (data.isInvited == true) {
            channelId = data.roomId;
            go(data.displayName);
        }
    });
}

function go(displayName: string) {
    // const socket = io.connect('/');
    // socket.on('dsn', (data) => {
    //     console.log(data.message);
    //     socket.emit('huston', {
    //         message: "ignition sequenze start"
    //     });
    // });

    if (fromName == '' && displayName == '') {
        fromName = prompt('displayname:', '')!;
        if (fromName == '') return;
    } else {
        fromName = displayName;
    }

    if (channelId == '') return;

    (document.getElementById('outChannelId') as HTMLHeadingElement).innerText =
        fromName + ' -> #' + channelId + ' (1)';
    createInvite();
    socket = io.connect(`/chat`);
    socket.emit('join', {
        roomId: channelId,
    });

    socket.on('getMyData', (data: obj) => {
        console.log(data);
        socketId = data.id;

        initPeer(data.id);
        console.log('peer init');
    });
    socket.emit('getMyData', {});

    socket.on('incomingCall', (data: obj) => {
        // could do stuff with data.from -> socketId von anrufer
        socket.emit('answerCall', {
            to: data.from,
            from: socketId,
        });

        startListeningForCall();
    });

    // text/picture messages =========================================
    socket.on('gotMessage', (data: obj) => {
        console.log('got data');
        const li: HTMLLIElement = document.createElement('li');
        if (data.type === dataType.text) {
            li.innerText = data.from + ': ' + data.message;
        } else if (data.type === dataType.picture) {
            li.innerText = data.from + ': ';
            li.classList.add('fromMe');

            const img: HTMLImageElement = document.createElement('img');
            img.src = data.message;

            li.appendChild(img);
        }
        (document.getElementById('lstOutput') as HTMLUListElement).appendChild(
            li
        );
        window.scrollTo(0, document.body.scrollHeight);
    });

    socket.on('memberCountUpdate', (data: obj) => {
        (
            document.getElementById('outChannelId') as HTMLHeadingElement
        ).innerText = fromName + ' -> #' + channelId + ` (${data.count})`;

        if (data.count === 2) {
            roomCountWasTwo = true;
        }

        if (roomCountWasTwo && data.count < 2) {
            leaveRoom();
        }
    });

    socket.on('typing', (data: obj) => {
        if (data.state === typingState.start) {
            (<HTMLParagraphElement>(
                document.getElementById('outTyping')
            )).innerText = data.from + ' schreibt...';
        } else if (data.state === typingState.end) {
            (<HTMLParagraphElement>(
                document.getElementById('outTyping')
            )).innerText = '';
        }
    });

    socket.on('ggRemote', (data: obj) => {
        console.log(data);
        // HACK kann ignoriert werden, da ggRemote-Class in js-Datei, aber types für GeoGebra-Applet schwierig sind
        //@ts-ignore
        ggRemote.execute(data);
    });

    socket.on('callEnded', (data: obj) => {
        console.log('end of call');
        leaveRoom();
    });
    // text/picture messages =========================================
}

function sendMessage() {
    if (channelId === '') return;
    const textContent: string = (<HTMLInputElement>(
        document.getElementById('inMessage')
    )).value;
    (<HTMLInputElement>document.getElementById('inMessage')).value = '';

    const li: HTMLLIElement = document.createElement('li');
    li.innerText = fromName + ': ' + textContent;
    li.classList.add('fromMe');

    (document.getElementById('lstOutput') as HTMLUListElement).appendChild(li);

    socket.emit('sendMessage', {
        message: textContent,
        roomId: channelId,
        from: fromName,
        type: dataType.text,
    });
    window.scrollTo(0, document.body.scrollHeight);
}

const toBase64 = (file: File) =>
    new Promise((resolve, reject) => {
        const reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = () => resolve(reader.result);
        reader.onerror = (error) => reject(error);
    });

async function sendImage() {
    if (channelId === '') return;
    const file: File = (<HTMLInputElement>document.getElementById('imgToSend'))
        .files![0];

    const base64File: string = <string>await toBase64(file);

    const li: HTMLLIElement = document.createElement('li');
    li.innerText = fromName + ': ';
    li.classList.add('fromMe');
    const img: HTMLImageElement = document.createElement('img');
    img.src = base64File;

    li.appendChild(img);
    (document.getElementById('lstOutput') as HTMLUListElement).appendChild(li);

    socket.emit('sendMessage', {
        message: base64File,
        roomId: channelId,
        from: fromName,
        type: dataType.picture,
    });
    (<HTMLInputElement>document.getElementById('imgToSend')).value = '';
    window.scrollTo(0, document.body.scrollHeight);
}

function leaveRoom() {
    endCall();
    socket.emit('leave', {
        roomId: channelId,
    });

    window.location.assign('/');
}

function typingStart() {
    socket.emit('typing', {
        roomId: channelId,
        from: fromName,
        state: typingState.start,
    });
}

function typingEnd() {
    socket.emit('typing', {
        roomId: channelId,
        from: fromName,
        state: typingState.end,
    });
}

function createInvite() {
    (<HTMLAnchorElement>document.getElementById('outInviteLink')).innerText =
        'invite: ' + window.location.href + 'join/' + channelId;
    (<HTMLAnchorElement>document.getElementById('outInviteLink')).href =
        window.location.href + 'join/' + channelId;
}

// dummy audio/video call ===============================

function startVoiceCall() {
    if (socketId === '') return;
    socket.emit('startVoiceCall', {
        from: socketId,
        roomId: channelId,
    });

    socket.on('goForCall', (data: obj) => {
        callPartner = data.to;
        doCall(data.to);
    });
}

var initPeer = (myId: string) => {};

var startListeningForCall = () => {};

var doCall = (targetID: string) => {};

var endCall = () => {};
