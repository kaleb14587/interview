<?php

namespace App\Repository;

use App\Models\Cliente;

class ClienteRepository
{
    
    private $cliente;

    function __construct (Cliente $cliente=null ){
        $this->cliente = $cliente ;
    }

    public function listaClientes(){
        return Cliente::with('investimentos')->get();
    }
    /**
     * @return Cliente|null
     */
    public function novo($nome,$email,$telefone,$agencia,$cidade){
        $cliente =  new Cliente();
        $cliente->nome      = $nome;
        $cliente->email     = $email;
        $cliente->telefone  = $telefone;
        $cliente->agencia   = $agencia;
        $cliente->cidade    = $cidade;
        if($cliente->save())return $cliente;
        else return null;
    }

     /**
     * @return boolean
     */
    public function atualiza($cliente_id,$nome,$email,$telefone,$agencia,$cidade){
        $cliente =  Cliente::find($cliente_id);
        if(!empty($nome))
        $cliente->nome      = $nome;
        if(!empty($email))
        $cliente->email     = $email;
        if(!empty($telefone))
        $cliente->telefone  = $telefone;
        if(!empty($agencia))
        $cliente->agencia   = $agencia;
        if(!empty($cidade))
        $cliente->cidade    = $cidade;

        if($cliente->save())return true;
        else return false;
    }
}