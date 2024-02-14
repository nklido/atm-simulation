<?php

namespace Core;

class BruteForceDispenser implements CashDispenser
{

    public function dispense($notes,$amount): array|null
    {
        if($amount === 0){
            return [];
        }else if($amount < 0){
            return null;
        }
        foreach($notes as $note => $count){
            if($count === 0)
                continue;

            $notes[$note] -= 1;
            $dispensed = $this->dispense($notes,$amount - $note);
            if(is_array($dispensed)){
                if(array_key_exists($note,$dispensed)){
                    $dispensed[$note]++;
                }else{
                    $dispensed[$note] = 1;
                }
                return $dispensed;
            }
        }
        return null;
    }
}