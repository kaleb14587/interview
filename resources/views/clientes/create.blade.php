@extends('layout.master')

@section('conteudo')
<form action="{{route('clientes.store')}}" method="post" style="display:flex">
{{ csrf_field() }}
<input placeholder="nome" name="cliente_nome" type="text"/>
<input placeholder="email" name="cliente_email" type="email"/>
<input placeholder="telefone" name="cliente_telefone" type="number"/>
<input placeholder="cidade" name="cliente_cidade" type="text"/>
<input placeholder="agencia" name="cliente_agencia" type="text"/>
<input type="submit" value="Salvar"/>
</form>
@endsection