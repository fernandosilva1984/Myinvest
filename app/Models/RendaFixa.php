<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class RendaFixa extends Model
{
    use HasFactory, SoftDeletes,  LogsActivity;
    protected $fillable = [
        'id',
        'id_ativo',
        'descrição',
        'data_aplicacao',
        'prazo',
        'dias_corridos',
        'data_venc',
        'valor_aplic',
        'valor_atual',
        'iof',
        'ir',
        'indice',
        'taxa',
        'taxa_rent',
        'id_banco_emissor',
        'id_banco_gestor',
        'id_carteira',
        'conta',
        'status'
        ];

        public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
         ->logOnly(['*'])
         ->logOnlyDirty();
        // Chain fluent methods for configuration options
    }
        public function carteira()
        {
            return $this->hasOne(Carteira::class,  'id','id_carteira');
        }
        public function ativo()
        {
            return $this->hasOne(Ativo::class,  'id','id_ativo');
        }
        public function banco_emissor()
        {
            return $this->hasOne(Banco::class,  'id','id_banco_emissor');
        }
        public function Banco_gestor()
        {
            return $this->hasOne(Banco::class,  'id','id_banco_gestor');
        }
}
