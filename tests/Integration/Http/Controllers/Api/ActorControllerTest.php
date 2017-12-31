<?php declare(strict_types=1);

namespace Sakila\Test\Http\Controllers\Api;

use Illuminate\Http\Response;
use Sakila\Domain\Actor\Repository\ActorRepositoryInterface;
use Sakila\Exceptions\Database\NotFoundException;
use Sakila\Http\Controllers\Api\ActorController;
use Sakila\Test\BaseIntegrationTestCase;

class ActorControllerTest extends BaseIntegrationTestCase
{
    private const ACTOR_ID = 1;

    /**
     * @var \Sakila\Http\Controllers\Api\ActorController
     */
    private $cut;

    public function setUp()
    {
        parent::setUp();

        $this->add('actor', 1, ['actor_id' => self::ACTOR_ID]);

        $repository    = $this->app->make(ActorRepositoryInterface::class);
        $this->cut     = new ActorController($repository);
    }

    public function testRequestObjectIsReturnedWhenCallingShowActor()
    {
        $this->assertInstanceOf(Response::class, $this->cut->show(self::ACTOR_ID));
    }

    public function testResponseStatusCodeIs200()
    {
        $this->assertEquals(200, $this->cut->show(self::ACTOR_ID)->getStatusCode());
    }

    public function testReturnsAnActorForSpecifiedId()
    {
        $actors = $this->add('actor', 10);
        $actor  = $actors[5];

        unset($actor['last_update']);

        $response = $this->cut->show((int)$actor['actor_id']);
        $content  = json_decode($response->content(), true);

        $this->assertEquals($actor['actor_id'], $content['actorId']);
        $this->assertEquals($actor['first_name'], $content['firstName']);
        $this->assertEquals($actor['last_name'], $content['lastName']);
    }

    public function testThrowsHttpNotFoundExceptionWhenActorDoesNotExist()
    {
        $this->expectExceptionMessage(NotFoundException::class);
        $this->expectExceptionMessage('Row (ID:999) not found in `actor` table');

        $this->cut->show(999);
    }
}
