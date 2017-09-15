<?php

namespace AppBundle\Module\Contract\API;

/**
 * API Response Interface
 *
 * @package AppBundle\Module\Contract\API
 */
interface Response
{
    /**
     * Set Status
     *
     * @param boolean $status
     * @return void
     */
    public function setStatus($status);

    /**
     * Set Payload
     *
     * @param array  $data
     * @param boolean $as_array
     * @return void
     */
    public function setPayload($data, $as_array = false);

    /**
     * Set Message
     *
     * @param array $message
     * @return void
     */
    public function setMessage($message);

    /**
     * Set Messages
     *
     * @param array $messages
     * @return void
     */
    public function setMessages($messages);

    /**
     * Get Status
     *
     * @return boolean
     */
    public function getStatus();

    /**
     * Get Payload
     *
     * @return array
     */
    public function getPayload();

    /**
     * Get Messages
     *
     * @return array
     */
    public function getMessages();

    /**
     * Get Complete Response
     *
     * @return array
     */
    public function getResponse();
}