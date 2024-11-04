<?php

namespace App\Models;

use Database\Factories\QuestionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $question
 * @property bool $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property user $user
 */
class Question extends Model
{
    /** @use HasFactory<QuestionFactory> */
    use HasFactory;

    protected $hidden = [
        'user_id',
    ];

    //    protected $casts = [
    //        'created_at' => 'datetime:Y-m-d',
    //        'updated_at' => 'datetime:Y-m-d',
    //        'status'     => 'boolean',
    //    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getStatusAttribute($value): string
    {
        return $value ? 'publish' : 'draft';
    }

    // Mutator
    public function setStatusAttribute($value): void
    {
        $this->attributes['status'] = $value === 'publish';
    }

    public function setAttributes(array $attributes): void
    {
        $this->status = $attributes['status'];
    }
}
