<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use App\Controller\HomeController;
use PHPUnit\Framework\Attributes\CoversClass;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

#[CoversClass(HomeController::class)]
final class HomeControllerTest extends WebTestCase
{
    public function testCanReturnProperResponse(): void
    {
        $client = static::createClient();
        $client->request(
            method:'GET',
            uri: '/'
        );

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('th', 'Name');
    }

}
