<?php

namespace Core;

class GreedyDispenser implements CashDispenser
{

    public function dispense($notes, $amount): array|null
    {
        $dispensed = [];
        $remainingAmount = $amount;

        $i = 0;

        while($i < sizeof($notes)){

            $note = array_keys($notes)[$i];
            $count = array_values($notes)[$i];

            $notesToDispense = min(intval($remainingAmount / $note), $count);
            if($notesToDispense > 0){
                $dispensed[$note] = $notesToDispense;
                $remainingAmount -= $notesToDispense * $note;
            }


            if($i === sizeof($notes) - 1 && $remainingAmount > 0){
                $lastNote = array_keys($notes)[$i - 1];

                if( isset($dispensed[$lastNote]) && end($dispensed) > 0){
                    $dispensed[$lastNote]--;
                    if($dispensed[$lastNote]){
                        unset($dispensed[$lastNote]);
                    }
                    $remainingAmount += $lastNote;
                    continue;
                }
            }

            if($remainingAmount === 0){
                break;
            }

            $i++;
        }

        if($remainingAmount > 0)
            $dispensed = null;

        return $dispensed;
    }
}