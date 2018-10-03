@extends('layouts.edytor')
@section('title', 'Edytor')
@section('content')


	<div class="tabs">

			<ul class="nav nav-tabs">

					<li class="active"><a href="#wyznacz_recenzentow">Wyznacz recenzentów</a></li>
					<li><a href="#do_akceptacji">Do akceptacji</a></li>
					<li><a href="#oczekujace_recenzjii">Oczekujące na recenzje</a></li>
					<li><a href="#odrzucone">Odrzucone</a></li>
					<li><a href="#opublikowane">Zaakceptowane</a></li>
					<li><a href="#dopoprawy">Do poprawy</a></li>

			</ul>


		<div class="tab-content">
			<div id="wyznacz_recenzentow" class="table-responsive">

				<div class="input-group">
					{!! Form::text('szukaj_do_wystawienia',null,['placeholder'=>'wpisz tytuł','id'=>'szukaj_wyznacz','class'=>'form-control']) !!}
					<div class="input-group-addon"><span class="glyphicon glyphicon-search"> </span></div>
				</div>
				<table class="table table-striped">
					<thead>
					<tr>
						<th>Tytuł</th>
						<th>Data dodania</th>
					</tr>
					</thead>
					<tbody>
						@foreach($wyznacz_recenzentow as $page)
							<tr>

								<th><a class="text" href="{{route('hello.create',$page)}}">{{$page->title}}</a></th>
								<th>{{$page->created_at}}</th>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>

			<div id="do_akceptacji" class="table-responsive" style="display:none">
				<div class="input-group">
					{!! Form::text('szukaj_akceptacja',null,['placeholder'=>'wpisz tytuł','id'=>'szukaj_akceptacja','class'=>'form-control']) !!}
					<div class="input-group-addon"><span class="glyphicon glyphicon-search"> </span></div>
				</div>
				<table class="table table-striped">
					<thead>
					<tr>
						<th>Tytuł</th>
						<th>Data dodania</th>
					</tr>
					</thead>
					<tbody>
						@foreach($do_akceptacji as $page)
							<tr>
								<th><a class="text" href="{{route('hello.show',$page)}}">{{$page->title}}</a></th>
								<th>{{$page->created_at}}</th>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>

			<div id="oczekujace_recenzjii" class="table-responsive" style="display:none">

				<div class="input-group">
					{!! Form::text('szukaj_oczekujace',null,['placeholder'=>'wpisz tytuł','id'=>'szukaj_oczekujace','class'=>'form-control']) !!}
					<div class="input-group-addon"><span class="glyphicon glyphicon-search"> </span></div>
				</div>

				<table class="table table-striped">
					<thead>
					<tr>
						<th>Tytuł</th>
						<th>Data dodania</th>
						<th>Opcje</th>
					</tr>
					</thead>
					<tbody>
						@foreach($oczekujace_recenzje as $page)
							<tr>

								<th><a class="text" href="{{route('hello.show',$page)}}">{{$page->title}}</a></th>
								<th>{{$page->created_at}}</th>
								<th>
									<a href="{{route('hello.edit',$page)}}">
										<button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="bottom" title="Zmień Date">
											<span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
										</button>
									</a>
									<a href="{{route('hello.editRecenzent',$page)}}">
										<button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="bottom" title="Zmień Recezentów">
											<span class="glyphicon glyphicon-user" aria-hidden="true"></span>
										</button>
									</a>
								</th>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>

			<div id="odrzucone" class="table-responsive" style="display:none">
				<div class="input-group">
					{!! Form::text('szukaj_odrzucone',null,['placeholder'=>'wpisz tytuł','id'=>'szukaj_odrzucone','class'=>'form-control']) !!}
					<div class="input-group-addon"><span class="glyphicon glyphicon-search"> </span></div>
				</div>

				<table class="table table-striped">
					<thead>
					<tr>
						<th>Tytuł</th>
						<th>Data dodania</th>

					</tr>
					</thead>
					<tbody>
						@foreach($odrzucone as $page)
							<tr>
								<th><a class="text" href="{{route('hello.show',$page)}}">{{$page->title}}</a></th>
								<th>{{$page->created_at}}</th>
							</tr>
						@endforeach
					</tbody>
				</table>
				<script type="text/javascript" src={{asset("js/paginathing.js")}}></script>
			</div>

			<div id="opublikowane" class="table-responsive" style="display:none">
				<div class="input-group">
					{!! Form::text('szukaj_opublikowane',null,['placeholder'=>'wpisz tytuł','id'=>'szukaj_opublikowane','class'=>'form-control']) !!}
					<div class="input-group-addon"><span class="glyphicon glyphicon-search"> </span></div>
				</div>

				<table class="table table-striped">
					<thead>
						<tr>
							<th>Tytuł</th>
							<th>Data dodania</th>

						</tr>
					</thead>
					<tbody>
					@foreach($zaakceptowane as $page)
						<tr>
							<th><a class="text" href="{{route('hello.show',$page)}}">{{$page->title}}</a></th>
							<th>{{$page->created_at}}</th>
						</tr>
					@endforeach
					</tbody>
				</table>
			</div>

			<div id="dopoprawy" class="table-responsive" style="display:none">
				<div class="input-group">
					{!! Form::text('szukaj_dopoprawy',null,['placeholder'=>'wpisz tytuł','id'=>'szukaj_dopoprawy','class'=>'form-control']) !!}
					<div class="input-group-addon"><span class="glyphicon glyphicon-search"> </span></div>
				</div>

				<table class="table table-striped">
					<thead>
					<tr>
						<th>Tytuł</th>
						<th>Data dodania</th>

					</tr>
					</thead>
					<tbody>
					@foreach($dopoprawy as $page)
						<tr>
							<th><a class="text" href="{{route('hello.show',$page)}}">{{$page->title}}</a></th>
							<th>{{$page->created_at}}</th>
						</tr>
					@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>



	<script>
        $('#szukaj_wyznacz').keyup(function() {
            var $rows = $('#wyznacz_recenzentow .table tbody tr');
            var val = '^(?=.*\\b' + $.trim($(this).val()).split(/\s+/).join('\\b)(?=.*\\b') + ').*$',
                reg = RegExp(val, 'i'),
                text;

            $rows.show().filter(function() {
                text = $(this).text().replace(/\s+/g, ' ');
                return !reg.test(text);
            }).hide();

        });

        $('#szukaj_dopoprawy').keyup(function() {
            var $rows = $('#dopoprawy .table tbody tr');
            var val = '^(?=.*\\b' + $.trim($(this).val()).split(/\s+/).join('\\b)(?=.*\\b') + ').*$',
                reg = RegExp(val, 'i'),
                text;

            $rows.show().filter(function() {
                text = $(this).text().replace(/\s+/g, ' ');
                return !reg.test(text);
            }).hide();

        });


        $('#szukaj_akceptacja').keyup(function() {
            var $rows = $('#do_akceptacji .table tbody tr');
            var val = '^(?=.*\\b' + $.trim($(this).val()).split(/\s+/).join('\\b)(?=.*\\b') + ').*$',
                reg = RegExp(val, 'i'),
                text;

            $rows.show().filter(function() {
                text = $(this).text().replace(/\s+/g, ' ');
                return !reg.test(text);
            }).hide();

        });

        $('#szukaj_oczekujace').keyup(function() {
            var $rows = $('#oczekujace_recenzjii .table tbody tr');
            var val = '^(?=.*\\b' + $.trim($(this).val()).split(/\s+/).join('\\b)(?=.*\\b') + ').*$',
                reg = RegExp(val, 'i'),
                text;

            $rows.show().filter(function() {
                text = $(this).text().replace(/\s+/g, ' ');
                return !reg.test(text);
            }).hide();

        });
        $('#szukaj_odrzucone').keyup(function() {
            var $rows = $('#odrzucone .table tbody tr');
            var val = '^(?=.*\\b' + $.trim($(this).val()).split(/\s+/).join('\\b)(?=.*\\b') + ').*$',
                reg = RegExp(val, 'i'),
                text;

            $rows.show().filter(function() {
                text = $(this).text().replace(/\s+/g, ' ');
                return !reg.test(text);
            }).hide();

        });

        $('#szukaj_opublikowane').keyup(function() {
            var $rows = $('#opublikowane .table tbody tr');
            var val = '^(?=.*\\b' + $.trim($(this).val()).split(/\s+/).join('\\b)(?=.*\\b') + ').*$',
                reg = RegExp(val, 'i'),
                text;

            $rows.show().filter(function() {
                text = $(this).text().replace(/\s+/g, ' ');
                return !reg.test(text);
            }).hide();

        });


	</script>







@endsection