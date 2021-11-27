import { Application, Request, Response } from 'express';
import * as types from '../../types';
import * as path from 'path';
import * as fs from 'fs';
import { Server } from 'http';

let _modules: types.obj = {};
const moduleBlacklist: string[] = ['moduleManager', 'tmp'];

export function config(
    app: Application,
    modules: types.obj,
    rootPath: string,
    httpServer: Server
) {
    _modules = modules;
    // prüfen, ob der benutzer die nötigen berechtigungen hat, wenn ja, dann html für FE schicken
    app.get('/modules', (req: Request, res: Response) => {
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

    // prüfen, ob der benutzer die nötigen berechtigungen hat, wenn ja, dann name und status aller laufenden und nicht laufenden module als liste senden
    app.get('/modules/getall', (req: Request, res: Response) => {
        if (
            !(
                isLoggedIn(req) &&
                getSessionValue(req, 'berechtigung').includes('0')
            )
        ) {
            res.json({});
            return;
        }

        var output: types.obj = {};

        const runningModules: Array<string> = Object.keys(modules);

        fs.readdir(
            rootPath,
            function (err: NodeJS.ErrnoException | null, files: string[]) {
                if (err) {
                    res.json(output);
                    return console.log('Unable to scan directory: ' + err);
                }

                files.forEach(function (file: string) {
                    if (!moduleBlacklist.includes(file))
                        output[file] = {
                            running: runningModules.includes(file),
                        };
                });

                res.json(output);
            }
        );
    });

    // prüfen, ob der benutzer die nötigen berechtigungen hat, wenn ja, dann prüfen, ob gewünschtes modul existiert und dann stoppen => routes löschen und modul aus dem modules objekt löschen
    app.get('/modules/kill/:modulename', (req: Request, res: Response) => {
        if (
            !(
                isLoggedIn(req) &&
                getSessionValue(req, 'berechtigung').includes('0')
            )
        ) {
            res.json({ success: false });
            return;
        }

        fs.readFile(
            path.join(rootPath, req.params.modulename, 'module.json'),
            (error: NodeJS.ErrnoException | null, data: Buffer) => {
                if (error) {
                    console.log(error);
                    res.json({ success: false });
                    return;
                }
                const jsonData: types.obj = JSON.parse(data.toString());

                var routes: Array<string> = [];

                jsonData.routes.forEach((route: types.route) => {
                    routes.push(route.path);
                });

                let indexesToRemove: types.obj = {};

                for (let i = 0; i < app._router.stack.length; i++) {
                    if (app._router.stack[i].route != undefined) {
                        if (routes.includes(app._router.stack[i].route.path)) {
                            indexesToRemove[i] = 0x00;
                        }
                    }
                }

                // NOTE mit Array der indexe wird fehler geworfen
                const keysOfIndexesToRemove = Object.keys(indexesToRemove);

                for (let i = keysOfIndexesToRemove.length - 1; i >= 0; i--) {
                    app._router.stack.splice(keysOfIndexesToRemove[i], 1);
                }

                delete modules[req.params.modulename];

                jsonData.files.forEach((file: string) => {
                    delete require.cache[
                        require.resolve(
                            path.join(
                                rootPath,
                                `${req.params.modulename}/${file}`
                            )
                        )
                    ];
                });

                res.json({ success: true });
            }
        );
    });

    // prüfen, ob der benutzer die nötigen berechtigungen hat, wenn ja, dann gewünschtes modul starten
    app.get('/modules/start/:modulename', (req: Request, res: Response) => {
        if (
            !(
                isLoggedIn(req) &&
                getSessionValue(req, 'berechtigung').includes('0')
            )
        ) {
            res.json({ success: false });
            return;
        }

        const module: string = req.params.modulename;

        try {
            modules[module] = require(path.join(rootPath, `${module}/index`));
            modules[module].config(app, modules, rootPath, httpServer);
            res.json({ success: true });
        } catch (error: unknown) {
            console.log(error);
            res.json({ success: false });
        }
    });

    // prüfen, ob der benutzer die nötigen berechtigungen hat, wenn ja, dann informationen aus module.json senden
    app.get('/modules/info/:modulename', (req: Request, res: Response) => {
        if (
            !(
                isLoggedIn(req) &&
                getSessionValue(req, 'berechtigung').includes('0')
            )
        ) {
            res.json({ success: false });
            return;
        }

        fs.readFile(
            path.join(rootPath, req.params.modulename, 'module.json'),
            (error: NodeJS.ErrnoException | null, data: Buffer) => {
                if (error) {
                    console.log(error);
                    res.json({ success: false });
                    return;
                }
                const jsonData: types.obj = JSON.parse(data.toString());

                res.json({
                    success: true,
                    info: {
                        name: jsonData.name,
                        description: jsonData.description,
                        authors: jsonData.authors,
                        version: jsonData.version,
                        routes: jsonData.routes,
                        files: jsonData.files,
                    },
                });
            }
        );
    });
}

// ein modul objekt zurückgeben, sodass es an anderer stelle (callback) benutzt werden kann, wenn modul nicht läuft, passiert nichts
export function use(moduleName: string, callback: (module: types.obj) => void) {
    if (_modules[moduleName] != undefined) {
        callback(_modules[moduleName]);
    }
}

function getSessionValue(req: Request, key: string): any {
    return req.session == undefined ? undefined : (req.session as any)[key];
}

function isLoggedIn(req: Request): boolean {
    return getSessionValue(req, 'userID') != undefined;
}
