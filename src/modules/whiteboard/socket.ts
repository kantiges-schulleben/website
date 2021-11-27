import * as types from '../../types';
import { Server } from 'http';
import { Socket } from 'socket.io';
import { Application } from 'express';
// imports =========================================================
// vars =============================================================
export var roomCounts: types.obj = {};
var io;
// vars =============================================================
export function config(server: Server) {
    io = require('socket.io')(server);

    io.on('connection', (socket: Socket) => {
        socket.emit('dsn', {
            message: 'you are go for tli',
        });

        socket.on('huston', (data: types.obj) => {
            console.log(data);
        });
    });

    // namespace /chat
    const chatNamespace = io.of('/chat');

    chatNamespace.on('connection', (socket: Socket) => {
        socket.on('join', (data: types.obj) => {
            console.log(data);
            socket.join(data.roomId);
            if (Object.keys(roomCounts).includes(data.roomId)) {
                roomCounts[data.roomId]++;
            } else {
                roomCounts[data.roomId] = 1;
            }
            socket
                .to(data.roomId)
                .emit('memberCountUpdate', { count: roomCounts[data.roomId] });
            socket.emit('memberCountUpdate', {
                count: roomCounts[data.roomId],
            });
        });

        socket.on('getMyData', (data: types.obj) => {
            console.log('request to output socket data');
            socket.emit('getMyData', {
                id: socket.id,
            });
        });
        // text chat ===========================================================================
        socket.on('sendMessage', (data: types.obj) => {
            console.log(data);
            // socket.emit("gotMessage", data);
            socket.to(data.roomId).emit('gotMessage', data);
        });

        socket.on('typing', (data: types.obj) => {
            socket.to(data.roomId).emit('typing', data);
        });

        socket.on('leave', (data: types.obj) => {
            socket.leave(data.roomId);
            if (roomCounts[data.roomId] != undefined) {
                roomCounts[data.roomId]--;
                socket.to(data.roomId).emit('memberCountUpdate', {
                    count: roomCounts[data.roomId],
                });
            }
        });

        socket.on('ggRemote', (data: types.obj) => {
            console.log(data);
            // socket.emit("gotMessage", data);
            socket.to(data.roomId).emit('ggRemote', data);
        });
        // text chat ===========================================================================
        // voice chat ==========================================================================
        socket.on('startVoiceCall', (data: types.obj) => {
            socket.to(data.roomId).emit('incomingCall', {
                from: data.from,
            });
        });

        socket.on('answerCall', (data: types.obj) => {
            socket.to(data.to).emit('goForCall', {
                to: data.from,
            });
        });
        // voice chat ==========================================================================
        socket.on('disconnecting', () => {
            const rooms: Array<string> = Array.from(socket.rooms);
            for (let i = 1; i < rooms.length; i++) {
                if (roomCounts[rooms[i]] != undefined) {
                    roomCounts[rooms[i]]--;
                    socket.to(rooms[i]).emit('memberCountUpdate', {
                        count: roomCounts[rooms[i]],
                    });
                }
            }
        });
    });
}
