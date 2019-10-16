@extends('layout')

@section('content')
@foreach($usuario as $usuario)
<div class="border-bottom py-2 my-3">
    <div class="text-center text-sm-left">
        @if($usuario->ft)
        <img src='{{ url("public/images/{$usuario->ft}") }}' alt="Imagem de perfil do {{ $usuario->nome }}" title="Imagem de perfil do {{ $usuario->nome }}" class="img-thumbnail mb-3 mb-sm-0" width="150">
        @else
        <img src='{{ url("public/images/default.jpg") }}' alt="Sem foto de perfil" title="Sem foto de perfil" class="img-thumbnail mb-3 mb-sm-0">
        @endif

        <h3 class="d-sm-inline mx-4">{{ $usuario->nome }}</h3>
        <div class="d-inline mx-sm-2">
            @if($usuario->categoria_id)
            <span class="text-muted">Categoria: {{ $usuario->categoria->nome }}</span>
            @else
            <span class="text-muted">Categoria: ---</span>
            @endif
        </div>
    </div>
</div>
<div>
    <p><span class="font-weight-bold">Data de nascimento:</span> {{ \Carbon\Carbon::parse($usuario->dt_nascimento)->format('d/m/Y') }}</p>
    <p><span class="font-weight-bold">E-mail:</span> {{ $usuario->email }}</p>
</div>
<a href="{{ route('users.index') }}" alt="Retornar à pagina principal" title="Retornar" class="btn btn-info float-right">Voltar</a>
@endforeach
@endsection