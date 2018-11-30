@extends('layout.master')


@section('conteudo')
<form action="{{route('clientes.update',[$cliente->id])}}" method="PATCH" style="display:flex">
{{ csrf_field() }}
<input placeholder="nome" name="cliente_nome" value="{{$cliente->nome}}" type="text"/>
<input placeholder="email" name="cliente_email" value="{{$cliente->email}}" type="email"/>
<input placeholder="telefone" name="cliente_telefone" value="{{$cliente->telefone}}"type="number"/>
<input placeholder="cidade" name="cliente_cidade" value="{{$cliente->cidade}}"type="text"/>
<input placeholder="agencia" name="cliente_agencia" type="text" value="{{$cliente->agencia}}"/>
<input type="submit" value="Salvar"/>
</form>

@endsection