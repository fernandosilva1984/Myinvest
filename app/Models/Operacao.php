<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Operacao extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'id',
        'id_carteira',
        'id_ativo',
        'data',
        'qtd',
        'valor_unitario',
        'valor_total',
        'tipo',
        'status'
        ];
        public function carteira()
    {
        return $this->hasOne(carteira::class,  'id','id_carteira');
    }
    public function ativo()
    {
        return $this->hasOne(ativo::class,  'id','id_ativo');
    }
    protected function valor_unitario(): Attribute{
        return Attribute::make(
            get: fn ($value) => str_replace(".", ",", $value),
            set: fn ( $value) =>
                [
                    'valor_unitario' => str_replace(",", ".", str_replace(".", "", $value)),
                ],
            );
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
