<?php

namespace App\Http\Controllers\Api;

use App\Events\NewMessage;
use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChatAppController extends Controller
{
    public function contacts(): \Illuminate\Http\JsonResponse
    {
        // Get all user  ...
        $contacts = User::where('id', '!=', auth()->id())->get();

        $unseenIds = Message::select(DB::raw('`from` as sender_id, count(`from`) as messages_count'))
            ->where('to', auth()->id())
            ->where('seen', false)
            ->groupBy('from')
            ->orderBy('created_at', 'DESC')
            ->get();

        $contacts = $contacts->map(function ($contact) use ($unseenIds) {
            $contactUnread = $unseenIds->where('sender_id', $contact->id)->first();
            $contact->unread = $contactUnread ? $contactUnread->messages_count : 0;
            return $contact;
        });

        return response()->json($contacts, 200);
    }

    public function getMessages($id): \Illuminate\Http\JsonResponse
    {
        /*$messages = Message::where('from', $id)
            ->orWhere('to', $id)->get();*/
        Message::where('from', $id)->where('to', auth()->id())->update(['seen' => true]);

        $messages = Message::where(function ($q) use ($id) {
            $q->where('from', auth()->id());
            $q->where('to', $id);
        })->orWhere(function ($q) use ($id) {
            $q->where('from', $id);
            $q->where('to', auth()->id());
        })->get();

        return response()->json($messages, 200);
    }

    public function sendMessage(Request $request): \Illuminate\Http\JsonResponse
    {
        $message = new Message();
        $message->from = auth()->id();
        $message->to = $request->contact_id;
        $message->body = $request->text;
        $message->save();

        broadcast(new NewMessage($message));

        return response()->json($message, 200);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
