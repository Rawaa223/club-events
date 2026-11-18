<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Member extends Model
{
    /** @use HasFactory<\Database\Factories\MemberFactory> */
    use HasFactory;

    protected $fillable = ['name', 'email', 'phone', 'joined_at'];

    protected function casts(): array
    {
        return [
            'joined_at' => 'date',
        ];
    }

    /** A member organizes many events (hasMany). */
    public function organizedEvents(): HasMany
    {
        return $this->hasMany(Event::class, 'organizer_id');
    }

    /** A member attends many events (through the event_member pivot table). */
    public function attendedEvents(): BelongsToMany
    {
        return $this->belongsToMany(Event::class)->withTimestamps();
    }

    /** "Jane Doe" → "JD", shown in the round avatar. */
    public function initials(): string
    {
        return collect(preg_split('/\s+/', trim((string) $this->name)))
            ->filter()
            ->take(2)
            ->map(fn ($part) => mb_strtoupper(mb_substr($part, 0, 1)))
            ->join('');
    }
}
