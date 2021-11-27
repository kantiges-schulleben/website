let blacklist = [];

class ggRemote {
    static init() {
        console.log('start');

        applet1.registerAddListener((identifier) => {
            if (blacklist.includes(identifier)) {
                removeFromBlacklist(identifier);
                return;
            }

            console.log('add:', identifier);
            // console.log(applet1.getCommandString(identifier, false));

            addToBlacklist(identifier);
            if (applet1.getObjectType(identifier) === 'point') {
                socket.emit('ggRemote', {
                    identifier: identifier,
                    instruction: {
                        type: 'point',
                        x: applet1.getXcoord(identifier),
                        y: applet1.getYcoord(identifier),
                    },
                    rawCommand: false,
                    color: applet1.getColor(identifier),
                    roomId: channelId,
                    from: fromName,
                });
            } else if (applet1.getObjectType(identifier) === 'penstroke') {
                addToBlacklist(identifier);
                socket.emit('ggRemote', {
                    identifier: identifier,
                    instruction:
                        identifier +
                        ': ' +
                        applet1.getCommandString(identifier, false),
                    rawCommand: true,
                    color: applet1.getColor(identifier),
                    roomId: channelId,
                    from: fromName,
                });
            } else {
                socket.emit('ggRemote', {
                    identifier: identifier,
                    instruction: applet1.getCommandString(identifier, false),
                    rawCommand: true,
                    color: applet1.getColor(identifier),
                    roomId: channelId,
                    from: fromName,
                });
            }
        });

        applet1.registerRemoveListener((identifier) => {
            console.log('remove:', identifier);
            socket.emit('ggRemote', {
                identifier: identifier,
                delete: true,
                rawCommand: false,
                roomId: channelId,
                from: fromName,
            });
        });

        applet1.registerUpdateListener((identifier) => {
            // if (blacklist.includes(identifier)) {
            //     removeFromBlacklist(identifier);
            //     return;
            // }

            console.log('update:', identifier);
            // console.log(applet1.getCommandString(identifier, false));
            // console.log(applet1.getObjectType(identifier));

            if (applet1.getObjectType(identifier) === 'point') {
                addToBlacklist(identifier);
                socket.emit('ggRemote', {
                    identifier: identifier,
                    instruction: {
                        type: 'point',
                        x: applet1.getXcoord(identifier),
                        y: applet1.getYcoord(identifier),
                    },
                    rawCommand: false,
                    color: applet1.getColor(identifier),
                    roomId: channelId,
                    from: fromName,
                });
            } else if (applet1.getObjectType(identifier) === 'penstroke') {
                addToBlacklist(identifier);
                socket.emit('ggRemote', {
                    identifier: identifier,
                    instruction:
                        identifier +
                        ': ' +
                        applet1.getCommandString(identifier, false),
                    rawCommand: true,
                    color: applet1.getColor(identifier),
                    roomId: channelId,
                    from: fromName,
                });
            }
        });
    }

    static execute(commandObject) {
        console.log(commandObject);

        if (commandObject.delete === true) {
            applet1.deleteObject(commandObject.identifier);
            return;
        }

        if (blacklist.includes(commandObject.identifier)) {
            removeFromBlacklist(commandObject.identifier);
            return;
        }

        let instruction = '';

        if (commandObject.rawCommand === false) {
            switch (commandObject.instruction.type) {
                case 'point':
                    instruction = `${commandObject.identifier}=(${commandObject.instruction.x}, ${commandObject.instruction.y})`;
                    break;
                default:
                    break;
            }
        } else {
            instruction = commandObject.instruction;
        }

        applet1.evalCommand(instruction);

        const color = intFromHexString(commandObject.color);

        applet1.setColor(
            commandObject.identifier,
            color.red,
            color.green,
            color.blue
        );
    }
}

function removeFromBlacklist(key) {
    const index = blacklist.indexOf(key);
    if (index > -1) {
        blacklist.splice(index, 1);
    }
}

function addToBlacklist(key) {
    blacklist.push(key);
}

function intFromHexString(hexString) {
    let output = {
        red: 0,
        green: 0,
        blue: 0,
    };

    output.red = parseInt(hexString.substring(1, 3), 16);
    output.green = parseInt(hexString.substring(3, 5), 16);
    output.blue = parseInt(hexString.substring(5, 7), 16);

    return output;
}
