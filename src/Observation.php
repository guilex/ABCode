<?php namespace Gil\ABCode;

class Observation {

    /**
     * Duration of code execution
     *
     * @var
     */
    public $duration;

    /**
     * Result
     *
     * @var
     */
    public $result;

    /**
     * Result mapper
     *
     * @var
     */
    public $mapper;

    /**
     * Is exception raised
     *
     * @var bool
     */
    public $raisedException = false;

    /**
     * Exception data
     *
     * @var
     */
    public $exception;

    /**
     * Returns mapped results
     *
     * @return mixed
     */
    public function mappedResult()
    {
        $mapper = $this->mapper;

        return $mapper ? $mapper($this->result) : $this->result;
    }

    /**
     * Stores exception data
     *
     * @param $exception
     */
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