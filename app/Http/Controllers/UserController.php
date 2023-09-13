<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response as inertiaResponse;

class UserController extends Controller
{
    public function adminIndex(Request $request): inertiaResponse
    {
        $perPage = $request->get('perPage') ?: 10;
        $search = $request->get('search') ?: '';
        $column = $request->get('column') ?: 'name';
        $user = User::query()
            ->whereRaw("UPPER(" . $column . ") LIKE '%" . strtoupper($search) . "%'")
            ->whereNot('isAdmin', 1)
            ->orderBy('name')
            ->paginate($perPage);
        return Inertia::render('Admin/UserManagement', [
            'dataUsers' => $user
        ]);
    }
}
