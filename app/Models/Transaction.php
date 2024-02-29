<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model {

    use HasFactory;

    protected $guarded = [];

    /**
     * The roles that belong to the Transaction
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function user(): BelongsToMany {
        
        return $this->belongsToMany(User::class, 'transaction_user_table', 'user_id', 'dept_id');
    }
}
