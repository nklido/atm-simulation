<?php namespace Test;


use Core\Atm;
use Exception;
use PHPUnit\Framework\TestCase;

class AtmTest extends TestCase
{
    /** @test */
    public function it_accepts_note_counts_in_the_initialization_step(){

        $atm = new Atm(15,25);

        $this->assertEquals(15,$atm->getTwenties());
        $this->assertEquals(25,$atm->getFifties());
    }

    /** @test */
    public function it_accepts_non_negative_note_counts_in_the_initialization_step(){

        $this->expectException(Exception::class);
        new Atm(-1,-1);
    }

    /** @test */
    public function it_can_dispense_legal_combination_of_notes(){

        $atm = new Atm(15,25);


        $atm->dispense(100);

        $this->assertEquals(15,$atm->getTwenties());
        $this->assertEquals(23,$atm->getFifties());
    }


    /** @test */
    public function it_cannot_dispense_negative_amounts(){

        $this->expectExceptionMessage('Please provide a positive number!');

        $atm = new Atm(15,25);

        $atm->dispense(-100);

        $this->assertEquals(15,$atm->getTwenties());
        $this->assertEquals(25,$atm->getFifties());
    }

    /** @test */
    public function it_cannot_dispense_more_than_the_total_amount(){

        $this->expectExceptionMessage('Cannot dispense requested amount with available notes!');

        $atm = new Atm(0,2);

        $atm->dispense(120);

        $this->assertEquals(0,$atm->getTwenties());
        $this->assertEquals(2,$atm->getFifties());
    }

    /** @test */
    public function it_cannot_dispense_illegal_combinations(){

        $this->expectExceptionMessage('Cannot dispense requested amount with available notes!');

        $atm = new Atm(2,2);

        $atm->dispense(30);

        $this->assertEquals(2,$atm->getTwenties());
        $this->assertEquals(2,$atm->getFifties());
    }

    /** @test */
    public function it_can_dispense_skip_notes_to_dispense_with_multiples_of_a_lesser_note(){


        $atm = new Atm(3,2);

        $atm->dispense(60);

        $this->assertEquals(0,$atm->getTwenties());
        $this->assertEquals(2,$atm->getFifties());
    }



}
