<?php namespace App\Tests;

use App\Application\Domain\Common\Mapper\ErrorCodeMapper;
use App\Tests\ApiTester;

class GetUsersByTeamCest
{
    public function _before(ApiTester $I)
    {
    }

    // tests
    public function success(ApiTester $I)
    {
        $I->wantTo('Get users by team');

        $userId = $I->createUser();
        $user2Id = $I->createUser();
        $token = $I->createUserAuthToken($userId);
        $companyId = $I->createCompany();
        $teamId = $I->createTeam($companyId);
        $I->joinUserToTeam($userId, $teamId);
        $I->joinUserToTeam($user2Id, $teamId);

        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->haveHttpHeader('Accept', 'application/json');
        $I->haveHttpHeader('X-AUTH-TOKEN', $token);

        $I->sendGET(sprintf('/api/v1/teams/%d/users', $teamId));
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseJsonMatchesJsonPath('$.users[*].id');
        $I->seeResponseJsonMatchesJsonPath('$.users[*].nick');
        $I->seeResponseJsonMatchesJsonPath('$.users[*].avatar');
        $I->seeResponseJsonMatchesJsonPath('$.users[*].externalId');

        $response = json_decode($I->grabResponse(), true);

        \PHPUnit\Framework\Assert::assertTrue(count($response['users']) == 2);
        \PHPUnit\Framework\Assert::assertTrue($response['users'][0]['id'] == $userId);
        \PHPUnit\Framework\Assert::assertTrue($response['users'][1]['id'] == $user2Id);
    }

    public function invalidTeamId(ApiTester $I)
    {
        $I->wantTo('Invalid team id');

        $userId = $I->createUser();

        $token = $I->createUserAuthToken($userId);
        $companyId = $I->createCompany();
        $teamId = $I->createTeam($companyId);


        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->haveHttpHeader('Accept', 'application/json');
        $I->haveHttpHeader('X-AUTH-TOKEN', $token);

        $I->sendGET(sprintf('/api/v1/teams/%d/users', $teamId));
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::BAD_REQUEST);
        $I->seeResponseJsonMatchesJsonPath('$.error.code');
        $I->seeResponseJsonMatchesJsonPath('$.error.message');
        $I->seeResponseJsonMatchesJsonPath('$.error.userMessage');

        $response = json_decode($I->grabResponse(), true);

        \PHPUnit\Framework\Assert::assertEquals(ErrorCodeMapper::ERROR_INVALID_REQUEST, $response['error']['code']);
    }
}
