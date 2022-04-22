<?php

namespace App\Models;

use App\Models\admin\Campinggear;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campinggearcart extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function campinggear()
    {
        return $this->belongsTo(Campinggear::class);
    }
}
