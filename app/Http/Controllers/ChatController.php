<?php

namespace App\Http\Controllers;

use App\Models\MessageModel;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Events\MessageSent; 
use Illuminate\Support\Facades\DB;
use App\Models\User;

class ChatController extends Controller
{
    /**
    * Display a listing of the resource.
    **/
/***************** INDEX ********************/

    public function chats() 
    {
        $authId = auth()->id();

        //IF(messages.from_id = ?, messages.to_id, messages.from_id) AS other_user_id,
        //pode ser retirado porque de primeira impressao ele faz a consulta e retorna o usuario, 
        //mas ele nao vai retornar qual id do usuario da conversa

        $chats = MessageModel::selectRaw('
            IF(messages.from_id = ?, messages.to_id, messages.from_id) AS other_user_id, 
            users.name AS chat_user_name,
            users.profile_photo AS profile_photo,
            messages.message AS last_message,
            messages.created_at AS last_time
        ', [$authId])
        ->join('users', function ($join) use ($authId){
            $join->on('users.id', '=', DB::raw(
                "IF(messages.from_id = ?, messages.to_id, messages.from_id)"
            ));
        })
        ->addBinding($authId, 'join')
        ->whereIn('messages.id', function ($query) use ($authId) {
            $query->selectRaw('MAX(id)')
                ->from('messages')
                ->where(function ($q) use ($authId) {
                    $q->where('from_id', $authId)
                    ->orWhere('to_id', $authId);
                })
                ->groupByRaw('LEAST(from_id, to_id), GREATEST(from_id, to_id)');
        })
        ->orderByDesc('last_time')
        ->get();

        return $chats;
    }
/***************** CHATS ********************/
    public function index()
    {  
        $chats = $this->chats();

        return Inertia::render('Dashboard', [
            'chat' => $chats
        ]);
    }
/***************** OPEN CHAT ********************/
    public function openChat($otherUserId)
    {
        $authId = auth()->id();

        $messages = MessageModel::where(function ($f) use ($authId, $otherUserId){
            $f->where(function ($f2) use ($authId, $otherUserId) {
                $f2->where('from_id', $authId)
                ->where('to_id', $otherUserId);
            })
            ->orWhere(function ($f2) use ($authId, $otherUserId){
                $f2->where('from_id', $otherUserId)
                ->where('to_id', $authId);
            });            
        })
        ->join('users as u_from', 'messages.from_id', '=', 'u_from.id') // dados do remetente
        ->join('users as u_to', 'messages.to_id', '=', 'u_to.id')       // dados do destinatário
        ->select(
            'messages.*', 
            'u_from.name as from_name', 
            'u_from.profile_photo as from_avatar', // foto do remetente
            'u_to.name as to_name', 
            'u_to.profile_photo as to_avatar'      // foto do destinatário
        )
        ->orderBy('id')
        ->get();

        // $users = User::whereIn('id', [$authId, $otherUserId])
        //     ->select('id', 'name', 'profile_photo') // só pega o que interessa
        //     ->get();

        // Log::info('sdasdasda', [
        //     'teste' => 'users'
        // ]);

        $chats = $this->chats();

        return ['chat' => $chats, 'messages' => $messages];
    }

/***************** SEND ********************/
    public function send(Request $request)
    {
        Log::info('teste', ['chat'=>Auth::id().'_'.$request->to_id]);

        $text = is_array($request->text) ? json_encode($request->text) : $request->text;
 
        $message = MessageModel::create([
            'from_id' => Auth::id(),
            'to_id' => $request->to_id,
            'message' => $text,
        ]);

        $chat = Auth::id().'_'.$request->to_id;

        // Dispara evento para o outro usuário
        broadcast(new MessageSent($message, $chat))->toOthers();

        // return response()->json($message);
    }


}
