<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invitation;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class InvitationController extends Controller
{
    
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
        ]);

        $user = Auth::user();
        $coloc = $user->currentColocation(); 

        if(!$user->is_owner || !$coloc){
            return back()->with('error', 'Seul le propriétaire peut envoyer des invitations.');
        }

        $token = Str::random(40);

        Invitation::create([
            'email' => $request->email,
            'token' => $token,
            'colocation_id' => $coloc->id,
            'status' => 'pending',
        ]);

        $lien = route('invitations.accept', $token);

        return back()->with('success', 'Invitation créée ! Voici le lien à envoyer : ' . $lien);
    }


    public function accept($token)
    {
    
        $invitation = Invitation::where('token', $token)
            ->where('status', 'pending')
            ->first();

        if (!$invitation) {
            return redirect()->route('dashboard')->with('error', 'Lien invalide ou déjà utilisé.');
        }

        $user = Auth::user();

        if ($user->currentColocation()) {
            return redirect()->route('dashboard')->with('error', 'Vous faites déjà partie d\'une colocation.');
        }

        DB::transaction(function() use($invitation, $user){
            
            $user->colocations()->attach($invitation->colocation_id, [
                'role' => 'member',
                'joined_at' => now(),
            ]);

            $invitation->update([
                'status' => 'accepted'
            ]);
        });

        return redirect()->route('dashboard')->with('success', 'Bienvenue dans votre nouvelle colocation !');
    }

}
