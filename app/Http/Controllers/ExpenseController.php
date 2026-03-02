<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ExpenseController extends Controller
{

    public function create()
    {

        $categories = \App\Models\Category::all();
        
        return view('expenses.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'description' => 'required|string|max:255',
            'amount'      => 'required|numeric|min:0.01',
            'category_id' => 'required|exists:categories,id',
            'date'        => 'required|date',
        ]);

        $user = Auth::user();
        
        $coloc = $user->currentColocation();

        if (!$coloc) {
            return back()->with('error', 'Action impossible : vous ne faites partie d\'aucune colocation active.');
        }

        // transaction car on va toucher à deux tables (expenses et payments)
        DB::transaction(function () use ($validated, $user, $coloc) {
            
            $expense = Expense::create([
                'description'   => $validated['description'],
                'amount'        => $validated['amount'],
                'user_id'       => $user->id,           
                'colocation_id' => $coloc->id,  
                'category_id'   => $validated['category_id'],
                'date'          => $validated['date'],
            ]);

            $expense->createPayments();
        });

        return redirect()->route('colocations.show', $coloc->id)
                         ->with('success', 'Dépense enregistrée et partagée avec succès !');
    
    }

    /**
     * Display the specified resource.
     */
    public function show(Expense $expense)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Expense $expense)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Expense $expense)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Expense $expense)
    {
        //
    }
}
