<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\MySendMail;
use App\Models\Contact;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        $contactUsMessages = Contact::all();
        return response()->json($contactUsMessages, 200);
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
    public function store(Request $request)
    {
        //dd($request->all());
        $this->validate($request, [
            'name' => ['required', 'string', 'min:3', 'max:40'],
            'email' => ['required', 'email', 'min:6', 'max:60'],
            'subject' => ['required', 'string'],
            'message' => ['required', 'string'],
        ]);

        $new_contact = Contact::insert([
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'message' => $request->message,
            'created_at' => Carbon::now(),
        ]);

        return response()->json($new_contact, 200);
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id): \Illuminate\Http\JsonResponse
    {
        $contact_message = Contact::findOrFail($id);
        if ($contact_message->forceDelete()) {
            return response()->json($contact_message, 200);
        }
        return response()->json(['error' => 'Error deleting message.'], 422);
    }

    public function reply(Request $request)
    {
        $this->validate($request, [
            'message' => 'required',
            'to' => 'required|email',
            'subject' => 'required',
        ]);
        $mail_details = [
            'to' => $request->to,
            'subject' => $request->subject,
            'message' => $request->message,
        ];

        Mail::to($request->to)->send(new MySendMail($mail_details));
        return response()->json(['message' => 'Success.'], 200);

        // return response()->json(['error' => 'Sorry! Email not sent!'], 422);
    }
}
