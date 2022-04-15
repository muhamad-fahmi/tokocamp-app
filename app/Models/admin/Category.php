<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function location()
    {
        return $this->hasMany(Location::class);
    }
    public function package()
    {
        return $this->hasMany(Package::class);
    }
    public function galery()
    {
        return $this->hasMany(Galery::class);
    }
    public function rate()
    {
        return $this->hasMany(Rate::class);
    }
}
