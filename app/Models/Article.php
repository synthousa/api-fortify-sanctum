<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model {

    use HasFactory;

    protected $guarded = ['is_admin'];
    
    protected $hidden = ['id'];

    public function user() {
        return $this -> belongsTo(User::class, 'user_id');
    }
}
