var app = require('express')();
var http = require('http').Server(app);
var io = require('socket.io')(http);

app.get('/', function(req, res){
	res.sendFile(__dirname + '/index.html');
});

io.on('connection', function(socket){
	/*console.log('A user connected');
	socket.on('disconnect', function(){
		console.log('User disconnected');
	});

	socket.on('newMessage', function(message){
		console.log('message: ' + message);
		socket.broadcast.emit('rcvMessage', message);
	});*/

	/*var time_pre = Date.now();
	socket.on('testEvent', function(data){
		if(data == 220000){
			var time_post = Date.now();
			console.log((time_post - time_pre) * 0.001);
		}
	})*/

	for(var i=0; i<=220000; i++){
		socket.emit('testEvent', i);
	}
});

http.listen(3000, function(){
	console.log('listening on *:3000');
});


