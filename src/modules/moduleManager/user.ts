import { Application, Request, Response } from 'express';
import * as types from '../../types';
import { isLoggedIn, getSessionValue, use } from './index';
import { encode } from 'html-entities';

export function config(app: Application) {
    // prüfen, ob der benutzer die nötigen berechtigungen hat, wenn ja, dann name und status aller laufenden und nicht laufenden module als liste senden
    app.post('/searchUser', (req: Request, res: Response) => {
        if (
            !(
                isLoggedIn(req) &&
                getSessionValue(req, 'berechtigung').includes('0')
            )
        ) {
            res.json({ userlist: [] });
            return;
        }

        const USERNAME: string = encode(req.body.username, {
            mode: 'specialChars',
            level: 'html5',
        });

        use('databaseConnection', (database: types.obj) => {
            database.query(
                'SELECT benutzername, id, name FROM benutzer where benutzername LIKE ?;',
                [`%${USERNAME}%`],
                (err: boolean, result: types.obj) => {
                    if (err) {
                        res.json({ userlist: [] });
                        return;
                    }

                    res.json({ userlist: result });
                }
            );
        });
    });

    app.get('/userdata/:userID', (req: Request, res: Response) => {
        if (
            !(
                isLoggedIn(req) &&
                getSessionValue(req, 'berechtigung').includes('0')
            )
        ) {
            res.json({ userdata: {}, berechtigungen: {} });
            return;
        }

        const USER_ID: string = encode(req.params.userID, {
            mode: 'specialChars',
            level: 'html5',
        });

        use('databaseConnection', (database: types.obj) => {
            database.query(
                'SELECT benutzername, id, name, mail, berechtigung FROM benutzer where id LIKE ?;',
                [USER_ID],
                (err: boolean, result: types.obj) => {
                    if (err) {
                        res.json({ userdata: {}, berechtigungen: {} });
                        return;
                    }
                    database.query(
                        'SELECT * FROM berechtigungen',
                        ['empty'],
                        (_err: boolean, _result: types.obj) => {
                            if (_err) {
                                res.json({ userdata: {}, berechtigungen: {} });
                                return;
                            }

                            if (result.length > 0 && _result.length > 0) {
                                res.json({
                                    userdata: result[0],
                                    berechtigungen: objectListToObject(
                                        _result as types.obj[]
                                    ),
                                });
                            } else {
                                res.json({ userdata: {}, berechtigungen: {} });
                            }
                        }
                    );
                }
            );
        });
    });

    app.post('/updateUser/:userID', (req: Request, res: Response) => {
        if (
            !(
                isLoggedIn(req) &&
                getSessionValue(req, 'berechtigung').includes('0')
            )
        ) {
            res.json({ success: false });
            return;
        }

        const USER_ID: string = encode(req.params.userID, {
            mode: 'specialChars',
            level: 'html5',
        });

        const MAIL: string = encode(req.body.mail, {
            mode: 'specialChars',
            level: 'html5',
        });

        const NAME: string = encode(req.body.name, {
            mode: 'specialChars',
            level: 'html5',
        });

        const BERECHTIGUNGEN: string = encode(req.body.berechtigungen, {
            mode: 'specialChars',
            level: 'html5',
        });

        use('databaseConnection', (database: types.obj) => {
            database.query(
                'UPDATE benutzer SET name=?, mail=?, berechtigung=? WHERE id = ?',
                [NAME, MAIL, BERECHTIGUNGEN, USER_ID],
                (err: boolean, result: types.obj) => {
                    if (err) {
                        res.json({ success: false });
                        return;
                    }

                    res.json({ success: result['affectedRows'] > 0 });
                }
            );
        });
    });

    app.get('/deleteUser/:userID', (req: Request, res: Response) => {
        if (
            !(
                isLoggedIn(req) &&
                getSessionValue(req, 'berechtigung').includes('0')
            )
        ) {
            res.json({ success: false });
            return;
        }

        const USER_ID: string = encode(req.params.userID, {
            mode: 'specialChars',
            level: 'html5',
        });

        use('databaseConnection', (database: types.obj) => {
            database.query(
                'DELETE FROM benutzer WHERE id = ?',
                [USER_ID],
                (err: boolean, result: types.obj) => {
                    if (err) {
                        res.json({ userdata: {}, berechtigungen: {} });
                        return;
                    }

                    res.json({ success: result['affectedRows'] > 0 });
                }
            );
        });
    });
}

function objectListToObject(lst: types.obj[]): types.obj {
    let output: types.obj = {};

    lst.forEach((berechtigung: types.obj) => {
        output[`${berechtigung.id}`] = berechtigung.name;
    });

    return output;
}
