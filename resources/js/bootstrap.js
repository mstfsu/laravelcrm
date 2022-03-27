window._ = require('lodash');
try {
    window.Popper = require('popper.js').default;
 //  window.$ = window.jQuery = require('jquery');

   // require('bootstrap');
 window.toastr = require('toastr');
} catch ( e ) {
}
window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
console.log($('meta[name=csrf-token]').attr('content'))
var token = $('meta[name="csrf-token"]').attr('content');
import Echo from 'laravel-echo';

window.io = require('socket.io-client');
var hostname = window.location.origin
 
window.Echo = new Echo({
    broadcaster: 'socket.io', host: hostname+":8082",
    authEndpoint: "/broadcasting/auth",
    csrfToken: token

});
// window.Echo.connector.options.auth.headers['X-CSRF-TOKEN'] =  $('meta[name=csrf-token]').attr('content')

window.Echo.connector.socket.on('connect', function () {
    console.log('socket connected: ' + window.Echo.socketId());
})

window.Echo.connector.socket.on('disconnect', function () {
    console.log('socket disconnected');
})