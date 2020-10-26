<?php

namespace App\Http\Controllers\api;

use App\Models\User;
use App\Models\Document;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DocumentResource;
use App\Notifications\DocumentRenewalDue;
use Illuminate\Support\Facades\Notification;
use App\Http\Requests\Document\CreateDocumentRequest;

class DocumentController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return DocumentResource::collection(Document::get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateDocumentRequest $request)
    {

        $document = Document::create([
            'document_type' => $request->document_type,
            'document_owner' => $request->document_owner,
            'car' => $request->car,
            'issue_date' => $request->issue_date,
            'expiry_date' => $request->expiry_date,
            'reminder_date' => $request->reminder_date,
            'status' => $request->status,
        ]);
        return new DocumentResource($document);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function show(Document $document)
    {
        return new DocumentResource($document);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Document $document)
    {
        $document->update($request->all());
        return new DocumentResource($document);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function destroy(Document $document)
    {
        $document->delete();
        return response()->json(null, 204);
    }

    // public function sendNotification()
    // {
    //     $this->documents->documentReminder();
    //     $email = User::get();
    //     $document_owner = $this->documents->reminderDocumentOwner();
    //     $document_type = $this->documents->reminderDocumentType();
    //     $details = [
    //         'greeting' => 'Hi Admin',
    //         'body' => 'This is a ' . $document_type . ' Renewal Notification for' . " " . $document_owner,
    //         'actionText' => 'Login the site for more details',
    //         'actionURL' => url('https://corpcab.co.ke/login'),
    //     ];

    //     Notification::send($email, new DocumentRenewalDue($details));
    //     return redirect('all-users');
    // }
}
