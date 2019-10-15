@extends('layout')

@section('content')

@if(session()->get('success'))
<div class="alert alert-info alert-dismissible fade show" role="alert">
    {{ session()->get('success') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div><br />
@endif
<div class="my-3">
    <h2 class="mt-2 mb-3 d-inline">Usuários</h2>
    <form action="{{ route('users.index') }}" role="search" class="form-inline float-right">
        <input class="form-control" name="search" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-primary mx-1" type="submit"><i class="fas fa-search"></i></button>
    </form>
</div>
@if(count($usuarios) > 0)
<table class="table table-striped  mt-3">
    <thead>
        <tr>
            <td>Imagem</td>
            <td>Nome</td>
            <td>E-mail</td>
            <td>Data de nascimento</td>
            <td class="text-center">Categoria</td>
            <td>Criado em</td>
            <td colspan="4" class="text-center">Ações</td>
        </tr>
        <thead>
        <tbody>
            @foreach($usuarios as $usuario)
            <tr>
                @if($usuario->thumb)
                <td><img src='{{ url("thumbnail/{$usuario->thumb}") }}' alt="Imagem de perfil do {{ $usuario->nome }}" title="Imagem de perfil do {{ $usuario->nome }}" class="img-thumbnail"></td>
                @else
                <td><img src='{{ url("thumbnail/default.jpg") }}' alt="Sem foto de perfil" title="Sem foto de perfil" class="img-thumbnail"></td>
                @endif
                <td class="align-middle">{{ $usuario->nome }}</td>
                <td class="align-middle">{{ $usuario->email }}</td>
                <td class=" align-middle font-italic">{{ \Carbon\Carbon::parse($usuario->dt_nascimento)->format('d/m/Y') }}</td>
                @if($usuario->categoria_id)
                <td class="align-middle text-center col">{{ $usuario->categoria->nome }}</td>
                @else
                <td class="text-center align-middle"> - </td>
                @endif
                <td class="text-muted align-middle"><small>{{ \Carbon\Carbon::parse($usuario->created_at)->format('d/m/Y  g:i:s a') }}</small></td>
                <td><a href="{{ route('users.edit', $usuario->id) }}" class="btn btn-outline-secondary" title="Editar usuário"><i class="fas fa-user-edit"></i></a></td>
                <td><a href="{{ route('users.show', $usuario->id) }}" class="btn btn-outline-info" title="Vizualizar usuário"><i class="fas fa-search-plus"></i></a></td>
                <td>
                    <form action="{{ route('users.destroy', $usuario->id) }}" class="form-inline" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn btn-outline-danger" type="submit" title="Apagar usuário"><i class="fas fa-trash"></i></button>
                    </form>
                </td>
                <td><a href="{{ url('users/notificar', $usuario->id) }}" class="btn btn-outline-secondary" title="Notificar usuário"><i class="far fa-envelope"></i></a></td>
            </tr>
            @endforeach
        </tbody>
</table>
{{ $usuarios->appends(['search' => isset($search) ? $search : ''])->links() }}
@endif

@endsection