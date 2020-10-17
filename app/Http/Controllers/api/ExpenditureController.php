<?php

namespace App\Http\Controllers\api;

use App\Models\Expenditure;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ExpenditureResource;
use App\Http\Requests\Expenditure\CreateExpenditureRequest;

class ExpenditureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ExpenditureResource::collection(Expenditure::paginate(15));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateExpenditureRequest $request)
    {
        $expenditure = Expenditure::create([
            'paid_to' => $request->paid_to,
            'expenditure' => $request->expenditure,
            'amount' => $request->amount,
            'receipts' => $request->receipts,
        ]);
        return new ExpenditureResource($expenditure);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function show(Expenditure $expenditure)
    {
        return new ExpenditureResource($expenditure);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Expenditure $expenditure)
    {
        $expenditure->update($request->all());
        return new ExpenditureResource($expenditure);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function destroy(Expenditure $expenditure)
    {
        $expenditure->delete();
        return response()->json(null, 204);
    }
}
