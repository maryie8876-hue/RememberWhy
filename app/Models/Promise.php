<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Promise extends Model
{
    protected $fillable = [
        'uuid',
        'project_title',
        'email',
        'generated_promise',
        'sealed_at',
        'remind_at',
        'reminder_sent_at',
    ];

    protected $casts = [
        'sealed_at'        => 'datetime',
        'remind_at'        => 'datetime',
        'reminder_sent_at' => 'datetime',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Promise $promise) {
            if (empty($promise->uuid)) {
                $promise->uuid = (string) Str::uuid();
            }
        });
    }

    public function answers(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(InterviewAnswer::class)->orderBy('question_number');
    }
}
