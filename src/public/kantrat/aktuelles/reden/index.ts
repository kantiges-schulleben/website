export {};

let page: number = 0;

function startup() {
    // Reden/Statements ===================================================================================
    $.get('/blog/reden/getArticles/0', (json: { [key: string]: any }[]) => {
        let count: number = 0;
        if (json.length > 0) {
            json.forEach((article: { [key: string]: any }) => {
                if (count >= 5) {
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
                const elmnt: HTMLAnchorElement = document.createElement('a') as HTMLAnchorElement;
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
                document.getElementById('redenParent') as HTMLDivElement
            ).appendChild(showAllSpeeches());
        } else {
            (document.getElementById('reden') as HTMLDivElement).appendChild(
                createNoContent('Das sind nicht die Reden, die du suchst.')
            );
        }
    });
}

function makeCallAndUpdateDOM() {
    $.get(
        `/blog/reden/getArticles/${page}`,
        (json: { [key: string]: any }[]) => {
            let count: number = 0;
            if (json.length > 0) {
                json.forEach((article: { [key: string]: any }) => {
                    if (count >= 5) {
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
            }
        }
    );
}
