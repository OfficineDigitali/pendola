<p>
        Prossima scadenza: {{ $alarm->printableFullDate() }}
</p>
<p>
        {{ $alarm->simpleName() }}
</p>

<p>
        {!! nl2br($mailmessage) !!}
</p>

<p>
        Per maggiori informazioni, contattare {{ $alarm->owner->email }}.
</p>
