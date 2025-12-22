<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StavkaProdaje extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'prodaja_id',
        'artikal_id',
        'kolicina',
        'cena',
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
            'prodaja_id' => 'integer',
            'artikal_id' => 'integer',
            'cena' => 'decimal:2',
        ];
    }

    public function prodaja(): BelongsTo
    {
        return $this->belongsTo(Prodaja::class);
    }

    public function artikal(): BelongsTo
    {
        return $this->belongsTo(Artikal::class);
    }
}
