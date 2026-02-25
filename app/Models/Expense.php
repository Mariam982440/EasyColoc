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

    // celui qui a payé
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

    
}
