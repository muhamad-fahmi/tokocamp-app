<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function location()
    {
        return $this->belongsTo(Location::class);
    }
    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }
    public function galery()
    {
        return $this->hasMany(Galery::class);
    }
    public function rate()
    {
        return $this->hasMany(Rate::class);
    }
    public function packagecart(){
        return $this->belongsTo(Packagecart::class);
    }
}
