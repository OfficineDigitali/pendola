<p>
	Scegli il tipo di scadenza da associare all'elemento selezionato, oppure creane uno nuovo.
</p>

@if(count($structured) == 0)
<div class="alert alert-info">
	Non sono stati definiti tipi di scadenze per questa tipologia di elemento.
</div>
@endif

<ul>
	@foreach($structured as $unit)
	<li class="alarmtype" id="alarm-{{ $unit->alarm->id }}">
		<p>
			{{ $unit->alarm->name }}
		</p>

		@if(count($unit->pendings) != 0)
		<ul>
			@foreach($unit->pendings as $p)
			<li>{{ $p->printableFullDate() }}</li>
			@endforeach
		</ul>
		@endif
	</li>
	@endforeach
</ul>

<button type="button" class="btn btn-default" data-toggle="modal" data-target="#create-new-alarm">Crea Nuovo Tipo di Scadenza</button>

<div class="modal fade" id="create-new-alarm" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Nuovo Tipo di Scadenza</h4>
			</div>

			<form class="form-horizontal">
				<div class="modal-body">
					<div class="form-group">
						<label class="col-sm-2 control-label">Nome</label>
						<div class="col-md-10">
							<input class="form-control" name="name" type="text">
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-2 control-label">Tipo</label>
				        	<div class="col-sm-10">
							<div class="radio-inline">
								<input name="type" checked="" type="radio" value="date"> Data Singola
							</div>
							<div class="radio-inline">
								<input name="type" type="radio" value="interval"> Intervallo (Data Inizio / Data Fine)
							</div>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-2 control-label">Ricorrenza</label>
				        	<div class="col-sm-10">
							<div class="radio-inline">
								<input name="recurrence" checked="" type="radio" value="once"> Data Singola
							</div>
							<div class="radio-inline">
								<input name="recurrence" type="radio" value="weekly"> Ripeti ogni Settimana
							</div>
							<div class="radio-inline">
								<input name="recurrence" type="radio" value="monthly"> Ripeti ogni Mese
							</div>
							<div class="radio-inline">
								<input name="recurrence" type="radio" value="yearly"> Ripeti ogni Anno
							</div>
							<div class="radio-inline">
								<input name="recurrence" type="radio" value="custom-interval"> Intervallo Personalizzato
							</div>
						</div>
					</div>

					<div class="revealing" id="custom-interval">
						<div class="form-group">
							<label class="col-sm-2 control-label">Personalizza</label>
							<div class="col-sm-5">
								<input class="form-control" type="text" name="custom-recurrence-quantity">
							</div>
							<div class="col-sm-5">
								<select class="form-control" name="custom-recurrence-unit">
									<option value="day">Giorni</option>
									<option value="week">Settimane</option>
									<option value="month">Mesi</option>
									<option value="year">Anni</option>
								</select>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Annulla</button>
					<button type="submit" class="btn btn-primary">Salva</button>
				</div>
			</form>
		</div>
	</div>
</div>
