// Variablen================================================================================================================================================
let timer: number;

// setup====================================================================================================================================================
function setup() {
    timer = window.setInterval(count, 10000);
    count();
}
// count====================================================================================================================================================
function count() {
    $.get('/shs/admin/count', function (data) {
        if (data == '') {
            window.clearInterval(timer);
        } else {
            (
                document.getElementById('counter') as HTMLParagraphElement
            ).innerText = data.count + ' angemeldete Schüler*innen';
        }
    });
}
// start script=============================================================================================================================================
function startScript() {
    if (confirm('Auswertung starten?')) {
        (document.getElementById('output') as HTMLParagraphElement).innerText =
            'auswertung gestartet...';
        $.get('/shs/admin/start', function (data: string) {
            if (data == '') {
                alert('Es ist ein Fehler aufgetreten.');
            } else {
                (
                    document.getElementById('output') as HTMLParagraphElement
                ).innerText = data;
            }
        });
    }
}
