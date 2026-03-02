<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = [
        'description', 
        'amount', 
        'date', 
        'user_id', 
        'colocation_id', 
        'category_id'
    ];

    
    public function payer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function colocation()
    {
        return $this->belongsTo(Colocation::class);
    }

    public function createPayments()
    {
        $colocation = $this->colocation;
        $members = $colocation->activeMembers;
        $memberCount = $members->count();

        if ($memberCount <= 1) return;

        $amountPerPerson = $this->amount / $memberCount;

        foreach ($members as $member) {
            // on ne crée pas de dette pour celui qui a payé
            if ($member->id !== $this->user_id) {
                \App\Models\Payment::create([
                    'debtor_id' => $member->id,
                    'creditor_id' => $this->user_id,
                    'colocation_id' => $colocation->id,
                    'amount' => $amountPerPerson,
                    'is_paid' => false,
                ]);
            }
        }

    }
}
