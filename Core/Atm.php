<?php

namespace Core;

use Exception;

class Atm{

    /** @var int[] Atm support types of notes */
    public const AVAILABLE_NOTES = [50,20];

    /** @var array Count for each type of note */
    private array $notes;

    /**
     * @throws Exception
     */
    public function __construct(array $notes){

        foreach(Atm::AVAILABLE_NOTES as $note){
            if($notes[$note] < 0){
                $this->notes = [];
                throw new Exception('Please provide non negative amounts!');
            }
            $this->notes[$note] = $notes[$note];
        }
    }

    public function getNotes(){
        return $this->notes;
    }


    /**
     * @throws Exception
     */
    public function dispense($amount): void
    {
        if($amount <= 0){
            throw new Exception('Please provide a positive number!');
        }


        $dispensed = [];
        $this->dfs($amount, $this->notes, $dispensed);

        if (empty($dispensed)) {
            throw new Exception('Cannot dispense requested amount with available notes!');
        }

        foreach ($dispensed as $note => $num_notes) {
            $this->notes[$note] -= $num_notes;
        }

    }


    /**
     * @TODO can be optimized with caching or with a bottom-up approach using dp.
     * Brute force solution. Tries all combinations
     * of notes until it finds one that can sum
     * up to $amount.
     * @param $amount
     * @param $notes
     * @param $dispensed
     * @return bool
     */
    protected function dfs($amount,$notes,&$dispensed){
        if($amount === 0){
            return true;
        }else if($amount < 0){
            return false;
        }
        foreach($notes as $note => $count){
            if($count === 0)
                continue;

            $notes[$note] -= 1;
            if($this->dfs($amount - $note, $notes,$dispensed)){
                if(array_key_exists($note,$dispensed)){
                    $dispensed[$note]++;
                }else{
                    $dispensed[$note] = 1;
                }
                return true;
            }
        }
        return false;
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