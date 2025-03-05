<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Posicao extends Model
{
    use  LogsActivity;
    protected $table = 'posicao_ativos';
        protected $primaryKey = 'id_ativo'; // Defina a chave primária, se necessário
        public $timestamps = false; 
        public function getActivitylogOptions(): LogOptions
        {
            return LogOptions::defaults()
             ->logOnly(['*'])
             ->logOnlyDirty();
            // Chain fluent methods for configuration options
        }
    
}
