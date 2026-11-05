<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Expense;
use Auth;

class ExpenseController extends Controller
{
    /**
     * Menyimpan data pengeluaran belanja baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'expense_date' => 'required|date',
            'category' => 'required|string',
        ]);

        $expense = new Expense;
        $expense->title = $request->title;
        $expense->category = $request->category;
        $expense->amount = $request->amount;
        $expense->expense_date = $request->expense_date;
        $expense->notes = $request->notes;
        $expense->created_by = Auth::id();
        $expense->save();

        return redirect()->back()->with('success', 'Catatan belanja "' . $expense->title . '" berhasil ditambahkan!');
    }

    /**
     * Menghapus data pengeluaran belanja
     */
    public function destroy($id)
    {
        $expense = Expense::findOrFail($id);
        $expense->delete();

        return redirect()->back()->with('success', 'Catatan belanja berhasil dihapus.');
    }
}

