@layout('layouts.common')

@section('content')
<div class="container">
	<h1>Mina events</h1>
	<p>Bara de events som du själv skapat syns i listan.</p>
	<table class="table table-bordered table-striped table-condensed">
		<tbody>
			@foreach ($events as $event)
				<tr>
					<th colspan="5">{{{ $event->name }}}</th>
				</tr>
				<tr>
					<th style="text-align: center"><img style="max-width: none;" src="{{ $event->picture }}" ></th>
					<th>{{ nl2br(e($event->description)) }}</th>
					<th style="white-space: nowrap">{{ date("Y-m-d H:i", strtotime($event->start_time)) }}</th>
					<th style="white-space: nowrap">{{ date("Y-m-d H:i", strtotime($event->end_time)) }}</th>
					@if (!$event->exists)
						<th style="white-space: nowrap"><a class="btn btn-primary" href="{{ URL::to_route('event.edit', array($event->facebook_id)) }}">Lägg till</a>
					@else
						<th style="white-space: nowrap"><a class="btn btn-primary" href="{{ URL::to_route('event.edit', array($event->facebook_id)) }}">Redigera</a>
					@endif
				</tr>
			@endforeach
		</tbody>
	</table>
</div>
@endsection
