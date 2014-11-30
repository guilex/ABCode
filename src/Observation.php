<?php namespace Gil\ABCode;

class Observation {

	public $duration;

	public $result;

	public $mapper;

	public $raisedException;

	public $exception;

	public function mappedResult()
	{
		$mapper = $this->mapper;

		return $mapper ? $mapper($this->result) : $this->result;
	}

	public function storeException($exception)
	{
		$this->raisedException = true;

		$this->exception = [
			'class' => get_class($exception),
			'message' => $exception->getMessage(),
			'backtrace' => $exception->getTraceAsString()
		];
	}
}