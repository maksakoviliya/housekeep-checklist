<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

final class UserController extends Controller
{
    public function index(): Factory|View
    {
        return view('users.index', [
            'users' => User::query()->paginate(),
        ]);
    }
}
