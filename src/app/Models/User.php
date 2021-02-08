<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class User
{
    const SEX_MALE = 0;
    const SEX_FEMALE = 1;

    public static function getCurrentId(): int
    {
        return (int)session('user_id', 0);
    }

    public static function isAuthorized(): bool
    {
        return self::getCurrentId() > 0;
    }

    public static function setCurrentUserId(int $id)
    {
        session()->put('user_id', (int)$id);
    }

    public static function canAddToFriends(int $userId): bool
    {
        if (!self::isAuthorized())
            return false;

        if (self::getCurrentId() == $userId)
            return false;

        return !self::inFriends($userId);
    }

    public static function inFriends(int $userId): bool
    {
        /** @var \Illuminate\Database\MySqlConnection $connection */
        $connection = DB::connection();
        $pdo = $connection->getReadPdo();

        $sql = sprintf(
            'SELECT COUNT(1) as exist FROM users_friends WHERE (user_id = %d AND friend_id = %d) OR (user_id = %d AND friend_id = %d)',
            self::getCurrentId(),
            $userId,
            $userId,
            self::getCurrentId(),
        );

        $result = $pdo->query($sql)->fetch();

        return $result['exist'] > 0;
    }

    public static function logout()
    {
        session()->forget('user_id');
    }
}
