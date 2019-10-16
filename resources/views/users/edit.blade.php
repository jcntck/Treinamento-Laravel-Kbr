@extends('layout')

@section('content')
<h2 class="text-center m-3">Editar dados</h2>
@if ($errors->any())
<div class="alert alert-danger m-2">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach

    </ul>
</div><br />
@endif
<div class="align-self-center">
    <form method="post" action="{{ route('users.update', $usuario->id) }}" enctype="multipart/form-data">
        @method('PATCH')
        {{ csrf_field() }}
        <div class="form-group">
            <label for="nome">Nome:</label>
            <input type="text" class="form-control" id="nome" name="nome" maxlength="255" value="{{ $usuario->nome }}">
        </div>
        <div class="form-group">
            <label for="email">Endereço de Email:</label>
            <input type="email" class="form-control" id="email" name="email" maxlength="100" value="{{ $usuario->email }}">
        </div>
        <div class="form-group">
            <label for="nascimento">Data de nascimento:</label>
            <input type="date" class="form-control" id="nascimento" name="nascimento" value="{{ $usuario->dt_nascimento }}">
        </div>
        <div class="form-group">
            <label for="categoria">Categoria pertencente:</label>
            <select name="categoria" id="categoria" class="custom-select">
                <option value="">-- Categorias --</option>
                @foreach($categorias as $categoria)
                <option value="{{ $categoria->id }}" @if($usuario->categoria_id == $categoria->id) selected @endif>{{ $categoria->nome }}</option>
                @endforeach
            </select>
        </div>
        <p>Alterar foto de perfil:</p>
        <div class="d-flex border p-sm-2 mb-1">
        @if($usuario->ft)
        <div class="edit-ft">
            <img src='{{ url("public/images/{$usuario->ft}") }}' class="img-fluid mr-3" width="100" alt="Foto atual" title="Foto atual">
        </div>
        @endif
        <div class="form-inline">
            <input type="file" class="form-control-file" id="img" name="img" aria-describedby="imgHelp" accept="image/*">
            <small id="imgHelp" class="form-text text-danger">Este campo é opcional.</small>
        </div>
        </div>
        <button type="submit" class="btn btn-primary">Enviar</button>
    </form>
</div>
@endsection