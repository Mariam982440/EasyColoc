<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\TestSize\Known;
use Illuminate\Support\Facades\Auth;


class AdminController extends Controller
{
    public function toggleBan(User $user){

        $check = Auth::user();
    
        if (!$user->role_type === 'admin') {
            return back()->with('error', 'Action réservée à l admin.');
        }

        if ($user->role_type === 'admin') {
            return back()->with('error', 'Action impossible sur un administrateur.');
        }

        if ($user->banned_at) {
            $user->update(['banned_at' => null]);
            return back()->with('success', 'Utilisateur débanni.');
        }

        DB::transaction(function() use($user){
    
            $coloc = $user->currentColocation();

            if ($coloc) {
                
                $owner = $coloc->users()->where('is_owner', true)->first();

                Payment::where('colocation_id', $coloc->id)
                    ->where('debtor_id', $user->id)
                    ->where('is_paid', false)
                    ->update(['debtor_id' => $owner->id]);

                $user->colocations()->updateExistingPivot($coloc->id, [
                    'left_at' => now()
                ]);
            }

            // on marque l'utilisateur comme banni (mise à jour de l'objet user)
            $user->update([
                'banned_at' => now()
            ]);
        });
    }
    
}
