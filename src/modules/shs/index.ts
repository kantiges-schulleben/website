import { Application, Request, Response } from 'express';
import * as types from '../../types';
import { use } from '../moduleManager';
import * as path from 'path';
import { config as adminConfig } from './admin';
import { emailText } from './emailText';

export function config(
    server: Application,
    modules: types.obj,
    rootPath: string
) {
    adminConfig(server, modules, rootPath);

    // prüfen, ob der benutzer angemeldet ist, wenn ja, dann prüfen, ob alle daten valide sind, dann in db eintragen + success mail versenden
    server.post('/shs/enroll', (req: Request, res: Response) => {
        if (areRequirenmentsMet(req)) {
            use('user', (user: types.obj) => {
                if (user.login.isLoggedIn(req)) {
                    use('databaseConnection', (database: types.obj) => {
                        let ZIEL_KLASSE: string = req.body.ziel;
                        ZIEL_KLASSE = ZIEL_KLASSE.replace(/\D+$/, '');
                        if (ZIEL_KLASSE === '') {
                            ZIEL_KLASSE = '0';
                        }

                        database.query(
                            'INSERT INTO shsAnmeldung (name, klasse, mail, telefon, nachhilfe, fach, zeit, einzelnachhilfe, zielKlasse, accountID) VALUES (?, ?, ?, ?, ?, ?, 8191, ?, ?, ?)',
                            [
                                req.body.name,
                                req.body.klasse,
                                req.body.mail,
                                req.body.telefon,
                                req.body.nachhilfe,
                                req.body.fach,
                                req.body.einzelnachhilfe,
                                ZIEL_KLASSE,
                                user.session.getSessionValue(req, 'userID'),
                            ],
                            (err: boolean, result: types.obj) => {
                                if (err) {
                                    res.json({ success: false });
                                    return;
                                }

                                use('mail', (mail: types.obj) => {
                                    mail.sendMail(
                                        'ShS-Team',
                                        {
                                            name: req.body.name,
                                            mail: req.body.mail,
                                        },
                                        {
                                            name: 'ShS-Team',
                                            mail: 'shs@kantgym-leipzig.de',
                                        },
                                        'Anmeldebestätigung',
                                        emailText.get('bestMail', 'bestMail', {
                                            name: req.body.name,
                                        })
                                    );
                                });
                                res.json({ success: true });
                            }
                        );
                    });
                } else {
                    res.json({ success: false });
                }
            });
        } else {
            res.json({ success: false });
        }
    });

    server.get('/shs/anmeldung', (req: Request, res: Response) => {
        use('user', (user: types.obj) => {
            if (user.login.isLoggedIn(req)) {
                res.sendFile('anmeldung.html', {
                    root: path.join(rootPath, 'shs', 'html'),
                });
            } else {
                res.redirect('/login');
            }
        });
    });
}

function areRequirenmentsMet(req: Request): boolean {
    const NEEDED: string[] = [
        'name',
        'klasse',
        'mail',
        'telefon',
        'nachhilfe',
        'fach',
        'einzelnachhilfe',
    ];

    let areMet: boolean = true;

    NEEDED.forEach((field: string) => {
        if (req.body[field] === undefined) {
            areMet = false;
        }
    });

    return areMet;
}
