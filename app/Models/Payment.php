<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{

    protected $fillable = ['debtor_id', 'creditor_id', 'colocation_id', 'amount', 'is_paid'];

     public function debtor()
    {
        return $this->belongsTo(User::class, 'debtor_id');
    }

    public function creditor()
    {
        return $this->belongsTo(User::class, 'creditor_id');
    }

    public function colocation()
    {
        return $this->belongsTo(Colocation::class);
    }

}
