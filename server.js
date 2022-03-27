const express = require('express');
const app = express();
const http = require('http');
const server = http.createServer(app);
const { Server } = require("socket.io");
const io = new Server(server);
require('dotenv').config();
const Redis = require('ioredis');
const { data } = require('jquery');
let redis_password = process.env.REDIS_PASSWORD;
let redis_host = process.env.REDIS_HOST;
var users=[];
var agents=[];
const redis = new Redis({
    host: redis_host,
    password:redis_password,
})
redis.subscribe('private-channel',function (){
    console.log("listen private channel");
});
redis.subscribe('mobil-channel',function (){
    console.log("listen private channel");
});
redis.on('message',function (channel,message){
    console.log(channel,message);
    message = JSON.parse(message);
    if(channel=="private-channel"){
        let  receiver_id= message.data.data.recipient;
        let ticket_id = message.data.data.ticket_id;

        users.filter(obj => {
            if(ticket_id == obj.ticket_id && receiver_id==obj.user_id){
                io.to(obj.socket_id).emit(channel +':'+message.event ,message );
            }
        });
   }
   if(channel=="mobil-channel"){
       let agent_id = message.data.data.agent_id;
        agents.filter(obj => {
            if(agent_id == obj.agent_id && obj.type=="web"){
                io.to(obj.socket_id).emit(channel +':'+message.event ,message );
            }
        });
   }
});

server.listen(3000, () => {
    console.log('listening on *:3000');
});

io.on('connection',function (socket){
    socket.on("user_connected",function (user_id,ticket_id){
        console.log("user_connected"+ user_id);
        console.log(ticket_id)
        let data = {socket_id:socket.id,ticket_id:ticket_id,user_id:user_id};
        users.push(data);
    });
    socket.on("agent_mobile",function (agent_id,type){
        console.log("agent_connected"+ agent_id,type);
        let data = {socket_id:socket.id,agent_id:agent_id,type:type};
        agents.push(data);
    });
    socket.on('disconnecting',(reason) => {
        let index=users.indexOf(socket.id);
        if(index>-1){
            users.splice(index,1);
        }
    });
});
