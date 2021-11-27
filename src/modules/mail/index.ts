import { Application, Request, Response } from 'express';
import * as types from '../../types';

import { exec, ExecException } from 'child_process';
import * as path from 'path';

let ROOT_PATH: string = '';

export function config(
    app: Application,
    modules: types.obj,
    _rootPath: string
) {
    ROOT_PATH = _rootPath;

    app.post('/contact', (req: Request, res: Response) => {
        sendMail(
            'Kontaktformular',
            { name: 'kantiges-schulleben', mail: 'shs@kantgym-leipzig.de' },
            {
                name: `${req.body.fromNameFirst} ${req.body.fromNameLast}`,
                mail: req.body.fromMail,
            },
            `Mitteilung über Kontaktformular - ${req.body.fromNameFirst} ${req.body.fromNameLast}`,
            req.body.msg
        );
        res.redirect('/');
    });
}

export function sendMail(
    fromName: string,
    to: types.mailPerson,
    replyTo: types.mailPerson,
    subject: string,
    content: string
) {
    const FROM: types.mailPerson = {
        name: fromName,
        mail: 'kantiges-schulleben@gmx.de',
    };

    // console.log(JSON.stringify(MAIL_PARAMTERS));

    exec(
        // TODO make pretty
        `php ${path.join(ROOT_PATH, 'mail', 'php', 'mail.php')} "${
            FROM.name
        }" "${FROM.mail}" "${to.name}" "${to.mail}" "${replyTo.name}" "${
            replyTo.mail
        }" "${subject}" "${content}"`,
        function (error: ExecException | null, stdout: string, stderr: string) {
            if (error) {
                console.log(error);
                console.log(stderr);
                return;
            }

            console.log(stdout);
        }
    );
}
