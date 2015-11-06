BEGIN:VCALENDAR
PRODID:-//Officine Digitali//Pendola//IT
VERSION:2.0
CALSCALE:GREGORIAN
METHOD:PUBLISH
BEGIN:VTIMEZONE
TZID:Europe/Rome
BEGIN:DAYLIGHT
TZOFFSETFROM:+0100
TZOFFSETTO:+0200
TZNAME:CEST
DTSTART:19700329T020000
RRULE:FREQ=YEARLY;BYMONTH=3;BYDAY=-1SU
END:DAYLIGHT
BEGIN:STANDARD
TZOFFSETFROM:+0200
TZOFFSETTO:+0100
TZNAME:CET
DTSTART:19701025T030000
RRULE:FREQ=YEARLY;BYMONTH=10;BYDAY=-1SU
END:STANDARD
END:VTIMEZONE
@foreach($alarms as $a)
BEGIN:VEVENT
DTSTART:{{ $a->exportableDate('date1') }}
@if($a->date2 != null)
DTEND:{{ $a->exportableDate('date2') }}
@else
DTEND:{{ $a->exportableDate('date1') }}
@endif
DTSTAMP:{{ strftime('%Y%m%dT%H%M%SZ', time()) }}
UID:{{ $a->id }}@pendola
CREATED:{{ $a->exportableDate('created_at') }}
DESCRIPTION:
LAST-MODIFIED:{{ $a->exportableDate('updated_at') }}
LOCATION:
SEQUENCE:0
STATUS:CONFIRMED
SUMMARY:{{ $a->entity->name }} | {{ $a->type->name }}
END:VEVENT
@endforeach
@foreach($reminders as $r)
BEGIN:VEVENT
DTSTART:{{ $r->exportableDate('expiry') }}
DTEND:{{ $r->exportableDate('expiry') }}
DTSTAMP:{{ strftime('%Y%m%dT%H%M%SZ', time()) }}
UID:remind-{{ $r->id }}@pendola
CREATED:{{ $r->exportableDate('created_at') }}
DESCRIPTION:
LAST-MODIFIED:{{ $r->exportableDate('updated_at') }}
LOCATION:
SEQUENCE:0
STATUS:CONFIRMED
SUMMARY:Ricorda: {{ $r->alarm->simpleName() }}
END:VEVENT
@endforeach
END:VCALENDAR
