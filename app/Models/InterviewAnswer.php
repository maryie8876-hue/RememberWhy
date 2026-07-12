<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InterviewAnswer extends Model
{
    protected $fillable = [
        'promise_id',
        'question_number',
        'question',
        'answer',
    ];

    public function promise(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Promise::class);
    }
}
