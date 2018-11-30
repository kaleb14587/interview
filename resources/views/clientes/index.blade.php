@extends('layout.master')


@section('conteudo')

<a href="{{route('clientes.create')}}">adicionar novo</a>
<table>
<thead>
<tr>
<th>nome</th>
<th>email</th>
<th>telefone</th>
<th>agencia</th>
<th>cidade</th>
<th>Açao </th>
</tr>

</thead>
@foreach($clientes as $cliente)
<tr>
    <td>{{$cliente->nome}}</td>
    <td>{{$cliente->email}}</td>
    <td>{{$cliente->telefone}}</td>
    <td>{{$cliente->agencia}}</td>
    <td>{{$cliente->cidade}}</td>
    <td><a href="{{route('clientes.edit',[$cliente->id])}}">Editar</a></td>
</tr>
@endforeach
</table>
@endsection
