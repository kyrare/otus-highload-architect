<?php


namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Support\Facades\DB;

class UsersController
{
    public function index()
    {
        /** @var \Illuminate\Database\Connection $connection */
        $connection = DB::connection();
        $pdo = $connection->getPdo();

        $search = request()->get('q');

        if ($search) {
            $s = "SELECT id, name, surname FROM users WHERE name LIKE '{$search}%' OR surname LIKE '{$search}%' ORDER BY id DESC LIMIT 100";
        } else {
            $s = 'SELECT id, name, surname FROM users ORDER BY id DESC LIMIT 100';
        }

        $users = $pdo->query($s)->fetchAll();

        return view('users.index', compact(
            'users',
            'search',
        ));
    }

    public function show(int $userId)
    {
        /** @var \Illuminate\Database\Connection $connection */
        $connection = DB::connection();
        $pdo = $connection->getPdo();

        $user = $pdo->query(sprintf('SELECT * FROM users WHERE id = %d', $userId))->fetch();

        if (!$user)
            return abort(404);

        $slq = sprintf('SELECT id, name FROM interests i JOIN users_interests ui ON i.id = ui.interest_id WHERE ui.user_id = %d ORDER BY name', $userId);
        $interests = $pdo->query($slq)->fetchAll();

        $sql = sprintf('SELECT id, name, surname FROM users u JOIN users_friends uf ON u.id = uf.user_id OR u.id = uf.friend_id WHERE id != %d AND (uf.user_id = %d OR uf.friend_id = %d) LIMIT 20', $userId, $userId, $userId);
        $friends = $pdo->query($sql)->fetchAll();

        $mutualFriends = [];
        if (User::isAuthorized() && User::getCurrentId() != $user['id']) {
            $sql = sprintf(
                'SELECT DISTINCT id, name, surname
                        FROM users u
                        WHERE u.id IN (
                            SELECT user_id AS id FROM users_friends uf WHERE uf.friend_id = %d
                            UNION SELECT friend_id AS id FROM users_friends uf2 WHERE uf2.user_id = %d
                        )
                        AND u.id IN (
                            SELECT user_id AS id FROM users_friends uf3 WHERE uf3.friend_id = %d
                            UNION SELECT friend_id AS id FROM users_friends uf4 WHERE uf4.user_id = %d
                        )
                        AND id != %d AND id != %d
                        LIMIT 20',
                $userId, $userId, User::getCurrentId(), User::getCurrentId(), $userId, User::getCurrentId()
            );

            $mutualFriends = $pdo->query($sql)->fetchAll();
        }

        $canAddToFriends = User::canAddToFriends($user['id']);
        $inFriends = $canAddToFriends ? false : User::inFriends($user['id']);

        return view('users.show', compact(
            'user',
            'interests',
            'friends',
            'mutualFriends',
            'canAddToFriends',
            'inFriends',
        ));
    }

    public function addFriend(int $userId)
    {
        if (!User::canAddToFriends($userId)) {
            return redirect()
                ->route('users-add-friend', $userId)
                ->withErrors(['users-add-friend' => 'Вы не можете добавить этого пользователя в друзья']);
        }

        /** @var \Illuminate\Database\Connection $connection */
        $connection = DB::connection();
        $pdo = $connection->getPdo();

        /** @link https://www.php.net/manual/ru/pdo.prepare.php */
        $sth = $pdo->prepare('INSERT INTO users_friends (user_id, friend_id) VALUES (?, ?)');

        $sth->execute([
            User::getCurrentId(),
            $userId,
        ]);

        return redirect()->route('users-add-friend', $userId)
            ->with(['users-add-friend-success' => true]);
    }
}
