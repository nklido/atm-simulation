<?php namespace Test;


use Core\Atm;
use Core\BruteForceDispenser;
use Core\CashDispenser;
use Core\GreedyDispenser;
use Exception;
use PHPUnit\Framework\TestCase;
use PHPUnit\Metadata\DataProvider;

class AtmTest extends TestCase
{
    /**
     * @dataProvider dispenserAlgorithm
     * @test
     */
    public function it_accepts_note_counts_in_the_initialization_step(CashDispenser $dispenser){

        $atm = new Atm([
            20 => 15,
            50 => 25
        ], $dispenser);

        $this->assertEquals(15,$atm->getNotes()[20]);
        $this->assertEquals(25,$atm->getNotes()[50]);
    }

    /**
     * @dataProvider dispenserAlgorithm
     * @test
     */
    public function it_accepts_non_negative_note_counts_in_the_initialization_step(CashDispenser $dispenser){

        $this->expectException(Exception::class);
        new Atm([
            20 => -1,
            50 => -1
        ], $dispenser);
    }

    /**
     * @dataProvider resultDataProvider
     * @test
     */
    public function it_can_dispense_legal_combinations_of_notes(CashDispenser $dispenser,array $notes, int $dispense, array $remaining, int $total){

        $atm = new Atm($notes, $dispenser);

        $atm->dispense($dispense);

        foreach($remaining as $note => $value){
            $this->assertEquals($value,$atm->getNotes()[$note]);
        }
        $this->assertEquals($total,$atm->total());
    }


    /**
     * @dataProvider dispenserAlgorithm
     * @test
     */
    public function it_cannot_dispense_negative_amounts(CashDispenser $dispenser){

        $this->expectExceptionMessage('Please provide a positive number!');

        $atm = new Atm([
            20 => 5,
            50 => 5
        ], $dispenser);

        $atm->dispense(-100);

        $this->assertEquals(15,$atm->getNotes()[20]);
        $this->assertEquals(25,$atm->getNotes()[50]);
        $this->assertEquals(600,$atm->total());
    }

    /**
     * @dataProvider dispenserAlgorithm
     * @test
     */
    public function it_cannot_dispense_more_than_the_total_amount(CashDispenser $dispenser){

        $this->expectExceptionMessage('Cannot dispense requested amount with available notes!');

        $atm = new Atm([
            20 => 0,
            50 => 2
        ], $dispenser);

        $atm->dispense(120);

        $this->assertEquals(0,$atm->getNotes()[20]);
        $this->assertEquals(2,$atm->getNotes()[50]);
        $this->assertEquals(100,$atm->total());
    }

    /**
     * @dataProvider dispenserAlgorithm
     * @test
     */
    public function it_cannot_dispense_illegal_combinations(CashDispenser $dispenser){

        $this->expectExceptionMessage('Cannot dispense requested amount with available notes!');

        $atm = new Atm([
            20 => 2,
            50 => 2
        ], $dispenser);

        $atm->dispense(30);

        $this->assertEquals(2,$atm->getNotes()[20]);
        $this->assertEquals(2,$atm->getNotes()[50]);
        $this->assertEquals(140,$atm->total());
    }

    /**
     * @dataProvider dispenserAlgorithm
     * @test
     */
    public function test_dispense_legal_combination_without_higher_denomination_first(CashDispenser $dispenser){


        $atm = new Atm([
            20 => 3,
            50 => 2
        ], $dispenser);

        $atm->dispense(60);

        $this->assertEquals(0,$atm->getNotes()[20]);
        $this->assertEquals(2,$atm->getNotes()[50]);
        $this->assertEquals(100,$atm->total());
    }

    public static function dispenserAlgorithm(): array
    {
        return [
            [new BruteForceDispenser()],
            [new GreedyDispenser()]
        ];
    }

    public static function resultDataProvider(): array
    {

        $testCases = [
          [[50 => 3, 20 => 3], 60, [50 => 3, 20 => 0], 150],
          [[50 => 1, 20 => 3], 70, [50 => 0, 20 => 2], 40],
          [[50 => 1, 20 => 3], 110, [50 => 0, 20 => 0], 0],
          [[50 => 5, 20 => 3], 220, [50 => 1, 20 => 2], 90],
          [[50 => 2, 20 => 4], 100, [50 => 0, 20 => 4], 80],
          [[100 => 3,50 => 2, 20 => 4], 150, [100 => 2, 50 => 1, 20 => 4], 330],
          [[100 => 0,50 => 2, 20 => 5], 150, [100 => 0, 50 => 1, 20 => 0], 50],
          [[100 => 1,50 => 1, 20 => 5], 210, [100 => 0, 50 => 1, 20 => 0], 50],
        ];

        $combindation = [];

        foreach(self::dispenserAlgorithm() as $algorithm){
            foreach($testCases as $testCase){
                $combindation[] = [$algorithm[0],...$testCase];
            }
        }

        return $combindation;
    }
}
