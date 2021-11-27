var peer;
var voiceCall;

function overridePeerFunctions() {
    initPeer = (myId) => {
        peer = new Peer(myId);
    };

    startListeningForCall = () => {
        peer.on('call', function (call) {
            joinCall(false);
            navigator.getUserMedia(
                {
                    video: false,
                    audio: true,
                },
                function (stream) {
                    voiceCall = call;
                    voiceCall.answer(stream); // Answer the call with an A/V stream.
                    voiceCall.on('stream', function (remoteStream) {
                        // Show stream in some video/canvas element.
                        document.getElementById('videoOutput').srcObject =
                            remoteStream;
                    });
                },
                function (err) {
                    console.log('Failed to get local stream', err);
                }
            );
        });
    };

    doCall = (targetID) => {
        navigator.getUserMedia(
            {
                video: false,
                audio: true,
            },
            async function (stream) {
                voiceCall = await peer.call(targetID, stream);
                voiceCall.on('stream', function (remoteStream) {
                    // Show stream in some video/canvas element.
                    document.getElementById('videoOutput').srcObject =
                        remoteStream;
                });
            },
            function (err) {
                console.log('Failed to get local stream', err);
            }
        );
    };

    endCall = () => {
        if (voiceCall) voiceCall.close();
    };
}
