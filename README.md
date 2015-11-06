## Tiret

**Pendola** è una applicazione per gestire e tenere d'occhio le scadenze.

# Features

* amministrazione dei soggetti (personale, veicoli, locali...) ed attributi arbitrari
* tipi di scadenze personalizzabili a seconda del soggetto attribuito
* possibilità di creare reminders per le scadenze
* reiterazione automatica delle scadenze su intervalli settimanali, mensili, annuali e personalizzabili
* esportazione in formato ICS

# Requisiti

* PHP >= 5.5.9
* composer ( https://getcomposer.org/ )
* un webserver ed un database

# Installazione

```
git clone https://github.com/OfficineDigitali/pendola
cd pendola
composer install
cp .env.example .env
(editare .env con i propri parametri di accesso al database e all'SMTP)
php artisan migrate
php artisan db:seed
php artisan key:generate
```

Le credenziali di default sono username: _admin@pendola.it_ / password: _cippalippa_

# Storia

**Pendola** è stato inizialmente sviluppato per una piccola azienda con speciali
adepienze amministrative per il personale, i mezzi in dotazione ed i diversi
locali. Il tutto era gestito manualmente per mezzo di dozzine di fogli Excel
sparpagliati sul disco rigido di un amministratore.

Il nome _pendola_ fa riferimento all'orologio a pendolo.

# Licenza

**Pendola** è distribuito in licenza AGPLv3.

Copyright (C) 2015 Officine Digitali <info@officinedigitali.org>.
