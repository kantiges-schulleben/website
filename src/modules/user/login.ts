import { Application, Request, Response } from 'express';
import * as types from '../../types';
import { encode } from 'html-entities';
import { compareSync } from 'bcryptjs';
import { use } from '../moduleManager/index';
import { getSessionValue, setSessionValue } from './session';

export function config(
    server: Application,
    modules: types.obj,
    rootPath: string
) {
    server.post('/login', (req: Request, res: Response) => {
        if (isLoggedIn(req)) {
            res.json({ success: false });
            return;
        }

        const USERNAME: string = encode(req.body.username, {
            mode: 'specialChars',
            level: 'html5',
        });

        const PASSWORD: string = encode(req.body.password, {
            mode: 'specialChars',
            level: 'html5',
        });

        use('databaseConnection', (module: types.obj) => {
            module.query(
                'SELECT * FROM benutzer WHERE benutzername LIKE ?',
                [USERNAME],
                (err: boolean, result: types.obj) => {
                    if (err) res.json({ success: false });

                    if (result.length > 0) {
                        if (compareSync(PASSWORD, result[0]['password'])) {
                            logIn(
                                req,
                                result[0]['id'],
                                USERNAME,
                                result[0]['berechtigung']
                            );
                            res.json({ success: true });
                        } else {
                            res.json({ success: false });
                        }
                    } else {
                        res.json({ success: false });
                    }
                }
            );
        });
    });
}

export function isLoggedIn(req: Request): boolean {
    return getSessionValue(req, 'userID') != undefined;
}

export function logIn(
    req: Request,
    id: number,
    username: string,
    berechtigung: string = ''
) {
    setSessionValue(req, 'userID', id);
    setSessionValue(req, 'username', username);
    setSessionValue(
        req,
        'berechtigung',
        berechtigung.split(',').filter((element: string) => {
            if (element != '') {
                return element;
            }
        })
    );
}
