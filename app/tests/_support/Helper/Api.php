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
     * @throws \Exception
     */
    public function createUser(array $params = [] ): int
    {
        $nick = $params['nick'] ?? uniqid('nick-');
        $email = $params['email'] ?? uniqid('email-') . '@gmail.com';
        $password = password_hash($params['password'] ?? uniqid('password-'), PASSWORD_BCRYPT, ['cost' => 5]);
        $status = $params['status'] ?? 1;

        try {
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
        } catch (ModuleException $exception) {
            return null;
        }
    }
}
