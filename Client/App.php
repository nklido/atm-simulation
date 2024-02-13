<?php

namespace Client;

use Core\Atm;

class App
{

    /**
     * @throws \Exception
     */
    public function run(): void
    {
        println("Initializing...");

        $notes = [];
        foreach (ATM::AVAILABLE_NOTES as $note) {
            $notes[$note] = (int) readline("Please enter count for {$note} notes: ");
        }

        $atm = new Atm($notes);

        while(true){
            $this->printMenu();
            $choice = readline("Enter your choice: ");

            switch ($choice){
                case '1':
                    $amount = (int) readline('Enter amount: ');
                    try {
                        $dispensed = $atm->dispense($amount);
                        $this->printDispensingResult($dispensed);
                        pressAnyKeyToContinue();
                    }catch (\Exception $e){
                        println($e->getMessage());
                        pressAnyKeyToContinue();
                    }
                    break;
                case '2':
                    $this->printReport($atm);
                    pressAnyKeyToContinue();
                    break;
                case '3':
                    exit('bye..');
                default:
                    println('Invalid input. Please try again!');
            }
        }

    }


    protected function printMenu(): void
    {
        println("Choose an option...");
        println("1. Dispense cash");
        println("2. Report notes");
        println("3. Exit");
    }

    protected function printDispensingResult($notes): void
    {
        $result = 'Dispensing: ';

        $result.= implode(' + ',array_map(function($note,$count){
            return "{$note}x{$count}";
        },array_keys($notes),array_values($notes)));

        println($result);
    }

    protected function printReport(Atm $atm): void
    {
        $result = 'Current notes in ATM: ';

        foreach($atm->getNotes() as $note => $count){
            $result.= "{$note}: {$count}, ";
        }
        $result.="Total Cash: {$atm->total()}";
        println($result);
    }

}