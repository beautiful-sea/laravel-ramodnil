@extends('ramodnil.page')

@section('css')
{{-- Seus estilos específicos de página aqui --}}
@endsection

@section('header-title')
<h1>Início</h1>
@stop


@section('content')

<div class="row">
	<div class="col-md-4">
		<div class="card card-info bg-info-gradient card-annoucement card-round">
			<div class="card-body text-center">
				<div class="card-opening">Bem-vindo @php $name = explode(" ",Auth::user()->name); echo $name[0] @endphp,</div>
				<div class="card-desc">
					Agora você pode iniciar um projeto e adicionar funcionalidades com muito mais agilidade!
				</div>
				<div class="card-detail">
					<div class="btn btn-light btn-rounded"><a href="https://github.com/beautiful-sea/laravel-ramodnil/blob/master/README.md#laravel-ramodnil" target="_blank"> Ler documentação</a></div>
				</div>
			</div>
		</div>
	</div>

	<div class="col-sm-6 col-md-3">
		<div class="card card-stats card-primary card-round">
			<div class="card-body">
				<div class="row">
					<div class="col-5">
						<div class="icon-big text-center">
							<i class="fa fa-users"></i>
						</div>
					</div>
					<div class="col col-stats">
						<div class="numbers">
							<p class="card-category">Usuários</p>
							<h4 class="card-title">{{count(App\User::all())}}</h4>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>
@stop

@section('js')
{{-- Seus scripts específicos de página aqui --}}
@endsection