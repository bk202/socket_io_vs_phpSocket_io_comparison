var app = require('express')();
var http = require('http').Server(app);
var io = require('socket.io')(http);
require('http').globalAgent.maxSockets = 1000;

app.get('/', function(req, res){
	res.sendFile(__dirname + '/index.html');
});

var userCnt = 0;
var maxUserCnt = 200;
var time_pre = Date.now();
var cutOffEventClient = 20000;
var cutOffEvent = maxUserCnt * cutOffEventClient;
var eventCnt = 0;
io.on('connection', function(socket){
	userCnt++;
	if(userCnt == maxUserCnt){
		console.log("Reached max user count!");
	}
	socket.on('testEvent', function(){
		eventCnt++;
		if(eventCnt == cutOffEvent){
			var total_time = ((Date.now() - time_pre) * 0.001);
			console.log(total_time);
		}
	})
});



http.listen(3000, function(){
	console.log('listening on *:3000');
});