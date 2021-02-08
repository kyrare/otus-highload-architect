<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function form(Request $request)
    {
        if (User::isAuthorized())
            return redirect()->route('users-show', User::getCurrentId());

        /** @var \Illuminate\Database\Connection $connection */
        $connection = DB::connection();
        $pdo = $connection->getReadPdo();

        $interests = $pdo->query('SELECT * FROM interests ORDER BY name')->fetchAll();

        return view('auth.register', compact('interests'));
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'login' => ['required', 'string', 'max:255', 'unique:users,login'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'birthday' => ['required', 'date'],
            'sex' => ['required', 'boolean'],
            'interests' => ['required', 'array'],
            'interests.*' => ['required', 'int'],
            'city' => ['required', 'string'],
        ]);

        /** @var \Illuminate\Database\Connection $connection */
        $connection = DB::connection();
        $pdo = $connection->getPdo();

        /** @link https://www.php.net/manual/ru/pdo.prepare.php */
        $sth = $pdo->prepare('INSERT INTO users (login, password, name, surname, birthday, sex, city, created_at, updated_at) VALUES (' . implode(', ', array_fill(0, 9, '?')) . ')');

        $sth->execute([
            $data['login'],
            Hash::make($data['password']),
            $data['name'],
            $data['surname'],
            $data['birthday'],
            $data['sex'],
            $data['city'],
            date('Y-m-d H:i:s'),
            date('Y-m-d H:i:s'),
        ]);

        $userId = $pdo->lastInsertId();

        $sth = $pdo->prepare('INSERT INTO users_interests (user_id, interest_id) VALUES (?, ?)');

        foreach ($data['interests'] as $interestId)
            $sth->execute([$userId, $interestId]);

        User::setCurrentUserId($userId);

        return redirect()->route('users-show', $userId);
    }
}
