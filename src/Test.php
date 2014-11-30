<?php namespace Gil\ABCode;

class Test {

	protected $control;
	
	protected $candidate;

	protected $experiment;

	protected $controlResultMapper;

	protected $candidateResultMapper;

	protected $context;

	protected $compareMode;

	public function __construct(ExperimentInterface $experiment)
	{
		$this->experiment = $experiment;

		$this->enabled = $experiment->enabled();
	}

	public function setContext($context)
	{
		$this->context = $context;

		return $this;
	}

	public function setControl(Callable $fn, Callable $mapper = null)
	{
		$this->control = $fn;

		$this->controlResultMapper = $mapper;

		return $this;
	}

	public function setCandidate(Callable $fn, Callable $mapper = null)
	{
		$this->candidate = $fn;

		$this->candidateResultMapper = $mapper;
		
		return $this;
	}

	public function runIf(Callable $fn = null)
	{
		if ($fn)
		{
			$this->enabled = $fn();
		}

		return $this;
	}
	
	public function run($compareMode = false)
	{
		if (!$this->candidate or !$this->enabled)
		{
			$control = $this->control;
			
			return $control();
		}
	
		$result = new Result;
		$result->compareMode = $compareMode;
		
		if ($compareMode)
		{
			$result->control = $this->observe($this->control, $this->controlResultMapper);
			$result->candidate = $this->observe($this->candidate, $this->candidateResultMapper);
		}
		else
		{
			if ($this->experiment->runCandidate())
			{
				$result->candidate = $this->observe($this->candidate, $this->candidateResultMapper);
			}
			else
			{
				$result->control = $this->observe($this->control, $this->controlResultMapper);
			}
		}

		$this->experiment->publish($result);

		return $result->get();
	}

	protected function observe($function, $mapper)
	{
		$observation = new Observation;

		$observation->mapper = $mapper;

		$start = microtime(true);
		
		try 
		{
			$observation->result = $function();
		}
		catch (Exception $e)
		{
			$observation->storeException($e);
		}
		
		$observation->duration = microtime(true) - $start;

		return $observation;
	}

}