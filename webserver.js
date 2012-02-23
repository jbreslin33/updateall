var http = require('http');

http.createServer(function (request, response) {
//  response.writeHead(200, {'Content-Type': 'text/plain'});
    setTimeout(function(){
        response.writeHead(200, {'Content-Type': 'text/plain'});
      response.end('End of the World\n');
    }, 20000);


//  response.end('Hello World\n');


}).listen(30004);

console.log('Server running at http://127.0.0.1:30004/');
