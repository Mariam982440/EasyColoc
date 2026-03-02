<?php
namespace App\Http\Controllers;

use App\Models\Colocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ColocationController extends Controller
{
    public function index()
    {
        $colocations = Auth::user()->colocations()->orderBy('joined_at', 'desc')->get();
        return view('colocations.index', compact('colocations'));
    }

    public function create()
    {
        if(Auth::user()->currentColocation()) {
            return redirect()->route('dashboard')->with('error', 'Vous avez déjà une colocation active');
        }
        return view('colocations.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $user = Auth::user();

        $colocation = Colocation::create([
            'name' => $request->name,
            'status' => 'active',
        ]);

        $user->colocations()->attach($colocation->id, [
            'role' => 'owner',
            'joined_at' => now(),
        ]);

        $user->is_owner = true;
        $user->save();

        return redirect()->route('dashboard')->with('success', 'Colocation créée avec succès !');
    }

    public function show(Colocation $colocation)
    {
        $colocation->load(['activeMembers', 'expenses.payer', 'expenses.category']);
        return view('colocations.show', compact('colocation'));
    }

    public function destroy(Colocation $colocation)
    {
        $user = Auth::user();
        
        $membership = $user->colocations()->where('colocation_id', $colocation->id)->first();

        if (!$membership || $membership->pivot->role !== 'owner') {
            return back()->with('error', 'Action non autorisée : vous n\'êtes pas l\'Owner.');
        }

        $colocation->update(['status' => 'cancelled']);

        $user->update(['is_owner' => false]);

        $user->colocations()->updateExistingPivot($colocation->id, [
            'left_at' => now()
        ]);

        return redirect()->route('colocations.index')->with('success', 'Colocation annulée');
    }  
}