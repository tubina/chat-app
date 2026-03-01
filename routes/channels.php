<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Aqui você pode registrar todos os canais de broadcast do seu aplicativo.
|
*/

// Exemplo de canal privado "chat.{id}"
Broadcast::channel('chat.{id}', function ($user, $id) {
    // Retorna true se o usuário pode ouvir este canal
    return (int) $user->id === (int) $id;
});