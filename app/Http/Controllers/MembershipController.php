<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MembershipController extends Controller
{
    public function leave(){
        $user = Auth::user();
        $coloc = $user->currentColocation();

        if (!$coloc) return back();

        // l'owner ne peut pas quitter, il doit annuler la coloc
        if ($user->is_owner) {
            return back()->with('error', 'En tant que propriétaire, vous devez annuler la colocation pour la quitter.');
        }
        $hasDebt = Payment::where('colocation_id', $coloc->id)
                          ->where('debtor_id', $user->id)
                          ->where('is_paid', false)
                          ->exists();

        DB::transaction(function () use ($user, $coloc, $hasDebt) {
            if ($hasDebt) {
                $user->decrement('reputation_score'); 
            } else {
                $user->increment('reputation_score'); 
            }

            $user->colocations()->updateExistingPivot($coloc->id, [
                'left_at' => now()
            ]);
        });

        return redirect()->route('dashboard')->with('success', 'Vous avez quitté la colocation.');
    }
    
}
