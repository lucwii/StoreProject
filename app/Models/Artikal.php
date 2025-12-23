<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Artikal extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'naziv',
        'opis',
        'nabavna_cena',
        'prodajna_cena',
        'kolicina_na_stanju',
        'dobavljac_id',
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
            'nabavna_cena' => 'decimal:2',
            'prodajna_cena' => 'decimal:2',
            'dobavljac_id' => 'integer',
        ];
    }

    public function dobavljac(): BelongsTo
    {
        return $this->belongsTo(Dobavljac::class);
    }
}
