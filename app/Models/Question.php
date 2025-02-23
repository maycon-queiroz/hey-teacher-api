<?php

namespace App\Models;

use Database\Factories\QuestionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\{Builder, Casts\Attribute, Model, Relations\HasMany, SoftDeletes};
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $question
 * @property bool $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property user $user
 * @property ?int $likes
 * @property ?int $unlikes
 */
class Question extends Model
{
    /** @use HasFactory<QuestionFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $hidden = [
        'user_id',
    ];

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
        $this->attributes['status'] = $value === 1;
    }

    public function setAttributes(array $attributes): void
    {
        $this->status = $attributes['status'];
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', true);
    }

    public function scopeSearch(Builder $query, ?string $search): Builder
    {
        return $query->when($search, fn ($query) => $query->where('question', 'like', "%$search%"));
    }

    public function scopeSumVotes(Builder $query): Builder
    {
        return $query->withSum('votes', 'like')
            ->withSum('votes', 'unlike');
    }

    public function scopeOrderVotes(Builder $query): Builder
    {
        return $query->orderByRaw('
                    case when votes_sum_like is null then 0 else votes_sum_like end desc,
                    case when votes_sum_unlike is null then 0 else votes_sum_unlike end
           ');
    }

    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class);
    }

    public function likes(): Attribute
    {
        return new Attribute(get: fn () => $this->votes()->sum('like'));
    }

    public function unlikes(): Attribute
    {
        return new Attribute(get: fn () => $this->votes()->sum('unlike'));
    }
}
