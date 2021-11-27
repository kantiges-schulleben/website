import { Application, Request, Response } from 'express';
import * as types from '../../types';
import * as path from 'path';
import * as fs from 'fs';

let cache: string[] = [];
let SRC_PATH: string = '';

export function config(
    server: Application,
    modules: types.obj,
    rootPath: string
) {
    SRC_PATH = path.join(rootPath, 'images', 'src');
    updateImageCache();

    // falls existent das gewünschte bild senden, sonst ein festgelegtes standartbild
    server.get('/images/:filename', (req: Request, res: Response) => {
        if (cache.includes(req.params.filename)) {
            res.sendFile(req.params.filename, {
                root: SRC_PATH,
            });
        } else {
            res.sendFile('default.png', {
                root: SRC_PATH,
            });
        }
    });
}

// liste der existenten Bilddateien updaten oder erstellen
export function updateImageCache(fileName: string = '') {
    if (fileName === '') {
        cache = [];
        fs.readdir(
            SRC_PATH,
            function (err: NodeJS.ErrnoException | null, files: string[]) {
                if (err) {
                    return console.log('Unable to scan directory: ' + err);
                }

                files.forEach(function (file: string) {
                    cache.push(file);
                });
            }
        );
    } else {
        cache.push(fileName);
    }
}
