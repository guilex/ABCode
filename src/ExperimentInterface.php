<?php namespace Gil\ABCode;

interface ExperimentInterface {

    /**
     * Is test enabled. If not "run" will just return control without any additional data
     *
     * @return mixed
     */
    public function enabled();

    /**
     * Decide if candidate should be ran. This is used only in non-compare mode
     *
     * @return mixed
     */
    public function shouldCandidateRun();

    /**
     * Method called after observations are performed. Publishes test findings
     *
     * @param Result $result
     * @return mixed
     */
    public function publish(Result $result);

}