<?php
use App\Models\User;
/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

//Broadcast::channel('App.User.{id}', function ($user, $id) {
//    return (int) $user->id === (int) $id;
//});
//Broadcast::channel('private-App.Models.User.{id}', function ($user, $id) {
//    return (int) $user->id === (int) $id;
//});
//Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
//    return (int) $user->id === (int) $id;
//});

Broadcast::channel('user.{id}', function ($user, $id) {
    return true;
});
Broadcast::channel('LanChannel', function ($user, $id) {
    return true;
});

Broadcast::channel('presence-chat', function ($user) {
    return true; //replace with suitable auth check here
});
Broadcast::channel('chat', function (User $user) {
    return true;
});