<?php

namespace AppBundle\Module\Contract\API;

/**
 * API Validator Interface
 *
 * @package AppBundle\Module\Contract\API
 */
interface Validator
{
    /**
     * Set Inputs and Validation Rules
     *
     * @param array $inputs
     * @return void
     */
    public function setInputs($inputs);

    /**
     * Validate Inputs
     *
     * @return boolean
     */
    public function validate();

    /**
     * Get Error Messages
     *
     * @return array
     */
    public function getMessages();
}