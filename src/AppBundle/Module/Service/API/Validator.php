<?php

namespace AppBundle\Module\Service\API;

use AppBundle\Module\Contract\API\Validator as ValidatorContract;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * API Validator Service
 *
 * @package AppBundle\Module\Service\API
 */
class Validator implements ValidatorContract
{

    /**
     * @var array
     */
    protected $inputs = [];

    /**
     * @var ValidatorInterface
     */
    protected $validator;

    /**
     * @var array
     */
    protected $messages = [];

    /**
     * Class Constructor
     *
     * @param ValidatorInterface $validator
     */
    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * Set Inputs and Validation Rules
     *
     * @param array $inputs
     * @return void
     */
    public function setInputs($inputs)
    {
        $this->inputs = $inputs;
    }

    /**
     * Validate Inputs
     *
     * @return boolean
     */
    public function validate()
    {
        foreach ($this->inputs as $input_name => $input) {
            $input['rule'] = "\Symfony\Component\Validator\Constraints\\" . $input['rule'];
            if( (isset($input['parameters'])) && !empty($input['parameters']) ){
                $rule =  new $input['rule']($input['parameters']);
            }else{
                $rule =  new $input['rule']();
            }

            if( (isset($input['constraint'])) && !empty($input['constraint']) ){
                foreach ($input['constraint'] as $constraint_key => $constraint_value) {
                    $rule->{$constraint_key} = $constraint_value;
                }
            }

            $errors = $this->validator->validate(
                $input['value'],
                $rule
            );

            if( count($errors) ){
                $this->messages[] = [
                    'type' => 'error',
                    'message' => $errors[0]->getMessage()
                ];
            }
        }

        return (boolean) empty($this->messages);
    }

    /**
     * Get Error Messages
     *
     * @return array
     */
    public function getMessages()
    {
        return $this->messages;
    }
}