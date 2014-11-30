<?php namespace Gil\ABCode;

class DefaultExperiment implements ExperimentInterface {

	protected $split = 50;

	public function __construct($name)
	{
		$this->name = $name;
	}

	public function enabled()
	{
		return true;
	}

	public function runCandidate()
	{
		return $this->split > 0 && rand(0, 100) <= $this->split;
	}

	public function publish(Result $result)
	{
		var_dump($result->matched()); die;
	}
	
}