import { Request } from 'express';

export function setSessionValue(req: Request, key: string, value: any) {
    (req.session as any)[key] = value;
}

export function getSessionValue(req: Request, key: string): any {
    return req.session == undefined ? undefined : (req.session as any)[key];
}

export function killSession(req: Request) {
    req.session.destroy(() => {});
}
