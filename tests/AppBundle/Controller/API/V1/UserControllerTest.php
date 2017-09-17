<?php

namespace Tests\AppBundle\Controller\API\V1;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $client->request(
		    'DELETE',
		    '/api/v1/server/6?api_token=$2y$10$7263UTiI9ExW1HL05QnOLefmRHJtYXoOjh.LFRqUmZ3pI2Q5O99MS'
		);
        $this->assertEquals($client->getResponse()->getContent(), '{"success":false,"payload":[],"messages":[{"type":"error","message":"Invalid Request."}]}');
    }
}