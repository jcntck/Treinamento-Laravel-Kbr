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
<h2 class="text-center m-3">Cadastro de Categoria</h2>
<form method="post" action="{{ route('categories.store') }}" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="form-group mx-auto w-75">
        <label for="nome">Nome:</label>
        <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome da categoria" autofocus>
        <button type="submit" class="btn btn-primary mt-2">Enviar</button>
    </div>
</form>
@endsection