<?php

namespace App\Http\Controllers;

use App\Models\Colocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class ColocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $colocations = Auth::user()->colocations()->orderBy('joined_at')->get();
        return view('colocations.index', compact('colocations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(auth()->user()->currentColocation) {
            return redirect()->route('dashboard')->with('error', 'vous avez deja une colocation active');
                
        return view('colocations.index');
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $user= Auth::user();

        $colocation = Colocation::create([
            'name' => $request->name,
            'status' => 'active',
        ]);
        // un enregistrement dans le pivot
        $user->colocation()->attach($colocation->id,[
            'role' => 'owner',
            'joined_at' => now(),
        ])
        $user->is_owner = true;
        $user->save();

        return redirect()->route('colocations.show', $coloc->id)
                ->with('success', 'Colocation créée avec succès !');
    }

    /**
     * Display the specified resource.
     */
    public function show(Colocation $colocation)
    {
        $colocation->load(['activeMembers', 'expenses.payer', 'expenses.category']);
        return view('colocations.show', compact('clocation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Colocation $colocation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Colocation $colocation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Colocation $colocation)
    {
        $user = Auth::user();
        // on regarde dans la table pivot si il est owner de cette collocation
        $membership = $user->colocations()->where('colocation_id', $colocation->id)->first();

        if (!$membership || $membership->pivot->role !== 'owner') {
        return back()->with('error', 'Action non autorisée : vous n\'êtes pas l\'Owner.');

        $colocation->update([
        'status' => 'cancelled'
        ]);

        $user->update([
            'is_owner' => false
        ]);

        $user->colocations()->updateExistingPivot($colocation->id, [
            'left_at' => now()
        ]);
    }
    }
}
