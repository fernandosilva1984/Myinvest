<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Movimentacao extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'id',
        'id_carteira',
        'data',
        'valor_total',
        'tipo',
        'obs',
        'status'
        ];
        public function carteira()
    {
        return $this->hasOne(Carteira::class,  'id','id_carteira');
    }
    protected function valor_total(): Attribute{
        return Attribute::make(
            get: fn ($value) => str_replace(".", ",", $value),
            set: fn ( $value) =>
                [
                    'valor_total' => str_replace(",", ".", str_replace(".", "", $value)),
                ],
            );
    }
}
