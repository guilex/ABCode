<?php namespace Gil\ABCode;

class Result {

	public $compareMode = false;

	public $control;

	public $candidate;

	protected $matched;

	public function get()
	{
		if ($this->control)
		{
			return $this->control->result;
		}

		return $this->candidate->result;
	}

	public function matched()
	{
		return $this->compareMode ? $this->control->mappedResult() == $this->candidate->mappedResult() : null;
	}
}