<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function form(Request $request)
    {
        if (User::isAuthorized())
            return redirect()->route('users-show', User::getCurrentId());

        return view('auth.login');
    }

    public function login(Request $request)
    {
        if (User::isAuthorized())
            return redirect()->route('users-show', User::getCurrentId());

        $data = $request->validate([
            'login' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'max:255'],
        ]);

        /** @var \Illuminate\Database\MySqlConnection $connection */
        $connection = DB::connection();
        $pdo = $connection->getReadPdo();

        /** @link https://www.php.net/manual/ru/pdo.prepare.php */
        $sth = $pdo->prepare('SELECT id, login, password FROM users WHERE login = ? LIMIT 1');

        $sth->execute([$data['login']]);
        $user = $sth->fetch();

        if (!$user || !Hash::check($data['password'], $user['password'])) {
            return redirect()
                ->route('login')
                ->withErrors(['auth' => 'Не правльный логин или пароль'])
                ->withInput();
        }

        User::setCurrentUserId($user['id']);

        return redirect()->route('users-show', $user['id']);
    }

    public function logout()
    {
        User::logout();

        return redirect()->route('home');
    }
}
