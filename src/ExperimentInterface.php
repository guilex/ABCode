<?php namespace Gil\ABCode;

interface ExperimentInterface {

	public function enabled();

	public function runCandidate();

	public function publish(Result $result);

}