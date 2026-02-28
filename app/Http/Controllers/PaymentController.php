<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use App\Models\Invitation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('index.blade.php');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate[(
            'email' => 'string|email',
        )];

        $user = Auth::user();
        $coloc = $user->currentColocation();

        if(!$user->is_owner() || !$coloc){
            return back()->view('error', 'Seul le propriétaire peut envoyer des invitations.');
        }
        $token = Str::random();

        Invitation::create([
            'email' => $request->email,
            'token' => $token,
            'colocation_id' => $coloc->id,
            'status' => 'pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $lien = route('invitation.accept', $token);

        return back()->with('success', 'Invitation créée ! Voici le lien à envoyer : ' . $lien);
    }

    public function accept($token){

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
        Db::transaction(function() use($invitation, $user){
            // on lie l'user à la colocation indiquée dans l'invitation
            $user->colocation()->attach($invitation->colocation_id,[
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
