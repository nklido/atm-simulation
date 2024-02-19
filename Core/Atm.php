<?php

namespace Core;

use Exception;

class Atm{

    /** @var int[] Atm support types of notes */
    public const AVAILABLE_NOTES = [100,50,20];

    /** @var array Count for each type of note */
    private array $notes;


    /**
     * @throws Exception
     */
    public function __construct(array $notes, private readonly CashDispenser $dispenser){

        foreach(Atm::AVAILABLE_NOTES as $note){
            if($notes[$note] < 0){
                $this->notes = [];
                throw new Exception('Please provide non negative amounts!');
            }
            $this->notes[$note] = $notes[$note] ?? 0;
        }
    }

    public function getNotes(): array
    {
        return $this->notes;
    }


    /**
     * @throws Exception
     */
    public function dispense($amount): array
    {
        if($amount <= 0){
            throw new Exception('Please provide a positive number!');
        }

        $dispensed = $this->dispenser->dispense($this->notes,$amount);
        if (empty($dispensed)) {
            throw new Exception('Cannot dispense requested amount with available notes!');
        }

        foreach ($dispensed as $note => $num_notes) {
            $this->notes[$note] -= $num_notes;
        }

        return $dispensed;
    }

    public function total(): int{
        return array_sum(
            array_map(fn($note,$count) => $note * $count,
                array_keys($this->notes),
                array_values($this->notes)
            )
        );
    }



}
