<?php

namespace App\Repository;

use App\Models\Cliente;
use App\Models\TipoInvestimento;
use Illuminate\Support\Collection;
class InvestimentosRepository
{

    /**
     * @return Collection 
     */
    public function listaInvestimentos(){
        return TipoInvestimento::select(['descricao','titulo','rendimento','id'])->get();
    }
    /**
     * @return bool 
     */
    public function relaciona(Cliente $cliente,$investimentos=[]){
        
        if(!is_array($investimentos))return false;

        try{
            //remove relacionamentos
            $cliente->investimentos()->detach();
            // adiciona relacionamentos
            $cliente->investimentos()->attach($investimentos,['created_at'=>\Carbon\Carbon::now()]);
            // retorna sucesso se chegar aqui
            return true;
        }catch(\Exception $e){
            return false;
        }
    }
}