//
// This is NodeJS code
//
// Example:
//
//     node vendor/pragmarx/sdk/src/Services/Chat/NodeJS/socket.js
//     node app/Services/Chat/Server/NodeJs/socket.js
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

    var text = '';

    if (typeof message.data != 'undefined' && message.data && typeof message.data.message != 'undefined')
    {
        if (typeof message.data.fullName != 'undefined' && message.data.fullName)
        {
            text += ' # '+message.data.fullName;
        }

        text += '> '+message.data.message;
    }

    console.log(channel + ': ' + message.event + text);

    io.emit(channel + ':' + message.event, message.data);
});

console.log('Listening port '+port+'...');

server.listen(port);
