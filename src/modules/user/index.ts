import { Application, Request, Response } from 'express';
import * as types from '../../types';
import { encode } from 'html-entities';
import { use } from '../moduleManager/index';
import { config as loginConfig } from './login';
import { config as signupConfig } from './signup';
import { killSession } from './session';

export function config(
    server: Application,
    modules: types.obj,
    rootPath: string
) {
    // TODO comments
    server.get(
        '/checkUsernameExists/:username',
        (req: Request, res: Response) => {
            const USERNAME: string = encode(req.params.username, {
                mode: 'specialChars',
                level: 'html5',
            });

            use('databaseConnection', (module: types.obj) => {
                module.query(
                    'SELECT COUNT(*) FROM benutzer WHERE benutzername LIKE ?',
                    [USERNAME],
                    (err: boolean, result: types.obj) => {
                        if (err) res.json({ exists: true });
                        res.json({
                            exists: result[0]['COUNT(*)'] > 0,
                        });
                    }
                );
            });
        }
    );

    server.get('/logout', (req: Request, res: Response) => {
        killSession(req);
        res.redirect('/');
    });

    server.get('/kontoSubMenuInfo', (req: Request, res: Response) => {
        const BESONDERE_BERECHTIGUNGEN: types.obj = {
            '0': {
                target: '<li><a href="/modules">moduleManager</a></li>',
            },
            '3': {
                target: '<li><a href="/shs/admin">ShS Auswertung</a></li>',
            },
        };

        use('user', (user: types.obj) => {
            if (user.login.isLoggedIn(req)) {
                const userBerechtigungen: string[] =
                    user.session.getSessionValue(req, 'berechtigung');

                const IS_DEV: boolean = userBerechtigungen.includes('0');

                const USERNAME: string = user.session.getSessionValue(
                    req,
                    'username'
                );

                if (userBerechtigungen.length === 0) {
                    res.json({
                        username: USERNAME,
                        links: ['<li><a href="/logout">Logout</a></li>'],
                    });
                    return;
                }

                use('databaseConnection', (database: types.obj) => {
                    let output: string[] = [
                        '<li><a href="/logout">Logout</a></li>',
                    ];

                    database.query(
                        'SELECT * FROM berechtigungen;',
                        ['empty'],
                        (err: boolean, result: types.obj) => {
                            if (err) {
                                res.json({
                                    username: USERNAME,
                                    links: output,
                                });
                                return;
                            }

                            result.forEach((berechtigung: types.obj) => {
                                if (
                                    IS_DEV ||
                                    userBerechtigungen.includes(
                                        berechtigung['id'].toString()
                                    )
                                ) {
                                    if (
                                        Object.keys(
                                            BESONDERE_BERECHTIGUNGEN
                                        ).includes(
                                            berechtigung['id'].toString()
                                        )
                                    ) {
                                        output.push(
                                            BESONDERE_BERECHTIGUNGEN[
                                                berechtigung['id'].toString()
                                            ].target
                                        );
                                    } else {
                                        output.push(
                                            `<li><a href="/editor/${berechtigung['name']}">Eintrag ${berechtigung['name']}</a></li>`
                                        );
                                    }
                                }
                            });
                            res.json({
                                username: USERNAME,
                                links: output,
                            });
                        }
                    );
                });
            } else {
                res.json({
                    username: 'Konto',
                    links: [
                        '<li><a href="/login">Login</a></li>',
                        '<li><a href="/signup">Registrierung</a></li>',
                    ],
                });
                return;
            }
        });
    });

    loginConfig(server, modules, rootPath);
    signupConfig(server, modules, rootPath);
}

export * as session from './session';
export * as login from './login';
