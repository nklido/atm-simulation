<?php namespace Test;


use Core\Atm;
use Exception;
use PHPUnit\Framework\TestCase;

class AtmTest extends TestCase
{
    /** @test */
    public function it_accepts_note_counts_in_the_initialization_step(){

        $atm = new Atm([
            20 => 15,
            50 => 25
        ]);

        $this->assertEquals(15,$atm->getNotes()[20]);
        $this->assertEquals(25,$atm->getNotes()[50]);
    }

    /** @test */
    public function it_accepts_non_negative_note_counts_in_the_initialization_step(){

        $this->expectException(Exception::class);
        new Atm([
            20 => -1,
            50 => -1
        ]);
    }

    /** @test */
    public function it_can_dispense_legal_combination_of_notes(){

        $atm = new Atm([
            20 => 4,
            50 => 2
        ]);

        $atm->dispense(100);

        $this->assertEquals(4,$atm->getNotes()[20]);
        $this->assertEquals(0,$atm->getNotes()[50]);
        $this->assertEquals(80,$atm->total());
    }


    /** @test */
    public function it_cannot_dispense_negative_amounts(){

        $this->expectExceptionMessage('Please provide a positive number!');

        $atm = new Atm([
            20 => 5,
            50 => 5
        ]);

        $atm->dispense(-100);

        $this->assertEquals(15,$atm->getNotes()[20]);
        $this->assertEquals(25,$atm->getNotes()[50]);
        $this->assertEquals(600,$atm->total());
    }

    /** @test */
    public function it_cannot_dispense_more_than_the_total_amount(){

        $this->expectExceptionMessage('Cannot dispense requested amount with available notes!');

        $atm = new Atm([
            20 => 0,
            50 => 2
        ]);

        $atm->dispense(120);

        $this->assertEquals(0,$atm->getNotes()[20]);
        $this->assertEquals(2,$atm->getNotes()[50]);
        $this->assertEquals(100,$atm->total());
    }

    /** @test */
    public function it_cannot_dispense_illegal_combinations(){

        $this->expectExceptionMessage('Cannot dispense requested amount with available notes!');

        $atm = new Atm([
            20 => 2,
            50 => 2
        ]);

        $atm->dispense(30);

        $this->assertEquals(2,$atm->getNotes()[20]);
        $this->assertEquals(2,$atm->getNotes()[50]);
        $this->assertEquals(140,$atm->total());
    }

    /** @test */
    public function it_can_dispense_skip_notes_to_dispense_with_multiples_of_a_lesser_note(){


        $atm = new Atm([
            20 => 3,
            50 => 2
        ]);

        $atm->dispense(60);

        $this->assertEquals(0,$atm->getNotes()[20]);
        $this->assertEquals(2,$atm->getNotes()[50]);
        $this->assertEquals(100,$atm->total());
    }



}
