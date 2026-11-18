<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Event extends Model
{
    /** @use HasFactory<\Database\Factories\EventFactory> */
    use HasFactory;

    protected $fillable = ['title', 'description', 'location', 'starts_at', 'capacity', 'organizer_id'];

    protected function casts(): array
    {
        return [
            'starts_at' => 'datetime',
        ];
    }

    /** An event belongs to one member, its organizer (belongsTo). */
    public function organizer(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'organizer_id');
    }

    /** The members who attend this event. */
    public function attendees(): BelongsToMany
    {
        return $this->belongsToMany(Member::class)->withTimestamps();
    }

    /* ---------- Scopes: used as Event::upcoming(), Event::past(), Event::search('x') ---------- */

    public function scopeUpcoming(Builder $query): Builder
    {
        return $query->where('starts_at', '>=', now())->orderBy('starts_at');
    }

    public function scopePast(Builder $query): Builder
    {
        return $query->where('starts_at', '<', now())->orderByDesc('starts_at');
    }

    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        return $query->when($term, function (Builder $query, string $term) {
            $query->where(function (Builder $query) use ($term) {
                $query->where('title', 'like', "%{$term}%")
                      ->orWhere('location', 'like', "%{$term}%");
            });
        });
    }

    /* ---------- Helpers ---------- */

    public function isPast(): bool
    {
        return $this->starts_at->isPast();
    }

    public function spotsLeft(): int
    {
        $count = $this->attendees_count ?? $this->attendees()->count();

        return max(0, $this->capacity - $count);
    }

    /** How full the event is, from 0 to 100 (for the progress bar). */
    public function fillPercent(): int
    {
        if ($this->capacity < 1) {
            return 0;
        }

        $count = $this->attendees_count ?? $this->attendees()->count();

        return (int) min(100, round($count / $this->capacity * 100));
    }
}
