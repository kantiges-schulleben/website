import { Application } from 'express';
import * as types from '../../types';

import { createPool, MysqlError, Pool, PoolConnection } from 'mysql';

let pool: Pool | undefined;

export function config(
    server: Application,
    modules: types.obj,
    rootPath: string
) {
    connect();
}

// Datanbankverbindung aufbauen und falls sie verloren geht wieder herstellen
function connect() {
    pool = createPool({
        host: process.env.SQL_SERVER,
        user: process.env.SQL_USER,
        password: process.env.SQL_PASSWORD,
        database: process.env.SQL_DATABASE,
        port: parseInt(process.env.SQL_PORT || '3306'),
    });
}

// übergebene SQL-query auf die verbindung anwenden
export function query(
    query: string,
    escape: Array<string>,
    callback: (error: boolean, param: types.obj) => void
) {
    pool?.getConnection(
        (err: MysqlError | null, connection: PoolConnection) => {
            if (err) {
                console.log('connection error', err);
                callback(true, {});
                return;
            }

            connection.query(
                query,
                escape,
                (_err: MysqlError | null, _result: any) => {
                    if (_err) {
                        console.log('sql error', _err);
                        callback(true, {});
                        return;
                    }
                    callback(false, _result);
                }
            );
        }
    );
}
