## ATM Simulation

Implements the backend logic of a simplified Automatic Teller Machine (ATM)

## Requirements
- Supports 20$ & 50$ notes
- Accepts count of notes only at the initialization step
- Keeps count for each type of note and is able to report back
- Dispenses only legal combinations of notes
  - Reports an error otherwise
- Dispensing money reduces the available cash
  - On error the available cash remains unchanged

## Installation

To install the project you need to have `php 8.2` and [composer](https://getcomposer.org/download/) installed.

To install dependencies and autoload files run
```cmd
composer install
```
Then you can run the app with

```cmd
php index.php
```

## Testing
Tests are written with `PHPunit` which was installed in the `composer install` step.

You can execute the tests by running

```cmd
./vendor/bin/phpunit
```


