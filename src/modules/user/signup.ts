import { Application, Request, Response } from 'express';
import * as types from '../../types';
import { encode } from 'html-entities';
import { hashSync } from 'bcryptjs';
import { use } from '../moduleManager/index';
import { isLoggedIn, logIn } from './login';

export function config(
    server: Application,
    modules: types.obj,
    rootPath: string
) {
    server.post('/signup', (req: Request, res: Response) => {
        console.log(isLoggedIn(req));
        if (isLoggedIn(req)) {
            res.json({ success: false });
            return;
        }

        console.log(req.body);

        const FIRSTNAME: string = encode(req.body.firstname, {
            mode: 'specialChars',
            level: 'html5',
        });

        const LASTNAME: string = encode(req.body.lastname, {
            mode: 'specialChars',
            level: 'html5',
        });

        const USERNAME: string = encode(req.body.username, {
            mode: 'specialChars',
            level: 'html5',
        });

        const PASSWORD: string = encode(req.body.password, {
            mode: 'specialChars',
            level: 'html5',
        });

        const PASSWORD_CONFIRM: string = encode(req.body.passwdconfirm, {
            mode: 'specialChars',
            level: 'html5',
        });

        const MAIL: string = encode(req.body.mail, {
            mode: 'specialChars',
            level: 'html5',
        });

        if (PASSWORD !== PASSWORD_CONFIRM) {
            res.json({ success: false });
            return;
        }

        use('databaseConnection', (module: types.obj) => {
            module.query(
                'SELECT COUNT(*) FROM benutzer WHERE benutzername LIKE ?',
                [USERNAME],
                (err: boolean, result: types.obj) => {
                    if (err) {
                        res.json({ success: false });
                        return;
                    }

                    if (result[0]['COUNT(*)'] !== 0) {
                        res.json({ success: false });
                    } else {
                        module.query(
                            'INSERT INTO benutzer (name, password, benutzername, mail, berechtigung) VALUES (?, ?, ?, ?, ?)',
                            [
                                `${FIRSTNAME} ${LASTNAME}`,
                                hashSync(PASSWORD),
                                USERNAME,
                                MAIL,
                                ',',
                            ],
                            (_err: boolean, _result: types.obj) => {
                                if (_err) {
                                    res.json({ success: false });
                                    return;
                                }

                                if (_result['affectedRows'] > 0) {
                                    logIn(req, _result['insertId'], USERNAME);
                                    res.json({ success: true });
                                }
                            }
                        );
                    }
                }
            );
        });
    });
}
