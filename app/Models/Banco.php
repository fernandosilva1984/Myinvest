<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Banco extends Model
{
    use HasFactory, SoftDeletes,  LogsActivity;
    protected $fillable = [
        'id',
        'nome',
        'razao_social',
        'CNPJ',
        'logradouro',
        'bairro',
        'cidade',
        'UF',
        'status'
        ];

        public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
         ->logOnly(['*'])
         ->logOnlyDirty();
        // Chain fluent methods for configuration options
    }
}
