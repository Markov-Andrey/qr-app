<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAction extends Model
{
    use HasFactory;

    protected $table = 'user_actions';
    protected $fillable = [
        'user_id',
        'ip_address',
        'processed_data',
    ];
    protected $casts = [
        'processed_data' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
