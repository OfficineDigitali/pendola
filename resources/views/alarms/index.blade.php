@extends('app')

@section('content')

@include('commons.toolbar', ['creation_url' => 'alarms/create'])

@if(count($alarms) == 0)
	<div class="alert alert-info">
		Non ci sono scadenze attive.
	</div>
@else
	@foreach($alarms as $month => $sorted)
		<div class="row">
			<div class="page-header text-center">
				<h3>{{ $month }}</h3>
			</div>
		</div>

		@if(count($sorted) == 0)
			<div class="row text-center">
				<p>Non ci sono scadenze per questo mese</p>
			</div>
		@else
			@foreach($sorted as $a)
				@if($a instanceof App\Alarm)
				<div class="row alert alert-{{ $a->status }} item">
					<form method="POST" action="{{ url('alarms/' . $a->id) }}">
						<input type="hidden" name="item_id" value="{{ $a->id }}">
						<input type="hidden" name="item_type" value="{{ 'alarms' }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">

						<div class="col-md-6">
							<h4>
								<span class="glyphicon glyphicon-{{ $a->icon() }}" aria-hidden="true"></span> {{ $a->simpleName() }}
							</h4>

							<p class="inline-edit">
								<span class="value">{{ $a->printableFullDate() }}</span>
								<input type="text" class="form-control edit date" name="date1" value="{{ $a->date1 }}" />
							</p>

							<p class="inline-edit">
								<span class="value">{!! nl2br($a->notes) !!}</span>
								<textarea class="form-control edit" name="notes" rows="2">{{ $a->notes }}</textarea>
							</p>

							<p class="inline-edit">
								<input type="button" class="btn btn-default edit cancel-edit" value="Annulla" />
								<input type="submit" class="btn btn-success edit" value="Salva" />
								<input type="button" class="btn btn-danger delete-button edit pull-right" value="Elimina" />
							</p>
						</div>
					</form>

					<div class="col-md-6">
						<div class="btn btn-group pull-right">
							<button class="btn btn-default">
								<span class="glyphicon glyphicon-edit edit-button" aria-hidden="true"></span>
							</button>

							<button class="btn btn-default inline-action">
								<span class="glyphicon glyphicon-send" aria-hidden="true"></span>
							</button>
							<div class="popup hidden">
								<form method="POST" action="{{ url('alarms/' . $a->id) }}">
									<input type="hidden" name="action" value="mail">
									<input type="hidden" name="_token" value="{{ csrf_token() }}">

									<div class="form-group">
										<label class="control-label">Invia a</label>
										<select class="form-control multiselect" name="recipient[]" multiple="multiple">
											@foreach($iterable_mails as $mail)
											<option value="{{ $mail }}">{{ $mail }}</option>
											<@endforeach
										</select>
									</div>

									<div class="form-group">
										<label class="control-label">Messaggio (opzionale)</label>
										<textarea class="form-control" name="message" rows="2"></textarea>
									</div>

									<button class="btn btn-default pull-right" type="submit">Invia</button>
								</form>
							</div>

							<button class="btn btn-default inline-action">
								<span class="glyphicon glyphicon-repeat" aria-hidden="true"></span>
							</button>
							<div class="popup hidden">
								<form method="POST" action="{{ url('alarms/' . $a->id) }}">
									<input type="hidden" name="action" value="remind">
									<input type="hidden" name="_token" value="{{ csrf_token() }}">

									<label class="control-label">Ricordamelo</label>
									<div class="radio">
										<label>
											<input name="reminder-offset" name="interval" checked="" type="radio" value="day">
											Domani
										</label>
									</div>
									<div class="radio">
										<label>
											<input name="reminder-offset" name="interval" type="radio" value="week">
											A Inizio Settimana
										</label>
									</div>
									<div class="radio">
										<label>
											<input name="reminder-offset" name="interval" type="radio" value="month">
											Tra un Mese
										</label>
									</div>
									<div class="form-group">
										<label class="control-label">Note (opzionale)</label>
										<textarea class="form-control" name="notes" rows="2"></textarea>
									</div>
									<button class="btn btn-default pull-right" type="submit">Salva</button>
								</form>
							</div>

							<button class="btn btn-default inline-action">
								<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
							</button>
							<div class="popup hidden">
								<form method="POST" action="{{ url('alarms/' . $a->id) }}">
									<input type="hidden" name="action" value="close">
									<input type="hidden" name="_token" value="{{ csrf_token() }}">

									<p>
										Cliccando il tasto sotto, la scadenza verrà marcata come "completata" e rimossa dall'elenco.
									</p>
									@if($a->type->recurrence != 'once')
									<p>
										Una nuova istanza verrà creata per la prossima ricorrenza della scadenza.
									</p>
									@endif
									<button class="btn btn-default pull-right" type="submit">Completo!</button>
								</form>
							</div>
						</div>
					</div>
				</div>
				@elseif($a instanceof App\Reminder)
				<div class="row alert alert-info">
					<div class="col-md-6">
						<h4>
							RICORDA! <span class="glyphicon glyphicon-{{ $a->alarm->entity->type->icon }}" aria-hidden="true"></span> {{ $a->alarm->entity->name }} | {{ $a->alarm->type->name }}
						</h4>

						<p>
							{{ $a->alarm->printableFullDate() }}
						</p>

						<p>
							{!! nl2br($a->notes) !!}
						</p>
					</div>
				</div>
				@endif
			@endforeach
		@endif
	@endforeach
@endif

@endsection
