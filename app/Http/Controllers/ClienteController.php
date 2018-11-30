<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\ClienteRepository;
use App\Repository\InvestimentosRepository;
class ClienteController extends Controller
{

    function __construct(){
        // $this->middleware('cliente_existente')->only([
        //    'destroy'
        // ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ClienteRepository $repo)
    {
        return view('clientes.index',[
            'clientes'=> $repo->listaClientes()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(InvestimentosRepository $invRepo )
    {
        return view('clientes.create',
                            [
                                'investimentos'=>$invRepo->listaInvestimentos()
                            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,
                            ClienteRepository $repo,
                            InvestimentosRepository $invRepo)
    {
        
        $this->validate($request,[
                    'cliente_nome'=>'required|string',
                    'cliente_email'=>'required|email',
                    'cliente_telefone'=>'required|phone_number',//registrado validacao no privider
                    'cliente_cidade'=>'required|string',
                    'cliente_agencia'=>'required|string',
                    'cliente_investimentos'=>'array'
        ],[
            'cliente_nome.required'=>'nome do cliente nao preenchido',
            'cliente_nome.string'=>'nome preenchido incorretamente',
            'cliente_email.required'=>'Email deve ser preenchido',
            'cliente_email.email'=>'Campo email incorreto',
            'cliente_telefone.required'=>'Telefone deve ser preenchido',
            'cliente_telefone.phone_number'=>'Campo telefone incorreto',
            'cliente_cidade.required'=>'Clidade é um campo obrigatorio',
            'cliente_cidade.string'=>'Cidade preenchida incorretamente',
            'cliente_agencia.required'=>'Agencia é um campo obrigatorio',
            'cliente_agencia.string'=>'Agencia preenchido incorretamente',
            'cliente_investimentos.array'=>'campo incorreto'
        ]);

        try{
            //cria novo cliente e retorna o cliente se for criado com sucesso
            if($cliente = $repo->novo($request->get('cliente_nome'),
                            $request->get('cliente_email'),
                            $request->get('cliente_telefone'),
                            $request->get('cliente_agencia'),
                            $request->get('cliente_cidade'))){
                    
                // gera os relacionamentos do cliente com os investimentos selecionados pelo mesmo
                if($request->get('cliente_investimentos'))                        
                        $invRepo->relaciona(
                        $cliente,
                        $request->get('cliente_investimentos'));
                
                return redirect()
                ->back()
                ->withSuccess('Cliente salvo com sucesso!');
            }else{
                return redirect()
                ->back()->withError('Ocorreu um erro interno, tente mais tarde!');    
            }
        }catch(\Exception $e){
            return redirect()
            ->back()->withError('Ocorreu um erro interno, tente mais tarde!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        $cliente = \App\Models\Cliente::find($id);
        return view('clientes.show',['cliente'=>$cliente]);
    }

    /**
     * Show the form for editing the specified resource.
     *  DESATIVADO SERA UTILIZADA A FUNÇÃO DE SHOW COMO UM FORMULARIO
     * DESATIVADO NA DECLARAÇÃO DA ROTA 
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cliente = \App\Models\Cliente::find($id);
        return view('clientes.edit',['cliente'=>$cliente]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, 
                            $id,
                            ClienteRepository $repo,
                            InvestimentosRepository $invRepo)
    {
    
        $this->validate($request,[
            'cliente_nome'=>'string',
            'cliente_email'=>'email',
            'cliente_telefone'=>'phone_number',//registrado validacao no privider
            'cliente_cidade'=>'string',
            'cliente_agencia'=>'string',
            'cliente_investimentos'=>'array'
            ],[
            
                'cliente_nome.string'=>'nome preenchido incorretamente',
                'cliente_email.email'=>'Campo email incorreto',
                'cliente_telefone.phone_number'=>'Campo telefone incorreto',
                'cliente_cidade.string'=>'Cidade preenchida incorretamente',
                'cliente_agencia.string'=>'Agencia preenchido incorretamente',
                'cliente_investimentos.array'=>'campo incorreto'
        ]);
                  
        try{
            if($repo->atualiza( $id,
                            $request->get('cliente_nome'),
                            $request->get('cliente_email'),
                            $request->get('cliente_telefone'),
                            $request->get('cliente_agencia'),
                            $request->get('cliente_cidade'))){
                $cliente = \App\Models\Cliente::find($id);
                if($invRepo->relaciona(
                    $cliente,
                    $request->get('cliente_investimentos')))
                return redirect()->back()->withSuccess('Cliente Atualizado com sucesso!');
            }

                return redirect()->back()
            ->withError('ocorreu um erro interno! tente novamente mais tarde');
            
        }catch(\Exception $e){
            return redirect()->back()
            ->withErrors(['ocorreu um erro interno! tente novamente mais tarde']);
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cliente = Cliente::find($id);
        try{

            if($cliente->delete())
                return redirect()->back()->withSuccess('Cliente Removido com sucesso!');
            
        }catch(Exception $e){
            
        }
        return redirect()->back()->withError('Ocorreu um erro interno, favor tente novamente mais tarde');
        
    }
}
