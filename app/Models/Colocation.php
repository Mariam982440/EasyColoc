<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Colocation extends Model
{
    protected $fillable = ['name', 'status'];
    
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_colocation')
                    ->withPivot('role', 'joined_at', 'left_at');
    }

    // uniquement les membres qui n'ont pas encore quitté
    public function activeMembers()
    {
        return $this->users()->wherePivot('left_at', null);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function invitations()
    {
        return $this->hasMany(Invitation::class);
    }
}
