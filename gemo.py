import os

if os.name == "nt":
    cwd = os.getcwd() + "\\"
    pass
else:
    cwd = os.getcwd() + "/"
    pass

path = input("path to modules directory relative to %s: " % cwd) + cwd[-1]

modulename = ""
while modulename == "":
    modulename = input("name of module: ").replace(" ", "")
    pass

description = input("description: ")
authors = input("authors (, as separator): ").split(",")
version = input("version (0.0.1): ")
version = "0.0.1" if version.replace(" ", "") == "" else version

# create dir
os.mkdir(path + modulename)

# create index.ts
filename = "\index.ts" if os.name == "nt" else "/index.ts"

linesIndexTs = [
    "import { Application, Request, Response } from 'express';\n",
    "import { Server } from 'http';\n",
    "import * as types from '../../types';\n",
    "\n",
    "export function config(\n",
    "    app: Application,\n",
    "    modules: types.obj,\n",
    "    rootPath: string\n",
    "    httpServer: Server\n",
    ") {\n",
    "    app.get('/ping', (req: Request, res: Response) => {\n",
    "        res.send('pong');\n",
    "    });\n",
    "}\n",
]

indexTs = open(path + modulename + filename, "w")
indexTs.writelines(linesIndexTs)
indexTs.close()

# write module.json
linesModuleJson = [
    '{\n',
    '    "name": "' + modulename + '",\n',
    '    "description": "' + description + '",\n',
    '    "authors": ' + str(authors).replace("'", '"') + ',\n',
    '    "version": "' + version + '",\n',
    '    "routes": [\n',
    '        {\n',
    '            "path": "/ping",\n',
    '            "type": "get"\n',
    '        }\n',
    '    ],\n',
    '    "files": ["index"]\n',
    '}'
]

filename = "\module.json" if os.name == "nt" else "/module.json"

moduleJson = open(path + modulename + filename, "w")
moduleJson.writelines(linesModuleJson)
moduleJson.close()