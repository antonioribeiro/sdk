//
// This is NodeJS code
//
// Example:
//
//     node vendor/pragmarx/sdk/src/Services/Chat/NodeJS/socket.js
//
//

var port = 23172;

var server = require('http').Server();

var io = require('socket.io')(server);

var Redis = require('ioredis');

var redis = new Redis();

redis.subscribe('chat-channel');

redis.on('message', function(channel, message)
{
    message = JSON.parse(message);

    console.log(channel + ': ' + message.data.username+'> '+message.data.message);

    io.emit(channel + ':' + message.event, message.data);
});

console.log('Listening port '+port+'...');

server.listen(port);
