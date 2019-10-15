@extends('layout')

@section('content')
<h2 class="text-center m-3">Cadastro de Categoria</h2>
@if ($errors->any())
<div class="alert alert-danger m-2">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach

    </ul>
</div><br />
@endif
<form method="post" action="{{ route('categories.update', $categoria->id ) }}" enctype="multipart/form-data">
    @method('PATCH')
    {{ csrf_field() }}
    <div class="form-group mx-auto w-50">
        <label for="nome">Nome:</label>
        <input type="text" class="form-control" id="nome" name="nome" value="{{ $categoria->nome }}">
        <button type="submit" class="btn btn-primary mt-2">Enviar</button>
    </div>
</form>
@endsection