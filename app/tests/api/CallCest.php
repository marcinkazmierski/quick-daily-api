<?php namespace App\Tests;

use App\Tests\ApiTester;

class CallCest
{
    public function _before(ApiTester $I)
    {
    }

    // tests
    public function success(ApiTester $I)
    {
        $I->wantTo('Init call');

        $userId = $I->createUser();
        $token = $I->createUserAuthToken($userId);
        $companyId = $I->createCompany();
        $team1Id = $I->createTeam($companyId);
        $I->joinUserToTeam($userId, $team1Id);

        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->haveHttpHeader('Accept', 'application/json');
        $I->haveHttpHeader('X-AUTH-TOKEN', $token);

        $callId = uniqid('call-id-');
        $params = [
            'callId' => $callId,
            'teamId' => $team1Id,
        ];
        $I->sendPOST('/api/v1/users/call', $params);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::NO_CONTENT);

        $I->seeInDatabase('users', ['id' => $userId, 'external_call_id' => $callId]);
    }
}
