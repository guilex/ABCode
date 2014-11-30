<?php namespace Gil\ABCode;

class Result {

    /**
     * Is compare mode activated. In this mode both code paths will be execute so results can be compared
     *
     * @var bool
     */
    public $compareMode = false;

    /**
     * Control subject
     *
     * @var
     */
    public $control;

    /**
     * Candidate subject
     *
     * @var
     */
    public $candidate;

    /**
     * Get result. Always try to return control results first.
     *
     * @return mixed
     */
    public function get()
    {
        if ($this->control)
        {
            return $this->control->result;
        }

        return $this->candidate->result;
    }

    /**
     * Do results of control and candidate match
     *
     * @return bool|null
     */
    public function matched()
    {
        return $this->compareMode ? $this->control->mappedResult() == $this->candidate->mappedResult() : null;
    }
}