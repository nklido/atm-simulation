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

To install dependencies and autoload Classes run
```cmd
composer install
```
Then you can run the app with

```cmd
php index.php
```

## Example
```cmd
php .\index.php
Initializing...
Please enter count for 50 notes: 20                                                                                                                                                                                                      
Please enter count for 20 notes: 20                                                                                                                                                                                                      
Choose an option...
1. Dispense cash
2. Report notes
3. Exit
Enter your choice: 1                                                                                                                                                                                                                     
Enter amount: 170                                                                                                                                                                                                                        
Dispensing: 20x1 + 50x3
Press Enter to continue...

Choose an option...
1. Dispense cash
2. Report notes
3. Exit
Enter your choice: 2                                                                                                                                                                                                                     
Current notes in ATM: 50: 17, 20: 19, Total Cash: 1230

```

## Testing
Tests are written with `PHPunit` which was installed in the `composer install` step.

You can execute the tests by running

```cmd
./vendor/bin/phpunit
```

```cmd
PHPUnit 10.5.10 by Sebastian Bergmann and contributors.

Runtime:       PHP 8.2.12
Configuration: \atm-simulation\phpunit.xml

........                                                            8 / 8 (100%)

Time: 00:00.017, Memory: 8.00 MB

OK (8 tests, 13 assertions)

```


