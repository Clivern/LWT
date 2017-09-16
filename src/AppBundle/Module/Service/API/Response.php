<?php

namespace AppBundle\Module\Service\API;

use AppBundle\Module\Contract\API\Response as ResponseContract;

/**
 * API Response Service
 *
 * @package AppBundle\Module\Service\API
 */
class Response implements ResponseContract
{

    /**
     * @var array
     */
    protected $response = [
        "success" => false,
        "payload" => [],
        "messages" => []
    ];

    /**
     * Set Status
     *
     * @param boolean $status
     * @return void
     */
    public function setStatus($status)
    {
        $this->response['success'] = (boolean) $status;
    }

    /**
     * Set Payload
     *
     * @param array  $data
     * @param boolean $asArray
     * @return void
     */
    public function setPayload($data, $asArray = false)
    {
        if( $asArray ){
            $this->response['payload'][] = $data;
        }else{
            foreach ($data as $key => $value) {
                $this->response['payload'][$key] = $value;
            }
        }
    }

    /**
     * Set Message
     *
     * @param array $message
     * @return void
     */
    public function setMessage($message)
    {
        $this->response['messages'][] = $message;
    }

    /**
     * Set Validation Message
     *
     * @param array $messages
     * @return void
     */
    public function setMessages($messages)
    {
        foreach ($messages as $message) {
            $this->setMessage($message);
        }
    }

    /**
     * Get Status
     *
     * @return boolean
     */
    public function getStatus()
    {
        return (boolean) $this->response['success'];
    }

    /**
     * Get Payload
     *
     * @return array
     */
    public function getPayload()
    {
        return $this->response['payload'];
    }

    /**
     * Get Messages
     *
     * @return array
     */
    public function getMessages()
    {
        return $this->response['messages'];
    }

    /**
     * Get Complete Response
     *
     * @return array
     */
    public function getResponse()
    {
        return $this->response;
    }
}