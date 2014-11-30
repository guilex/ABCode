<?php namespace Gil\ABCode;

class DefaultExperiment implements ExperimentInterface {

    protected $split = 50;

    protected $name;

    /**
     * @param $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * Is test enabled. If not "run" will just return control without any additional data
     *
     * @return mixed
     */
    public function enabled()
    {
        return true;
    }

    /**
     * Decide if candidate should be ran. This is used only in non-compare mode
     *
     * @return mixed
     */
    public function shouldCandidateRun()
    {
        return $this->split > 0 && rand(0, 100) <= $this->split;
    }

    /**
     * Method called after observations are performed. Publishes test findings
     *
     * @param Result $result
     * @return mixed
     */
    public function publish(Result $result)
    {

    }

}