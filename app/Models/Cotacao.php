<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;


class Cotacao extends Model
{
    use HasFactory, SoftDeletes,  LogsActivity;

    protected $fillable = [
        'id',
        'id_ativo',
        'data_hora',
        'valor',
        'status'
        ];

        public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
         ->logOnly(['*'])
         ->logOnlyDirty();
        // Chain fluent methods for configuration options
    }

        public function ativo()
    {
        return $this->hasOne(Ativo::class,  'id','id_ativo');
    }
}
