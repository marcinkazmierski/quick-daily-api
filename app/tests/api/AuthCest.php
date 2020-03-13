<?php namespace App\Tests;

use App\Application\Domain\Common\Mapper\ErrorCodeMapper;
use App\Tests\ApiTester;

class AuthCest
{
    public function _before(ApiTester $I)
    {
    }

    // tests
    public function emptyCredentials(ApiTester $I)
    {
        $I->wantTo('Empty user credentials');

        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPOST('/api/v1/auth/authenticate');
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::BAD_REQUEST);
        $I->seeResponseIsJson();
        $I->seeResponseJsonMatchesJsonPath('$.error.code');
        $I->seeResponseJsonMatchesJsonPath('$.error.message');
        $I->seeResponseJsonMatchesJsonPath('$.error.userMessage');

        $response = json_decode($I->grabResponse());
        \PHPUnit\Framework\Assert::assertEquals(
            ErrorCodeMapper::ERROR_INVALID_USER_CREDENTIALS,
            $response->error->code,
            "Invalid error code"
        );
    }

    public function invalidCredentials(ApiTester $I)
    {
        $I->wantTo('Invalid user credentials');

        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPOST('/api/v1/auth/authenticate', ['email' => 'test1@tt.pl', 'password' => 'abcdef']);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::BAD_REQUEST);
        $I->seeResponseIsJson();
        $I->seeResponseJsonMatchesJsonPath('$.error.code');
        $I->seeResponseJsonMatchesJsonPath('$.error.message');
        $I->seeResponseJsonMatchesJsonPath('$.error.userMessage');

        $response = json_decode($I->grabResponse());
        \PHPUnit\Framework\Assert::assertEquals(
            ErrorCodeMapper::ERROR_INVALID_USER_CREDENTIALS,
            $response->error->code,
            "Invalid error code"
        );
    }

    public function validCredentials(ApiTester $I)
    {
        $I->wantTo('Generate access token');

        $email = uniqid('email-') . '@gmail.com';
        $password = uniqid('password-');

        $userId = $I->createUser([
            'email' => $email,
            'password' => $password
        ]);

        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPOST('/api/v1/auth/authenticate', ['email' => $email, 'password' => $password]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseJsonMatchesJsonPath('$.token');
        $I->seeResponseJsonMatchesJsonPath('$.userId');

        $response = json_decode($I->grabResponse());
        \PHPUnit\Framework\Assert::assertEquals(
            $userId,
            $response->userId,
            "Invalid userId"
        );

    }
}
