<?php

namespace Tests\AppBundle\Module\Service\API;

use PHPUnit\Framework\TestCase;
use AppBundle\Module\Service\API\Response as ResponseService;

/**
 * Response Service Test
 *
 * @package Tests\AppBundle\Module\Service\API
 */
class ResponseTest extends TestCase
{

    /**
     * @var ResponseService
     */
    protected $response;

    /**
     * Class Constructor
     */
    public function __construct()
    {
        $this->response = new ResponseService();
    }

    /**
     * Test Response Builder
     *
     * @return void
     */
    public function testResponseBuilder()
    {
        $this->response->setStatus(true);
        $this->response->setPayload(['id' => 3, 'name' => 'Test'], true);
        $this->response->setMessage(['type' => 'error', 'message' => 'Test']);
        $this->assertTrue($this->response->getStatus());
        $this->assertEquals($this->response->getPayload(), ['id' => 3, 'name' => 'Test']);
        $this->assertEquals($this->response->getMessages(), [['type' => 'error', 'message' => 'Test']]);
        $this->assertEquals($this->response->getResponse(), ["success" => true, "payload" => ['id' => 3, 'name' => 'Test'],"messages" => [['type' => 'error', 'message' => 'Test']]]);
    }
}