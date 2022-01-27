export {};

function startup() {
    const numberOfArticlesToRender: number = 3;
    // Lokales ===================================================================================
    $.get('/blog/lokales/getArticles/0', (json: { [key: string]: any }[]) => {
        let count: number = 0;
        if (json.length > 0) {
            json.forEach((article: { [key: string]: any }) => {
                if (count >= numberOfArticlesToRender) {
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
                        `/blog/lokales/view/${decodeURIComponent(article.id)}`
                    )
                );
                count++;
            });

            const showAllSpeeches = () => {
                const elmnt: HTMLAnchorElement = document.createElement(
                    'a'
                ) as HTMLAnchorElement;
                elmnt.href = '../lokales';
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
    // interationales ===================================================================================
    $.get('/blog/internationales/getArticles/0', (json) => {
        let count: number = 0;
        if (json.length > 0) {
            json.forEach((article: { [key: string]: any }) => {
                if (count >= numberOfArticlesToRender) {
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
                        `/blog/internationales/view/${decodeURIComponent(
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
                elmnt.href = '../internationales';
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

    // empfehlungen ===================================================================================
    $.get('/blog/empfehlungen/getArticles/0', (json: { [key: string]: any }[]) => {
        let count: number = 0;
        if (json.length > 0) {
            json.forEach((article: { [key: string]: any }) => {
                if (count >= numberOfArticlesToRender) {
                    return;
                }

                (
                    document.getElementById('protokolle') as HTMLDivElement
                ).appendChild(
                    createStatement(
                        decodeURIComponent(article.title),
                        parseMarkdown(decodeURIComponent(article.content)),
                        decodeURIComponent(article.image) != ''
                            ? decodeURIComponent(article.image)
                            : '/images/default.png',
                        `/blog/empfehlungen/view/${decodeURIComponent(article.id)}`
                    )
                );
                count++;
            });

            const showAllSpeeches = () => {
                const elmnt: HTMLAnchorElement = document.createElement(
                    'a'
                ) as HTMLAnchorElement;
                elmnt.href = '../empfehlungen';
                elmnt.classList.add('button1');
                elmnt.innerText = 'Alle Beiträge anzeigen';

                return elmnt;
            };
            (
                document.getElementById('protokolleParent') as HTMLDivElement
            ).appendChild(showAllSpeeches());
        } else {
            (document.getElementById('protokolle') as HTMLDivElement).appendChild(
                createNoContent('Das sind nicht die protokolle, die du suchst.')
            );
        }
    });
}
