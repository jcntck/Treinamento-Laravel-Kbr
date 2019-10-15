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
    <h2 class="mt-2 mb-3 d-inline">Categorias</h2>
    <a href="{{ route('categories.create') }}" class="btn btn-primary text-white float-right">Cadastrar categoria</a>
</div>
@if(count($categorias) > 0)
<table class="table table-striped my-2 mb-auto">
    <thead>
        <tr>
            <td scope="col">Id</td>
            <td scope="col">Nome</td>
            <td scope="col" colspan='4' class="text-center">Ações</td>
        </tr>
        <thead>
        <tbody>
            @foreach($categorias as $categoria)
            <tr>
                <td class="align-middle">{{ $categoria->id }}</td>
                <td class="align-middle col">{{ $categoria->nome }}</td>
                <td><a href="{{ route('categories.edit', $categoria->id) }}" class="btn btn-outline-secondary" title="Editar categoria"><i class="fas fa-user-edit"></i></a></td>
                <td>
                    <form action="{{ route('categories.destroy', $categoria->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn btn-outline-danger" type="submit" title="Apagar categoria"><i class="fas fa-trash"></i></button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
</table>
{{ $categorias->links() }}
@endif
@endsection