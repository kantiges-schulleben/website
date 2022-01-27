import { Application, Request, Response } from 'express';
import * as types from '../../types';
import * as path from 'path';
import { Server } from 'http';
import { config as modulesConfig } from './modules';
import { config as userConfig } from './user';
import { config as berechtigungenConfig } from './berechtigungen';

let _modules: types.obj = {};

export function config(
    app: Application,
    modules: types.obj,
    rootPath: string,
    httpServer: Server
) {
    _modules = modules;
    // prüfen, ob der benutzer die nötigen berechtigungen hat, wenn ja, dann html für FE schicken
    app.get('/dev', (req: Request, res: Response) => {
        if (
            isLoggedIn(req) &&
            getSessionValue(req, 'berechtigung').includes('0')
        ) {
            res.sendFile('index.html', {
                root: path.join(rootPath, 'moduleManager', 'html'),
            });
        } else {
            res.redirect('/login');
        }
    });

    modulesConfig(app, modules, rootPath, httpServer);
    berechtigungenConfig(app);
    userConfig(app);
}

// ein modul objekt zurückgeben, sodass es an anderer stelle (callback) benutzt werden kann, wenn modul nicht läuft, passiert nichts
export function use(moduleName: string, callback: (module: types.obj) => void) {
    if (_modules[moduleName] != undefined) {
        callback(_modules[moduleName]);
    }
}

export function getSessionValue(req: Request, key: string): any {
    return req.session == undefined ? undefined : (req.session as any)[key];
}

export function isLoggedIn(req: Request): boolean {
    return getSessionValue(req, 'userID') != undefined;
}
