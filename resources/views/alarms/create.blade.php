@extends('app')

@section('content')

<input type="hidden" name="entity" value="-1">
<input type="hidden" name="entitytype" value="-1">
<input type="hidden" name="alarmtype" value="-1">

<div class="page-header">
	<h2 class="ui header">Crea Nuova Scadenza</h2>
</div>

<div class="accordion" role="tablist" aria-multiselectable="true" id="steps">
	<div class="panel panel-success select-step-block">
		<div class="panel-heading" role="tab">
			<h4 class="panel-title">
				<a role="button" data-toggle="collapse" data-parent="#steps" data-target="#select-entity">1. Seleziona Elemento di Riferimento</a>
			</h4>
		</div>

		<div class="panel-collapse collapse in panel-body main-step" role="tabpanel" id="select-entity">
			<p>
				Scegli l'elemento cui la nuova scadenza verrà associata (oppure "Nessuno" per definire una scadenza generica).
			</p>

			<div class="panel-group accordion" role="tablist" aria-multiselectable="true" id="entities">
				@foreach($entitytype as $type)
				<div class="panel panel-default">
					<div class="panel-heading" role="tab">
						<h4 class="panel-title">
							<a role="button" data-toggle="collapse" data-parent="#entities" href=".entitytype-{{ $type->name }}">{{ $type->name }}</a>
						</h4>
					</div>
					<div class="entitytype-{{ $type->name }} panel-collapse collapse panel-body" role="tabpanel">
						<ul id="entitytype-{{ $type->id }}">
							@foreach($type->entities as $entity)
							<li id="entity-{{ $entity->id }}">{{ $entity->name }}</li>
							@endforeach
						</ul>
					</div>
				</div>
				@endforeach

				<div class="panel panel-default">
					<div class="panel-heading" role="tab">
						<h4 class="panel-title">
							<a role="button" data-toggle="collapse" data-parent="#entities" href=".entitytype-no">Nessuno</a>
						</h4>
					</div>
					<div class="entitytype-no panel-collapse collapse panel-body" role="tabpanel">
						<ul id="entitytype-no">
							<li id="entity-no">Non associare questa scadenza a nessun elemento</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="panel panel-success select-step-block">
		<div class="panel-heading" role="tab">
			<h4 class="panel-title">
				<a role="button" data-toggle="collapse" data-parent="#steps" data-target="#select-alarm">2. Seleziona Tipo di Scadenza</a>
			</h4>
		</div>
		<div class="panel-collapse collapse panel-body main-step" role="tabpanel" id="select-alarm">
		</div>
	</div>

	<div class="panel panel-success select-step-block">
		<div class="panel-heading" role="tab">
			<h4 class="panel-title">
				<a role="button" data-toggle="collapse" data-parent="#steps" data-target="#select-details">3. Definisci Dettagli della Scandeza</a>
			</h4>
		</div>
		<div class="panel-collapse collapse panel-body main-step" role="tabpanel" id="select-details">
		</div>
	</div>
</div>

@endsection
