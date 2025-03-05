<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Configuracao extends Model
{
    use HasFactory, SoftDeletes,  LogsActivity;
    protected $fillable = [
        'id',
        'CDI_atual',
        'SELIC_atual',
        'Corretagem_acoes',
        'Corretagem_fii',
        'Corretagem_Criptos'
        ];

        public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
         ->logOnly(['*'])
         ->logOnlyDirty();
        // Chain fluent methods for configuration options
    }
}
