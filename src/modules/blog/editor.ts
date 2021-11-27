import { Application, Request, Response } from 'express';
import * as types from '../../types';
import { use } from '../moduleManager/index';
import { encode } from 'html-entities';
import * as path from 'path';
import * as formidable from 'formidable';
import IncomingForm from 'formidable/Formidable';
import * as fs from 'fs';

let UPLOAD_PATH: string = '';

export function config(
    server: Application,
    modules: types.obj,
    rootPath: string
) {
    UPLOAD_PATH = path.join(rootPath, 'images', 'src');

    server.get('/editor/:blogName', (req: Request, res: Response) => {
        use('user', (user: types.obj) => {
            const BERECHTIGUNGEN: string[] = user.session.getSessionValue(
                req,
                'berechtigung'
            );

            if (BERECHTIGUNGEN.includes('0' /* dev */)) {
                user.session.setSessionValue(req, 'blog', req.params.blogName);
                res.sendFile('./html/editor.html', {
                    root: path.join(rootPath, 'blog'),
                });
                return;
            }

            use('databaseConnection', (database: types.obj) => {
                database.query(
                    'SELECT id FROM berechtigungen WHERE name LIKE ?',
                    [req.params.blogName],
                    (err: boolean, result: types.obj) => {
                        console.log(result);
                        if (err || result.length === 0) {
                            res.redirect('/editor/noBerechtigung.html');
                            return;
                        }

                        if (
                            BERECHTIGUNGEN.includes(result[0]['id']).toString()
                        ) {
                            user.session.setSessionValue(
                                req,
                                'blog',
                                req.params.blogName
                            );
                            res.sendFile('./html/editor.html', {
                                root: path.join(rootPath, 'blog'),
                            });
                        } else {
                            res.redirect('/editor/noBerechtigung.html');
                        }
                    }
                );
            });
        });
    });

    server.get('/blog/getCurrentBlog', (req: Request, res: Response) => {
        use('user', (user: types.obj) => {
            res.json({ blog: user.session.getSessionValue(req, 'blog') });
            user.session.setSessionValue(req, 'blog', undefined);
        });
    });

    server.post(
        '/editor/:blogName/saveArticle',
        (req: Request, res: Response) => {
            const FORM: IncomingForm = new formidable.IncomingForm({
                uploadDir: path.join(rootPath, 'tmp'),
                keepExtensions: true,
                hash: 'sha256',
            });
            FORM.parse(
                req,
                (
                    error: any,
                    fields: formidable.Fields,
                    files: formidable.Files
                ) => {
                    if (error) {
                        console.log('parse error');
                        res.redirect('/editor/error.html');
                        return;
                    }

                    use('databaseConnection', (database: types.obj) => {
                        const BLOG_NAME: string = req.params.blogName;
                        // prüfen, ob der Benutzer die nötigen Berechtigungen hat, einen Eintrag zu erstellen
                        database.query(
                            'SELECT id FROM berechtigungen WHERE name LIKE ?',
                            [BLOG_NAME],
                            (err: boolean, result: types.obj) => {
                                if (err) {
                                    console.log('use db');
                                    res.redirect('/editor/error.html');
                                    return;
                                }

                                const BLOG_BERECHTIGUNG: string =
                                    result[0]['id'].toString();
                                use('user', (user: types.obj) => {
                                    if (
                                        user.login.isLoggedIn(req) &&
                                        (user.session
                                            .getSessionValue(
                                                req,
                                                'berechtigung'
                                            )
                                            .includes(BLOG_BERECHTIGUNG) ||
                                            user.session
                                                .getSessionValue(
                                                    req,
                                                    'berechtigung'
                                                )
                                                .includes('0' /* dev */))
                                    ) {
                                        // prüfen, ob alle benötigten Felder gesetzt sind i.e. title, content
                                        if (areRequirementsMet(fields)) {
                                            const TITLE: string = encode(
                                                fields.title as
                                                    | string
                                                    | undefined,
                                                {
                                                    mode: 'specialChars',
                                                    level: 'html5',
                                                }
                                            );
                                            const CONTENT: string = encode(
                                                fields.content as
                                                    | string
                                                    | undefined,
                                                {
                                                    mode: 'specialChars',
                                                    level: 'html5',
                                                }
                                            );

                                            const TAGS: string = encode(
                                                (fields.tags as
                                                    | string
                                                    | undefined) !== undefined
                                                    ? (fields.tags as
                                                          | string
                                                          | undefined)
                                                    : '',
                                                {
                                                    mode: 'specialChars',
                                                    level: 'html5',
                                                }
                                            );

                                            const USER_ID: string = user.session
                                                .getSessionValue(req, 'userID')
                                                .toString();

                                            // hochgeladenes bild in den src ordner des images modules verschieben
                                            moveFile(
                                                files,
                                                (MV_FILE: types.obj) => {
                                                    if (MV_FILE.success) {
                                                        // artikel in der datenbank speichern
                                                        database.query(
                                                            'INSERT INTO articles (title, author, content, image, name, tags) VALUES (?, ?, ?, ?, ?, ?)',
                                                            [
                                                                TITLE,
                                                                USER_ID,
                                                                CONTENT,
                                                                path.join(
                                                                    '/images',
                                                                    MV_FILE.newName
                                                                ),
                                                                BLOG_NAME,
                                                                TAGS,
                                                            ],
                                                            (
                                                                _err: boolean,
                                                                _result: types.obj
                                                            ) => {
                                                                if (_err) {
                                                                    removeFile(
                                                                        files
                                                                    );
                                                                    res.redirect(
                                                                        '/editor/error.html'
                                                                    );
                                                                }

                                                                use(
                                                                    'images',
                                                                    (
                                                                        images: types.obj
                                                                    ) => {
                                                                        images.updateImageCache(
                                                                            MV_FILE.newName
                                                                        );
                                                                    }
                                                                );

                                                                res.redirect(
                                                                    '/editor/success.html'
                                                                );
                                                            }
                                                        );
                                                    } else {
                                                        removeFile(files);
                                                        res.redirect(
                                                            '/editor/error.html'
                                                        );
                                                    }
                                                }
                                            );
                                        } else {
                                            console.log('requirements');
                                            res.redirect('/editor/error.html');
                                        }
                                    } else {
                                        removeFile(files);
                                        console.log('use user');
                                        res.redirect('/editor/error.html');
                                    }
                                });
                            }
                        );
                    });
                }
            );
        }
    );
}

