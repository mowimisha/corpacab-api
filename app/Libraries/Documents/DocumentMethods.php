<?php

namespace App\Libraries\Documents;

use App\Models\User;
use App\Vehicle;
use App\Document;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Notifications\DocumentRenewalDue;
use Illuminate\Support\Facades\Notification;

class DocumentMethods
{
    public $document;
    public $request;
    protected $vehicle;

    public function __construct(Document $document)
    {
        return $this->document = $document;
    }

    public function getAllDocuments()
    {
        return Document::orderBy('created_at', 'desc')->paginate(25);
    }

    public function getAllDueDocuments()
    {
        return Document::where('expiry_date', Carbon::today())->count();
    }

    public function getDocumentById($id)
    {
        return Document::where('id', $id)->get();
    }

    public function storeDocuments($request)
    {
        $document = new Document();
        $document->document_type = $request->document_type;
        $document->document_owner = $request->document_owner;
        $document->car = $request->car;
        $document->issue_date = Carbon::parse($request->issue_date);
        $document->expiry_date = Carbon::parse($request->expiry_date);
        $document->reminder_date = Carbon::parse($request->reminder_date);
        $document->save();
    }

    public function updateDocuments($request)
    {
        $document = Document::find($request->id);
        $document->document_type = $request->document_type;
        $document->document_owner = $request->document_owner;
        $document->car = $request->car;

        if (!empty($request->issue_date)) {
            $document->issue_date = Carbon::parse($request->issue_date);
        }
        if (!empty($request->expiry_date)) {
            $document->expiry_date = Carbon::parse($request->expiry_date);
        }
        if (!empty($request->service_date)) {
            $document->reminder_date = Carbon::parse($request->service_date);
        }
        $document->save();
    }

    public function documentReminder()
    {
        $documents = Document::get();
        $today = Carbon::today();
        $document_due_id = Document::where('reminder_date', $today)->value('id');

        DB::table('documents')
            ->where('id', $document_due_id)
            ->update(['status' => 1]);

        //Notification::send($documents, new DocumentRenewalDue());
    }

    public function reminderDocumentOwner()
    {
        $today = Carbon::today();
        $document_owner = Document::where('reminder_date', $today)->value('document_owner');

        //return name of document owner
        $firstname = User::where('id', $document_owner)->value('name');
        $lastname = User::where('id', $document_owner)->value('lastname');
        $owner_name = $firstname . " " . $lastname;
        return $owner_name;
    }

    public function reminderDocumentType()
    {
        $today = Carbon::today();
        $document_type = Document::where('reminder_date', $today)->value('document_type');
        return $document_type;
    }
}
