<?php namespace Gil\ABCode;

use Exception;

class Test {

    /**
     * @Observation
     */
    protected $control;

    /**
     * @Observation
     */
    protected $candidate;

    /**
     * @var ExperimentInterface
     */
    protected $experiment;

    /**
     * @Callable
     */
    protected $controlResultMapper;

    /**
     * @Callable
     */
    protected $candidateResultMapper;

    /**
     * @var
     */
    protected $context;

    /**
     * @param ExperimentInterface $experiment
     */
    public function __construct(ExperimentInterface $experiment)
    {
        $this->experiment = $experiment;

        $this->enabled = $experiment->enabled();
    }

    /**
     * Set contest of the observation
     *
     * @param $context
     * @return $this
     */
    public function setContext($context)
    {
        $this->context = $context;

        return $this;
    }

    /**
     * Set control subject
     *
     * @param callable $fn
     * @param callable $mapper
     * @return $this
     */
    public function setControl(Callable $fn, Callable $mapper = null)
    {
        $this->control = $fn;

        $this->controlResultMapper = $mapper;

        return $this;
    }

    /**
     * Set candidate
     *
     * @param callable $fn
     * @param callable $mapper
     * @return $this
     */
    public function setCandidate(Callable $fn, Callable $mapper = null)
    {
        $this->candidate = $fn;

        $this->candidateResultMapper = $mapper;

        return $this;
    }

    /**
     * Override enabled
     *
     * @param callable $fn
     * @return $this
     */
    public function runIf(Callable $fn = null)
    {
        if ($fn)
        {
            $this->enabled = $fn();
        }

        return $this;
    }

    /**
     * Run experiment
     *
     * @param bool $compareMode
     * @return mixed
     */
    public function run($compareMode = false)
    {
        // if there is no candidate or test is disabled, simply return control result right away
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
            if ($this->experiment->shouldCandidateRun())
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

    /**
     * Observe execution
     *
     * @param $function
     * @param $mapper
     * @return Observation
     */
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