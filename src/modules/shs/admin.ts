import { Application, Request, Response } from 'express';
import * as types from '../../types';
import { use } from '../moduleManager';
import * as path from 'path';
import { ChildProcessWithoutNullStreams, spawn } from 'child_process';

export function config(
    server: Application,
    modules: types.obj,
    rootPath: string
) {
    server.get('/shs/admin', (req: Request, res: Response) => {
        use('user', (user: types.obj) => {
            if (
                user.login.isLoggedIn(req) &&
                (user.session
                    .getSessionValue(req, 'berechtigung')
                    .includes('3') ||
                    user.session
                        .getSessionValue(req, 'berechtigung')
                        .includes('0'))
            ) {
                res.sendFile('admin.html', {
                    root: path.join(rootPath, 'shs', 'html'),
                });
            } else {
                res.redirect('/login');
            }
        });
    });

    server.get('/shs/admin/count', (req: Request, res: Response) => {
        use('user', (user: types.obj) => {
            if (
                user.login.isLoggedIn(req) &&
                (user.session
                    .getSessionValue(req, 'berechtigung')
                    .includes('3') ||
                    user.session
                        .getSessionValue(req, 'berechtigung')
                        .includes('0'))
            ) {
                use('databaseConnection', (database: types.obj) => {
                    database.query(
                        'SELECT COUNT(*) FROM shsAnmeldung',
                        ['empty'],
                        (err: boolean, result: types.obj) => {
                            if (err) {
                                res.json({ count: -1 });
                                return;
                            }

                            res.json({ count: result[0]['COUNT(*)'] });
                        }
                    );
                });
            } else {
                res.redirect('/login');
            }
        });
    });

    // TODO make work
    server.get('/shs/admin/start', (req: Request, res: Response) => {
        use('user', (user: types.obj) => {
            if (
                user.login.isLoggedIn(req) &&
                (user.session
                    .getSessionValue(req, 'berechtigung')
                    .includes('3') ||
                    user.session
                        .getSessionValue(req, 'berechtigung')
                        .includes('0'))
            ) {
                console.log('starting script');
                const process: ChildProcessWithoutNullStreams = spawn(
                    'python3',
                    ['test.py']
                );
                process.stdout.on('data', (data: any) => {
                    console.log(data);
                });
                res.json({ success: true });
            } else {
                res.redirect('/login');
            }
        });
    });
}
