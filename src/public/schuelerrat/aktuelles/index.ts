export {};

function startup() {
    // Reden/Statements ===================================================================================
    $.get('/blog/reden/getArticles/0', (json: { [key: string]: any }[]) => {
        let count: number = 0;
        if (json.length > 0) {
            json.forEach((article: { [key: string]: any }) => {
                if (count >= 2) {
                    return;
                }

                (
                    document.getElementById('reden') as HTMLDivElement
                ).appendChild(
                    createStatement(
                        decodeURIComponent(article.title),
                        parseMarkdown(decodeURIComponent(article.content)),
                        decodeURIComponent(article.image) != ''
                            ? decodeURIComponent(article.image)
                            : '/images/default.png',
                        `/blog/reden/view/${decodeURIComponent(article.id)}`
                    )
                );
                count++;
            });

            // <a href="./reden/index.php" class="button1">Alle Beiträge anzeigen</a> -->
            const showAllSpeeches = () => {
                const elmnt: HTMLAnchorElement = document.createElement(
                    'a'
                ) as HTMLAnchorElement;
                elmnt.href = './reden';
                elmnt.classList.add('button1');
                elmnt.innerText = 'Alle Beiträge anzeigen';

                return elmnt;
            };
            (
                document.getElementById('redenParent') as HTMLDivElement
            ).appendChild(showAllSpeeches());
        } else {
            (document.getElementById('reden') as HTMLDivElement).appendChild(
                createNoContent('Das sind nicht die Reden, die du suchst.')
            );
        }
    });

    // Relevantes ===================================================================================
    $.get('/blog/relevantes/getArticles/0', (json) => {
        let count: number = 0;
        if (json.length > 0) {
            json.forEach((article: { [key: string]: any }) => {
                if (count >= 2) {
                    return;
                }

                (
                    document.getElementById('relevantes') as HTMLDivElement
                ).appendChild(
                    createStatement(
                        decodeURIComponent(article.title),
                        parseMarkdown(decodeURIComponent(article.content)),
                        decodeURIComponent(article.image) != ''
                            ? decodeURIComponent(article.image)
                            : '/images/default.png',
                        `/blog/relevantes/view/${decodeURIComponent(
                            article.id
                        )}`
                    )
                );
                count++;
            });

            // <a href="./reden/index.php" class="button1">Alle Beiträge anzeigen</a> -->
            const showAllSpeeches = () => {
                const elmnt: HTMLAnchorElement = document.createElement(
                    'a'
                ) as HTMLAnchorElement;
                elmnt.href = './relevantes';
                elmnt.classList.add('button1');
                elmnt.innerText = 'Alle Beiträge anzeigen';

                return elmnt;
            };
            (
                document.getElementById('relevantesParent') as HTMLDivElement
            ).appendChild(showAllSpeeches());
        } else {
            (
                document.getElementById('relevantes') as HTMLDivElement
            ).appendChild(
                createNoContent(
                    'Gehen Sie weiter. Hier gibt es nichts relevantes zu sehen!'
                )
            );
        }
    });

    // Protokolle ===================================================================================
    (document.getElementById('protokolle') as HTMLDivElement).appendChild(
        createNoContent('Unmöglich. Vielleicht sind die Archive unvollständig.')
    );
    return;
    for (let i = 0; i < 9; i++) {
        (document.getElementById('protokolle') as HTMLDivElement).appendChild(
            createDownloadProtokoll(
                `Protokoll ${i}`,
                '09.05.2021',
                '#Protokolle'
            )
        );
    }
}
