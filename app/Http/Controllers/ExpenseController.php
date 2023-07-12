<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $expenses = Expense::where('user_id', $user->id)->orderBy('id', 'DESC')->get();

        return response()->json($expenses);
    }

    public function get(Request $request, $expense_id)
    {
        $expense = Expense::where('id', $expense_id)->first();
        return response()->json($expense);
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $expense = Expense::create([
            'user_id' => $user->id,
            'description' => $request->input('description'),
            'amount' => $request->input('amount')
        ]);
        return response()->json($expense);
    }

    public function update(Request $request, $expense_id)
    {
        $expense = Expense::where('id', $expense_id)->update($request->only('description', 'amount'));
        return response()->json(['update' => $expense]);
    }

    public function delete(Request $request, $expense_id)
    {
        $expense = Expense::where('id', $expense_id)->delete();
        return response()->json(['delete' => $expense]);
    }
}
