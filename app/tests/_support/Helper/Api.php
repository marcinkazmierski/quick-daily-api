<?php

namespace App\Tests\Helper;

use Codeception\Exception\ModuleException;
use Codeception\Module\Db;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

class Api extends \Codeception\Module
{
    /**
     * @param array $params
     * @return int
     */
    public function createUser(array $params = []): int
    {
        try {
            $nick = $params['nick'] ?? uniqid('nick-');
            $email = $params['email'] ?? uniqid('email-') . '@gmail.com';
            $password = password_hash($params['password'] ?? uniqid('password-'), PASSWORD_BCRYPT, ['cost' => 5]);
            $status = $params['status'] ?? 1;

            /** @var Db $dbModule */
            $dbModule = $this->getModule('Db');

            $dbModule->haveInDatabase('users', [
                'nick' => $nick,
                'email' => $email,
                'status' => $status,
                'password' => $password,
                'created_at' => (new \DateTime('-1 day'))->format('Y-m-d H:i:s'),
            ]);
            $userId = $dbModule->grabColumnFromDatabase('users', 'id', ['email' => $email]);
            $userId = (int)array_pop($userId);

            return $userId;
        } catch (\Throwable $exception) {
            return null;
        }
    }

    public function createUserAuthToken(int $userId): string
    {
        $token = strtoupper(uniqid('token-'));

        try {
            /** @var Db $dbModule */
            $dbModule = $this->getModule('Db');

            $dbModule->haveInDatabase('user_tokens', [
                'user_id' => $userId,
                'token_key' => $token,
            ]);

            return $token;
        } catch (ModuleException $exception) {
            return null;
        }
    }

    /**
     * @param array $params
     * @return string
     */
    public function createCompany(array $params = []): string
    {
        try {
            $name = $params['name'] ?? uniqid('name-');
            $appKey = $params['appKey'] ?? uniqid('appKey-');

            /** @var Db $dbModule */
            $dbModule = $this->getModule('Db');

            $dbModule->haveInDatabase('companies', [
                'name' => $name,
                'external_app_id' => $appKey,
            ]);

            $id = $dbModule->grabColumnFromDatabase('companies', 'id', ['name' => $name, 'external_app_id' => $appKey]);
            $id = (int)array_pop($id);

            return $id;
        } catch (ModuleException $exception) {
            return null;
        }
    }

    public function createTeam(int $companyId, array $params = []): string
    {
        try {
            $name = $params['name'] ?? uniqid('name-');
            $description = $params['description'] ?? uniqid('description-');

            /** @var Db $dbModule */
            $dbModule = $this->getModule('Db');

            $dbModule->haveInDatabase('teams', [
                'company_id' => $companyId,
                'name' => $name,
                'description' => $description,
                'image' => 'image.jpg',
            ]);

            $id = $dbModule->grabColumnFromDatabase('teams', 'id', ['name' => $name, 'description' => $description]);
            $id = (int)array_pop($id);

            return $id;
        } catch (ModuleException $exception) {
            return null;
        }
    }

    public function joinUserToTeam(int $userId, int $teamId): void
    {
        try {
            /** @var Db $dbModule */
            $dbModule = $this->getModule('Db');

            $dbModule->haveInDatabase('users_teams', [
                'user_id' => $userId,
                'team_id' => $teamId,
            ]);
        } catch (ModuleException $exception) {
        }
    }
}
