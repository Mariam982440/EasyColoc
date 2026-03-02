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
        $owner = $coloc->users()->where('is_owner', true)->first();

        $hasDebt = Payment::where('colocation_id', $coloc->id)
                                  ->where('debtor_id', $user->id)
                                  ->where('is_paid', false)
                                  ->exists();

        Payment::where('colocation_id', $coloc->id)
                       ->where('debtor_id', $user->id)
                       ->where('is_paid', false)
                       ->update(['debtor_id' => $owner->id]);
        
        if ($hasDebt) {
            $user->decrement('reputation_score'); 
        } else {
            $user->increment('reputation_score'); 
        }

        
        $user->colocations()->updateExistingPivot($coloc->id, [
            'left_at' => now()
        ]);

        return redirect()->route('dashboard')->with('success', 'Vous avez quitté la colocation.');
    }

    public function remove(User $member){
        $owner = Auth::user();
        $coloc = $owner->currentColocation();

        if (!$owner->is_owner) {
            return back()->with('error', 'Action réservée au propriétaire.');
        }

        if ($member->id === $owner->id) {
            return back()->with('error', 'Vous ne pouvez pas vous retirer vous-même. Annulez la colocation.');
        }

        DB::transaction(function () use ($member, $owner, $coloc) {
            
            Payment::where('colocation_id', $coloc->id)
                ->where('debtor_id', $member->id)
                ->where('is_paid', false)
                ->update(['debtor_id' => $owner->id]);

            $member->colocations()->updateExistingPivot($coloc->id, [
                'left_at' => now()
            ]);
        });

        return back()->with('success', "Le membre {$member->name} a été retiré et ses dettes vous ont été transférées.");
    }
    
}
