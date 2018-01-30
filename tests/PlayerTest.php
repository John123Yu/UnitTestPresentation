<?php
namespace TDD\Test;
require dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

// This imports the PHPUnit core class TestCase
use PHPUnit\Framework\TestCase;
use TDD\Player;

class PlayerTest extends TestCase {

	#ARRANGE
	// We instantiate new instances in the setUp method
	public function setUp() {
		$this->Player = new Player('Fred');
	}
	// We can unset instances in the tearDown method to ensure PHP doesn't carry anything over from one test run to the next
	public function tearDown() {
		unset($this->Player);
	}

	public function testScore() {
		$input = 3;
		#ACT
		$this->Player->score($input);
		$output = $this->Player->goalCount();
		#ASSERT
		$this->assertEquals(
			3, #expected result
			$output, #actual result
			'The player should have 3 goals' #message
		);
	}
	#ASSERT TRUE
	public function testHasScored() {
		$this->Player->score(1);
		$output = $this->Player->hasScored();
		$this->assertTrue(
			$output,
			'The player should have scored'
		);
	}
	#ASSERT FALSE
	public function testHasNotScored() {
		$output = $this->Player->hasScored();
		$this->assertFalse(
			$output,
			'The player should not have scored'
		);
	}

	#PARAMETERIZED TESTS with simple types
	/**
	  * @dataProvider provideAssists
	  */
	public function testAssist($items, $expected) {
		$this->Player->assist($items);
		$output = $this->Player->assistCount();
		$this->assertEquals(
			$expected,
			$output,
			"The player should have {$expected} assists"
		);
	}
	public function provideAssists() {
		return [
			'1 assist' => [1, 1], #[$items, $expected]
			'5 assists' => [5, 5],
			'10 assists' => [10, 10],
			'20 assists' => [20, 20],
			// '30 assists' => [29, 30] THIS TEST WILL FAIL
		];
	}

	#PARAMETERIZED TESTS with complex types
	/**
	  * @dataProvider provideAssistsAndGoals
	  */
	public function testAssistAndGoals($items, $expected) {
		$this->Player->assist($items['assists']);
		$this->Player->score($items['goals']);
		$output = $this->Player->goalCount();
		$this->assertEquals(
			$expected,
			$output,
			"The player should have {$expected} goals"
		);
	}
	public function provideAssistsAndGoals() {
		return [
			'1 assist and goal' => [array('assists'=>1, 'goals'=>1), 1],
			'5 assists and goals' => [array('assists'=>5, 'goals'=>5), 5],
			'10 assists and goals' => [array('assists'=>10, 'goals'=>10), 10],
			'20 assists and goals' => [array('assists'=>20, 'goals'=>20), 20],
		];
	}

	#ROUNDING DEMONSTRATED WITH PARAMETERIZED TESTS
	/**
	  * @dataProvider provideGoals
	  */
	public function testScores($items, $expected) {
		$this->Player->score($items[0], $items[1]);
		$output = $this->Player->goalCount();
		$this->assertEquals(
			$expected,
			$output,
			"The player should have {$expected} goals"
		);
	}
	public function provideGoals() {
		return [
			'1 assist with 0 decimals' => [[1.216, 0], 1],
			'1 assist with 1 decimal' => [[1.216, 1], 1],
		];
	}

	#EXCEPTIONS
	/**
     * @expectedException InvalidArgumentException
     */
	public function testScoreException() {
		$input = -1;
		// $this->expectException('InvalidArgumentException');
		$this->Player->score($input);
	}

	#DEEP COMAPRE 
	#assertEquals allows deep compare.
	public function testPlayerCompareDeep() {
		$output = new Player('Fred');
		$this->assertEquals(
			$this->Player,
			$output,
			"assertEquals() should deep compare and equate the two player objects"
		);
	}
	#assertSame requires that two variables reference the same object.
	public function testPlayerCompare() {
		$output = new Player('Fred');
		$this->assertSame(
			$this->Player,
			$output,
			"assertSame() requires that two variables reference the same object"
		);
	}

	#DEEP COMPARE OF ARRAY
	public function testPlayerListCompare() {
		$playerListOne = array(
			new Player('John'),
			new Player('Sam'),
			new Player('Burt')
		);
		$playerListTwo = array(
			new Player('John'),
			new Player('Sam'),
			new Player('Burt')
		);
		$this->assertEquals(
			$playerListOne,
			$playerListTwo,
			"assertEquals() should deep compare and equate the two player lists"
		);
	}

	#BAD USE OF DATETIME
	public function testDateTimeBad() {
		$time =  (new \DateTime())->format('Y-m-d H:i:s');
		$hour = (new \DateTime())->format('H');
		if (($hour > '0') And ($hour < '6')) {
			$output = "Night";
		}
		if (($hour >= '6') And ($hour < '12')) {
			$output = "Morning";
		}
		if (($hour >= '12') And ($hour < '18')) {
			$output = "Evening";
		}
		#ASSERTSTATEMENT
	}
	#Better code to unit test time
	public function testDateTimeGood() {
		$hour = getHour();
		if (($hour > '0') And ($hour < '6')) {
			$output = "Night";
		}
		if (($hour >= '6') And ($hour < '12')) {
			$output = "Morning";
		}
		if (($hour >= '12') And ($hour < '18')) {
			$output = "Evening";
		}
		#ASSERTSTATEMENT
	}


	#RECORD EXCEPTIONS
	// /**
 //     * @expectedException        InvalidArgumentException
 //     * @expectedExceptionMessage Latest assists must be greater than 0
 //    */
	// public function testAssistException() {
	// 	$input = -1;
	// 	// $this->expectException('InvalidArgumentException');
	// 	$this->Player->assist($input);
	// 	throw new InvalidArgumentException('Latest assists must be greater than 0', 20);
	// }



}