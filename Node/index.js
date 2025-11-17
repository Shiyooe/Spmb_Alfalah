const http = require('http');
const server = http.createServer((request, response) => {
    response.write('Hellow World, this is a simple HTTP server wkwk!');
    response.end();
});

server.listen(3000);