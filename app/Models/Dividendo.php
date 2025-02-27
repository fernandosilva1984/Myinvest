<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
//use Illuminate\Database\Eloquent\Casts\Attribute;

class Dividendo extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'id',
        'id_ativo',
        'data_ref',
        'valor_dividendo',
        'valor_jcp',
        'valor_total',
        'data_com',
        'data_pag',
        'obs',
        'status'
        ];

    public function ativo()
    {
        return $this->belongsTo(Ativo::class, 'id_ativo');
        //return $this->hasOne(Ativo::class,  'id','id_ativo');
    }

    public function carteira()
    {
        return $this->ativo->carteira();
    }
    protected function valor_dividendo(): Attribute{
        return Attribute::make(
            get: fn ($value) => str_replace(".", ",", $value),
            set: fn ( $value) =>
                [
                    'valor_dividendo' => str_replace(",", ".", str_replace(".", "", $value)),
                ],
            );
    }
    protected function valor_jcp(): Attribute{
        return Attribute::make(
            get: fn ($value) => str_replace(".", ",", $value),
            set: fn ( $value) =>
                [
                    'valor_jcp' => str_replace(",", ".", str_replace(".", "", $value)),
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
