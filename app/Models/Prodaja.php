<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Prodaja extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'datum',
        'ukupan_iznos',
        'nacin_placanja',
        'kupac_id',
        'user_id',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'datum' => 'date',
            'ukupan_iznos' => 'decimal:2',
            'kupac_id' => 'integer',
            'user_id' => 'integer',
        ];
    }

    public function kupac(): BelongsTo
    {
        return $this->belongsTo(Kupac::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function stavkaProdajes(): HasMany
    {
        return $this->hasMany(StavkaProdaje::class);
    }
}
