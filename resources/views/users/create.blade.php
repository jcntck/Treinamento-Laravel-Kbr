@extends('layout')

@section('content')
@if ($errors->any())
<div class="alert alert-danger m-2">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
        
    </ul>
</div><br />
@endif
<h2 class="text-center m-3">Cadastro de usuário</h2>
<div class="align-self-center">
    <form method="post" action="{{ route('users.store') }}" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="form-group">
            <label for="nome">Nome:</label>
            <input type="text" class="form-control" id="nome" name="nome" placeholder="Digite seu nome completo">
        </div>
        <div class="form-group">
            <label for="email">Endereço de Email:</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Digite seu email">
        </div>
        <div class="form-group">
            <label for="nascimento">Data de nascimento:</label>
            <input type="date" class="form-control" id="nascimento" name="nascimento" placeholder="Digite sua data de nascimento">
        </div>
        <div class="form-group">
            <label for="categoria">Categoria pertencente:</label>
            <select name="categoria" id="categoria" class="custom-select">
                <option value="" selected>-- Categorias --</option>
                @foreach($categorias as $categoria)
                <option value="{{ $categoria->id }}">{{ $categoria->nome }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="img">Foto de perfil:</label>
            <input type="file" class="form-control-file" id="img" name="img" aria-describedby="imgHelp" accept="image/*">
            <small id="imgHelp" class="form-text text-danger">Este campo é opcional.</small>
        </div>
        <button type="submit" class="btn btn-primary">Enviar</button>
    </form>
</div>
@endsection