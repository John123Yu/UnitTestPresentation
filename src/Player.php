<?php
namespace TDD;

use \InvalidArgumentException;
use \LogicException;
class Player {
	public function __construct($name) {
    	$this->name = $name;
        $this->goals = 0;
        $this->assists = 0;
    }

	public function goalCount() {
		return $this->goals;
	} 
	public function assistCount() {
		return $this->assists;
	}
	public function score($latestGoals = 0, $Decimals = 0) {
		if(filter_var($latestGoals, FILTER_VALIDATE_INT) === false){
			throw new InvalidArgumentException('Latest goals must be an integer');
		}
		if($latestGoals < 0) {
			throw new LogicException('Latest goals must be > 0');
		}
		$this->goals = $this->goals + round($latestGoals, $Decimals);
	}
	public function assist($latestAssists = 0, $Decimals = 0){
		if(filter_var($latestAssists, FILTER_VALIDATE_INT) === false){
			throw new InvalidArgumentException('Latest assists must be an integer');
		}
		if($latestAssists < 0) {
			throw new LogicException('Latest assists must be > 0');
		}
		$this->assists = $this->assists + round($latestAssists, $Decimals);
	}
	public function hasScored() {
		return $this->goals > 0;
	}
	public function hasAssisted() {
		return $this->assisted > 0;
	}
	public function getHour() {
		return 9;
	}

}