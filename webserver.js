var http = require('http');

http.createServer(function (request, response) {
//  response.writeHead(200, {'Content-Type': 'text/plain'});

var buffer = [];
io.on('connection', function(client){
    client.send({ buffer: buffer });
    client.broadcast({ announcement: client.sessionId + ' connected' });

    client.on('message', function(message){
        var msg = { message: [client.sessionId, message] };
        buffer.push(msg);
        if (buffer.length > 15) buffer.shift();
        client.broadcast(msg);
    });

    client.on('disconnect', function(){
        client.broadcast({ announcement: client.sessionId + ' disconnected' });
    });
});


        response.writeHead(200, {'Content-Type': 'text/plain'});
	response.write('Its');
    setTimeout(function(){
      response.end('End of the World\n');
    }, 20000);






//  response.end('Hello World\n');


}).listen(30004);

console.log('Server running at http://127.0.0.1:30004/');
