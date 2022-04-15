<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function blogcategory(){
        return $this->belongsTo(Blogcategory::class);
    }
}
