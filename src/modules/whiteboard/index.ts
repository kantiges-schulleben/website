import { Application, Request, Response } from 'express';
import * as types from '../../types';
import { config as socketConfig, roomCounts } from './socket';
import { Server } from 'http';
import { use } from '../moduleManager';
import * as path from 'path';

import * as url from 'url';

export function config(
    server: Application,
    modules: types.obj,
    rootPath: string,
    httpServer: Server
) {
    socketConfig(httpServer);

    server.get('/whiteboard/joinRoom', (req: Request, res: Response) => {
        use('user', (user: types.obj) => {
            const roomID: string | undefined = user.session.getSessionValue(
                req,
                'roomId'
            );
            if (roomID !== undefined || roomID !== '') {
                if (user.login.isLoggedIn(req)) {
                    use('databaseConnection', (database: types.obj) => {
                        database.query(
                            'SELECT benutzername FROM benutzer WHERE id LIKE ?',
                            [user.session.getSessionValue(req, 'userID')],
                            (err: boolean, result: types.obj) => {
                                let username: string = '';
                                
                                if (err || result.length === 0) {
                                    username = '';
                                } else {
                                    username = result[0]['benutzername'];
                                }

                                res.json({
                                    isInvited: true,
                                    roomId: roomID,
                                    displayName: username,
                                });
                            }
                        );
                    });
                } else {
                    res.json({
                        isInvited: true,
                        roomId: roomID,
                        displayName: '',
                    });
                }
            } else {
                res.json({
                    isInvited: false,
                });
            }
        });
    });

    server.get('/shs/sessions', (req: Request, res: Response) => {
        use('user', (user: types.obj) => {
            if (user.login.isLoggedIn(req)) {
                res.sendFile('sessions.html', {
                    root: path.join(rootPath, 'whiteboard', 'html'),
                });
            } else {
                res.redirect('/login');
            }
        });
    });

    server.get('/whiteboard/createSession', (req: Request, res: Response) => {
        use('user', (user: types.obj) => {
            use('databaseConnection', (database: types.obj) => {
                database.query(
                    'SELECT * FROM handschlag WHERE id LIKE ?',
                    [user.session.getSessionValue(req, 'userID')],
                    (err: boolean, result: types.obj) => {
                        if (err || result.length === 0) {
                            res.json({ success: false });
                            return;
                        }

                        const roomID: string = newRoom();
                        const url: string = getFormattedUrl(req);

                        res.json({
                            success: true,
                            sessionLink: `${url}/whiteboard/${roomID}`,
                        });
                    }
                );
            });
        });
    });

    server.get('/whiteboard/:roomId', (req: Request, res: Response) => {
        // set session.roomId to req.params.roomId
        if (req.params.roomId != '') {
            use('user', (user: types.obj) => {
                user.session.setSessionValue(req, 'roomId', req.params.roomId);
                res.sendFile('whiteboard.html', {
                    root: path.join(rootPath, 'whiteboard', 'html'),
                });
            });
        } else {
            res.redirect('/error');
        }
    });
}

function newRoom(): string {
    const newChatRoomId: string = parseInt(
        (Math.random() * (9999999 - 1000000) + 1000000).toString()
    ).toString();
    roomCounts[newChatRoomId] = 0;
    return newChatRoomId;
}

function getFormattedUrl(req: Request): string {
    return url.format({
        protocol: req.protocol,
        host: req.get('host'),
    });
}
