<?php

namespace App\Http\Controllers;

use App\Models\MessageModel;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($userId)
    {
        $userId = auth()->id();

        $messages = MessageModel::where(function($q) use($authId, $userId) {
            $q->where('from_id', $authId)
            ->where('to_id', $userId)
            ->where('from_deleted', false)
            ->where('created_at', 'asc');
        })->get();

        return Inertia::render('Dashboard', [
            'messages' => $messages,
            'userId' => $userId
        ]); 
    }


}
