<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Messages extends Model
{
    use HasFactory;
    protected $table = 'messages';
    public function replies(){
        return $this->hasMany(Replies::class, "message_id")->with('user');
    }
    public function user(){
        return $this->belongsTo(User::class, "user_id");
    }
}
