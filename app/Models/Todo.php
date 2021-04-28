<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'title',
        'description', 'isCompleted'
    ];

    protected $guarded = ['user_id'];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return
            $this
                ->belongsTo(User::class);
    }
}
