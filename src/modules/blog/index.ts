import { Application, Request, Response } from 'express';
import * as types from '../../types';
import { use } from '../moduleManager/index';
import { encode } from 'html-entities';
import * as path from 'path';
import { config as editorConfig } from './editor';
import { parseMarkdown } from './markdown';

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

                    res.render('viewBlog', {
                        layout: 'index',
                        title: result[0]['title'],
                        content: parseMarkdown(result[0]['content']),
                        imagePath: result[0]['image'],
                        blogName: result[0]['name'],
                    });
                }
            );
        });
    });

    editorConfig(server, modules, rootPath);
}
