import { Application, Request, Response } from 'express';
import * as types from '../../types';
import { isLoggedIn, getSessionValue, use } from './index';
import { encode } from 'html-entities';

export function config(app: Application) {
    // prüfen, ob der benutzer die nötigen berechtigungen hat, wenn ja, dann name und status aller laufenden und nicht laufenden module als liste senden
    app.get('/berechtigungen/getall', (req: Request, res: Response) => {
        if (
            !(
                isLoggedIn(req) &&
                getSessionValue(req, 'berechtigung').includes('0')
            )
        ) {
            res.json({});
            return;
        }

        use('databaseConnection', (database: types.obj) => {
            database.query(
                'SELECT * FROM berechtigungen;',
                ['empty'],
                (err: boolean, result: types.obj) => {
                    if (err) {
                        res.json({});
                        return;
                    }
                    let output: obj[] = [];

                    result.forEach((berechtigung: types.obj) => {
                        output.push({
                            id: berechtigung['id'].toString(),
                            name: berechtigung['name'],
                        });
                    });

                    res.json({
                        berechtigungen: output,
                    });
                }
            );
        });
    });

    app.get('/berechtigungen/create/:name', (req: Request, res: Response) => {
        if (
            !(
                isLoggedIn(req) &&
                getSessionValue(req, 'berechtigung').includes('0')
            )
        ) {
            res.json({ sucess: false });
            return;
        }

        use('databaseConnection', (database: types.obj) => {
            database.query(
                'SELECT * FROM berechtigungen ORDER BY id DESC LIMIT 0, 1',
                ['empty'],
                (err: boolean, result: types.obj) => {
                    const NAME: string = encode(req.params.name, {
                        mode: 'specialChars',
                        level: 'html5',
                    });

                    const lastID: number = parseInt(result['0'].id) + 1;

                    database.query(
                        'INSERT INTO berechtigungen (name, id) VALUES (?, ?)',
                        [NAME, lastID],
                        (_err: boolean, _result: types.obj) => {
                            if (_err) {
                                res.json({ success: false });
                                return;
                            }

                            if (_result['affectedRows'] > 0) {
                                res.json({ success: true });
                            }
                        }
                    );
                }
            );
        });
    });
}
