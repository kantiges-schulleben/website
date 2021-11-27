import { Application, Request, Response } from 'express';
import * as types from '../../types';

import * as mysql from 'mysql';

var connection: any;

export function config(
    server: Application,
    modules: types.obj,
    rootPath: string
) {
    connect();
}

// Datanbankverbindung aufbauen und falls sie verloren geht wieder herstellen
export function connect() {
    connection = mysql.createConnection({
        host: process.env.SQL_SERVER,
        user: process.env.SQL_USER,
        password: process.env.SQL_PASSWORD,
        database: process.env.SQL_DATABASE,
        port: parseInt(process.env.SQL_PORT || '3306'),
    });

    connection.connect((err: Error) => {
        console.log('connected');
    });

    connection.on('error', function onError(err: mysql.MysqlError) {
        console.log('connection error', err);
        if (
            err.code == 'PROTOCOL_CONNECTION_LOST' ||
            err.code == 'ECONNRESET'
        ) {
            connect();
        }
    });
}

// übergebene SQL-query auf die verbindung anwenden
export function query(
    query: string,
    escape: Array<string>,
    callback: (error: boolean, param: types.obj) => void
) {
    connection.query(query, escape, (err: Error, result: any) => {
        if (err) {
            console.log('sql error', err);
            callback(true, {});
            return;
        }
        callback(false, result);
    });
}
