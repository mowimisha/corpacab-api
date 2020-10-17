<?php

namespace App\Libraries\Expenditures;

use App\Expenditure;
use Intervention\Image\Facades\Image;

class ExpenditureMethods
{
    public $request;
    protected $expenditure;

    public function __construct(Expenditure $expenditure)
    {
        return $this->expenditure = $expenditure;
    }

    public function getExpenditureById($id)
    {
        return Expenditure::where('id', $id)->get();
    }


    public function getAllExpenditures()
    {
        return Expenditure::orderBy('created_at', 'desc')->paginate(15);
    }

    public function storeExpenditure($request)
    {
        $expenditure = new Expenditure();
        $expenditure->paid_to = $request->paid_to;
        $expenditure->expenditure = $request->expenditure;
        $expenditure->amount = $request->amount;

        if ($request->hasFile('receipts')) {
            $receipts = $request->file('receipts');
            $filename = $expenditure->receipts . "expenditure_receipts_" . $receipts->getClientOriginalName();
            $filename = preg_replace("/[^a-zA-Z0-9_.]/", "", $filename);
            Image::make($receipts->getRealPath())->resize(600, 600)->save('uploads/expenditures/' . $filename);
            $expenditure->receipts = $filename;
        }
        $expenditure->save();
    }

    public function updateExpenditure($request)
    {
        $expenditure = Expenditure::find($request->id);
        $expenditure->paid_to = $request->paid_to;
        $expenditure->expenditure = $request->expenditure;
        $expenditure->amount = $request->amount;

        if ($request->hasFile('receipts')) {
            $receipts = $request->file('receipts');
            $filename = $expenditure->receipts . "expenditure_receipts_" . $receipts->getClientOriginalName();
            $filename = preg_replace("/[^a-zA-Z0-9_.]/", "", $filename);
            Image::make($receipts->getRealPath())->resize(600, 600)->save('uploads/expenditures/' . $filename);
            $expenditure->receipts = $filename;
        }
        $expenditure->save();
    }
}
