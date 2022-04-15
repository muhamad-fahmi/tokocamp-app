<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blogcategory extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function blog(){
        return $this->hasMany(Blog::class);
    }
}
