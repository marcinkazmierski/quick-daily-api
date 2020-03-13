<?php namespace App\Tests;

use App\Tests\ApiTester;

class GetTeamsCest
{
    public function _before(ApiTester $I)
    {
    }

    // tests
    public function success(ApiTester $I)
    {
        $I->wantTo('Get user teams');

        $userId = $I->createUser();
        $token = $I->createUserAuthToken($userId);
        $companyId = $I->createCompany();
        $team1Id = $I->createTeam($companyId);
        $team2Id = $I->createTeam($companyId);
        $I->joinUserToTeam($userId, $team1Id);
        $I->joinUserToTeam($userId, $team2Id);

        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->haveHttpHeader('Accept', 'application/json');
        $I->haveHttpHeader('X-AUTH-TOKEN', $token);

        $I->sendGET('/api/v1/teams');
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseJsonMatchesJsonPath('$.teams[*].id');
        $I->seeResponseJsonMatchesJsonPath('$.teams[*].name');
        $I->seeResponseJsonMatchesJsonPath('$.teams[*].description');
        $I->seeResponseJsonMatchesJsonPath('$.teams[*].externalAppKey');
        $I->seeResponseJsonMatchesJsonPath('$.teams[*].image');

        $response = json_decode($I->grabResponse(), true);

        \PHPUnit\Framework\Assert::assertTrue(count($response['teams']) == 2);
        \PHPUnit\Framework\Assert::assertTrue($response['teams'][0]['id'] == $team1Id);
        \PHPUnit\Framework\Assert::assertTrue($response['teams'][1]['id'] == $team2Id);
    }
}
