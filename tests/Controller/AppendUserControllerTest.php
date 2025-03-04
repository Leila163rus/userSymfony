<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class AppendUserControllerTest extends WebTestCase
{
    public function testIndex(): void
    {
        $client = static::createClient();
        $client->request('GET', '/append');

        $this->assertResponseStatusCodeSame(200, $client->getResponse()->getStatusCode());
        
        self::assertResponseIsSuccessful();
    }
}
