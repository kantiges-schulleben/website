export {};
let page: number = 0;

function startup() {
    // Reden/Statements ===================================================================================
    $.get(
        '/blog/schuelerrat/getArticles/0',
        (json: { [key: string]: any }[]) => {
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
                    elmnt.href = 'javascript:void(0);';
                    elmnt.addEventListener('click', () => {
                        page++;
                        makeCallAndUpdateDOM();
                    });
                    elmnt.classList.add('button1');
                    elmnt.innerText = 'weitere Beiträge anzeigen';

                    return elmnt;
                };

                (
                    document.getElementById(
                        'relevantesParent'
                    ) as HTMLDivElement
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
        }
    );
}

function makeCallAndUpdateDOM() {
    $.get(
        `/blog/relevantes/getArticles/${page}`,
        (json: { [key: string]: any }[]) => {
            var count = 0;
            if (json.length > 0) {
                json.forEach((article: { [key: string]: any }) => {
                    if (count >= 5) {
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
            }
        }
    );
}
