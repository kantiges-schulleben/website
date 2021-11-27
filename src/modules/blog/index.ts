import { Application, Request, Response } from 'express';
import * as types from '../../types';
import { use } from '../moduleManager/index';
import { encode } from 'html-entities';
import * as path from 'path';
import { config as editorConfig } from './editor';

export function config(
    server: Application,
    modules: types.obj,
    rootPath: string
) {
    // <= 6 neuste Artikel eines blogs zurückgeben
    server.get(
        '/blog/:blogName/getArticles/:page',
        (req: Request, res: Response) => {
            const NAME_OF_BLOG: string = encode(req.params.blogName, {
                mode: 'specialChars',
                level: 'html5',
            });

            const PAGE: number = parseInt(req.params.page);

            use('databaseConnection', (module: types.obj) => {
                module.query(
                    `SELECT * from articles WHERE name LIKE ? ORDER BY date DESC LIMIT ${
                        6 * PAGE
                    },6`,
                    [NAME_OF_BLOG],
                    (err: boolean, result: types.obj) => {
                        if (err) {
                            res.json([]);
                        } else {
                            let output: types.obj[] = [];
                            result.forEach((article: types.obj) => {
                                output.push({
                                    title: encodeURIComponent(article.title),
                                    content: encodeURIComponent(
                                        article.content.substring(0, 256) +
                                            '...'
                                    ),
                                    image: encodeURIComponent(article.image),
                                    id: encodeURIComponent(article.id),
                                    name: encodeURIComponent(article.name),
                                });
                            });
                            res.json(output);
                        }
                    }
                );
            });
        }
    );

    // lesen eines Artikels vorbereiten
    server.get('/blog/:blogName/view/:id', (req: Request, res: Response) => {
        const ID: string = encode(req.params.id, {
            mode: 'specialChars',
            level: 'html5',
        });

        use('databaseConnection', (module: types.obj) => {
            module.query(
                'SELECT * from articles WHERE id LIKE ?',
                [ID],
                (err: boolean, result: types.obj) => {
                    if (err || result.length === 0) {
                        res.sendFile('./html/noContent.html', {
                            root: path.join(rootPath, 'blog'),
                        });
                        return;
                    }

                    use('user', (userModule: types.obj) => {
                        userModule.session.setSessionValue(req, 'article', ID);
                        res.sendFile('./html/view.html', {
                            root: path.join(rootPath, 'blog'),
                        });
                    });
                }
            );
        });
    });

    // Inhalt des Artukels senden
    server.get('/blog/readArticle', (req: Request, res: Response) => {
        use('user', (module: types.obj) => {
            const ID: string | undefined = module.session.getSessionValue(
                req,
                'article'
            );

            module.session.setSessionValue(req, 'article', undefined);

            if (ID === undefined) {
                res.json({
                    title: '',
                    content: '',
                    image: '',
                    id: '',
                    name: '',
                });
                return;
            }

            use('databaseConnection', (module: types.obj) => {
                module.query(
                    'SELECT * from articles WHERE id LIKE ?',
                    [ID],
                    (err: boolean, result: types.obj) => {
                        if (err || result.length === 0) {
                            res.json({
                                title: '',
                                content: '',
                                image: '',
                                id: '',
                                name: '',
                            });
                            return;
                        }

                        res.json({
                            title: encodeURIComponent(result[0]['title']),
                            content: encodeURIComponent(result[0]['content']),
                            image: encodeURIComponent(result[0]['image']),
                            id: encodeURIComponent(result[0]['id']),
                            name: encodeURIComponent(result[0]['name']),
                        });
                    }
                );
            });
        });
    });

    editorConfig(server, modules, rootPath);
}
