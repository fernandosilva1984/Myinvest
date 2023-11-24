<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Carteira extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'id',
        'Nome',
        'Proprietario',
        'Valor_Investido',
        'Valor_Mercado',
        'Resultado',
        'status'
        ];
        protected function valor_Investido(): Attribute{
            return Attribute::make(
                get: fn ($value) => str_replace(".", ",", $value),
                set: fn ( $value) =>
                    [
                        'Valor_Investido' => str_replace(",", ".", str_replace(".", "", $value)),
                    ],
                );
        }
        protected function valor_Mercado(): Attribute{
            return Attribute::make(
                get: fn ($value) => str_replace(".", ",", $value),
                set: fn ( $value) =>
                    [
                        'Valor_Mercado' => str_replace(",", ".", str_replace(".", "", $value)),
                    ],
                );
        }
    }
