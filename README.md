# risPArmio
Web application che rendere visibile l'attività quotidiana svolta dal personale del CED per fornire servizi informatici in modo da incidere il meno possibile sul bilancio dell'Ente.

Questa applicazione Web è scritta in php e sfrutta le funzionalità di Propel ORM
Necessita di php >= 5.4.* e mysql >= 5.1.*

# Installazione

Questa applicazione necessita di composer (https://getcomposer.org)

Si prega di installarlo:
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer

Per prima cosa occorre importare nel proprio db mysql la struttura dati

mysqladmin create risPArmio
mysql risPArmio < ./sql/risPArmio.sql

occorre poi creare un virtualHost e uno spazio sul webserver e copiarci tutti i file del progetto.

Le directory in cui copiare il tutto sono specificate nel file propel.yml

L'applicazione prevede che il db sia sullo stesso server della parte applicativa e che si abbia accesso come root senza password

Per modificare queste impostazioni occorre modificare i seguenti file:

propel.yml

In seguito occorre lanciare i seguenti comandi per aggiornare l'applicazione in modo corretto

cd <directory radice dell'applicazione conforme a propel.yml>
composer update
mkdir -p propel/class
rm -rf propel/* ; vendor/bin/propel ; export PATH=$PATH:vendor/bin/ ; propel reverse --output-dir="./propel" ; propel model:build ; composer dump-autoload ; propel config:convert


# Credits
Applicazione realizzata dal CED della Provincia di Prato - Ufficio Sistemi Informativi Per informazioni o suggerimenti inviare una mail al seguente indirizzo webmaster@provincia.prato.it

I grafici sono a cura di www.amcharts.com