function areRequirementsMet(fields: formidable.Fields): boolean {
    let goNoGo: boolean = true;

    const REQUIREMENTS: string[] = ['title', 'content'];
    REQUIREMENTS.forEach((key: string) => {
        if (!Object.keys(fields).includes(key)) {
            goNoGo = false;
        }
    });

    return goNoGo;
}

function moveFile(
    files: formidable.Files,
    callback: (moveData: types.obj) => void
) {
    const OLD_PATH: string = (files['imagefile[]'] as formidable.File).path;
    fs.rename(
        OLD_PATH,
        path.join(
            UPLOAD_PATH,
            (files['imagefile[]'] as formidable.File).hash! +
                '.' +
                (files['imagefile[]'] as formidable.File).name!.split('.')[
                    (files['imagefile[]'] as formidable.File).name!.split('.')
                        .length - 1
                ]
        ),
        (err) => {
            if (err) {
                console.log(err);
                callback({ success: false });
            }
            callback({
                success: true,
                newName:
                    (files['imagefile[]'] as formidable.File).hash! +
                    '.' +
                    (files['imagefile[]'] as formidable.File).name!.split('.')[
                        (files['imagefile[]'] as formidable.File).name!.split(
                            '.'
                        ).length - 1
                    ],
            });
        }
    );
}

function removeFile(files: formidable.Files) {
    const OLD_PATH: string = (files['imagefile[]'] as formidable.File).path;
    fs.unlink(OLD_PATH, (err) => {
        if (err) {
            console.log(err);
        }
    });
}
