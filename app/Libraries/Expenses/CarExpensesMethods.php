<?php

namespace App\Libraries\Expenses;

use App\Expense;
use App\Vehicle;
use Intervention\Image\Facades\Image;

class CarExpensesMethods
{
    public $request;
    protected $expense;

    public function __construct(Expense $expense)
    {
        return $this->expenses = $expense;
    }

    public function getExpenseById($id)
    {
        return Expense::where('id', $id)->get();
    }

    public function getExpenseByRegistrationNumber()
    {
        $vehicle = Vehicle::get();
        return Expense::where('car_registration', $vehicle->registration_no)->orderBy('created_at', 'desc');
    }

    public function getAllExpenses()
    {
        return Expense::orderBy('created_at', 'desc')->paginate(15);
    }

    public function storeExpense($request)
    {
        $expense = new Expense();
        $expense->car_registration = $request->car_registration;
        $expense->expense = $request->expense;
        $expense->amount = $request->amount;

        if ($request->hasFile('receipts')) {
            $receipts = $request->file('receipts');
            $filename =  $expense->car_registration . "_expense_receipts_" . $receipts->getClientOriginalName();
            $filename = preg_replace("/[^a-zA-Z0-9_.]/", "", $filename);
            Image::make($receipts->getRealPath())->resize(600, 600)->save('uploads/vehicles/documents/expense_receipts/' . $filename);
            $expense->receipts = $filename;
        }

        $expense->save();
    }

    public function updateExpense($request)
    {
        $expense = Expense::find($request->id);
        $expense->car_registration = $request->car_registration;
        $expense->expense = $request->expense;
        $expense->amount = $request->amount;

        if ($request->hasFile('receipts')) {
            $receipts = $request->file('receipts');
            $filename = $expense->car_registration . "_expense_receipts_" . $receipts->getClientOriginalName();
            $filename = preg_replace("/[^a-zA-Z0-9_.]/", "", $filename);
            Image::make($receipts->getRealPath())->resize(600, 600)->save('uploads/vehicles/documents/expense_receipts/' . $filename);
            $expense->receipts = $filename;
        }
        $expense->save();
    }
}
