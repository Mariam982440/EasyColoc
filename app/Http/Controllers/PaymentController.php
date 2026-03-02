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
    public function markAsPaid(Payment $payment)
    {
        // seul le débiteur (celui qui doit l'argent) peut confirmer
        if ($payment->debtor_id !== Auth::id()) {
            return back()->with('error', 'Action non autorisée.');
        }

        // on change le statut
        $payment->update([
            'is_paid' => true
        ]);

        return back()->with('success', 'Paiement confirmé ! Votre dette a été effacée.');
    }
}
