<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    public function investimentos(){
        return $this->belongsToMany(TipoInvestimento::class ,'cliente_investimentos','id','id_cliente');
    }
}
