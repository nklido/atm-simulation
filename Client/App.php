<?php

namespace Client;

use Core\Atm;

class App
{

    public function run(): void
    {
        println("Initializing...");

        $notes = [];
        foreach (ATM::AVAILABLE_NOTES as $note) {
            $notes[$note] = (int) readline("Please enter count for {$note} notes: ");
        }

        println('Ready');

        $atm = new Atm($notes[20],$notes[50]);

        while(true){
            $this->printMenu();
            $choice = readline("Enter your choice:");

            switch ($choice){
                case '1':
                    $amount = (int) readline('Enter amount: ');
                    try {
                        $atm->dispense($amount);
                        $this->printReport($atm);
                    }catch (\Exception $e){
                        println($e->getMessage());
                    }
                    break;
                case '2':
                    $this->printReport($atm);
                    break;
                case '3':
                    exit('bye..');
                    break;
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