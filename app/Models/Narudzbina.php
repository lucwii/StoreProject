<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Narudzbina extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'datum',
        'status',
        'dobavljac_id',
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
            'dobavljac_id' => 'integer',
            'user_id' => 'integer',
        ];
    }

    public function dobavljac(): BelongsTo
    {
        return $this->belongsTo(Dobavljac::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function stavkaNarudzbines(): HasMany
    {
        return $this->hasMany(StavkaNarudzbine::class);
    }
}
