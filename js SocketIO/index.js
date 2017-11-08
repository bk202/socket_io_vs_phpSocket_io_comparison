var app = require('express')();
var http = require('http').Server(app);
var io = require('socket.io')(http);
require('http').globalAgent.maxSockets = 1000;
var fs = require('fs');

app.get('/', function(req, res){
	res.sendFile(__dirname + '/index.html');
});

var userCnt = 0;
var maxUserCnt = 200;
var lastRecordedTime = Date.now()
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
		if(eventCnt == maxUserCnt){
			eventCnt = 0;
			var responseTime = ((Date.now() - lastRecordedTime) * 0.001) - 1;
			lastRecordedTime = Date.now();
            fs.appendFile("200connections.txt", responseTime + "\n", function(err){
            	if(err) console.log(err);
			});
            console.log(responseTime);
        }
	})
});



http.listen(3000, function(){
	console.log('listening on *:3000');
});