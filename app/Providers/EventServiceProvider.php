<?php

namespace App\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

use App\AttributeType;
use App\Attribute;
use App\EntityType;
use App\Entity;
use App\Alarm;

class EventServiceProvider extends ServiceProvider
{
	/**
	* The event listener mappings for the application.
	*
	* @var array
	*/
	protected $listen = [
		'App\Events\SomeEvent' => [
			'App\Listeners\EventListener',
		],
	];

	/**
	* Register any other events for your application.
	*
	* @param  \Illuminate\Contracts\Events\Dispatcher  $events
	* @return void
	*/
	public function boot(DispatcherContract $events)
	{
		parent::boot($events);

		AttributeType::deleting(function($attr) {
			$sub_attrs = Attribute::where('type_id', '=', $attr->id)->get();
			foreach($sub_attrs as $sa)
				$sa->delete();
		});

		EntityType::deleting(function($entity) {
			$entities = $entity->entities;
			foreach($entities as $e)
				$e->delete();
		});

		Entity::deleting(function($entity) {
			$alarms = $entity->alarms;
			foreach($alarms as $a)
				$a->delete();
		});

		Alarm::deleting(function($alarm) {
			$reminders = $alarm->history;
			foreach($reminders as $r)
				$r->delete();
		});
	}
}
