<html>
	<body>
		<div style="height: 100vh; text-align: center">
            <h1 style="margin: 30px 0">Informações do usuário:</h1>
            <p><span style="font-weight: 700">Nome: </span>{{$user->nome}}</p>
            <p><span style="font-weight: 700">Data de nascimento: </span>{{\Carbon\Carbon::parse($user->dt_nascimento)->format('d/m/Y')}}</p>
            <p><span style="font-weight: 700">E-mail: </span>{{$user->email}}</p>
            <p><span style="font-weight: 700">Criado em: </span>{{ \Carbon\Carbon::parse($user->created_at)->format('d/m/Y  G:i:s ') }}</p>
            <p><span style="font-weight: 700">Última atualização em: </span>{{ \Carbon\Carbon::parse($user->updated_at)->format('d/m/Y  G:i:s ') }}</p>
		</div>
	</body>
</html>