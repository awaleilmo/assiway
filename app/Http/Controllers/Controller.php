<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Library;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response as inertiaResponse;
use phpDocumentor\Reflection\Types\Object_;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function dashboardMember(Request $request): inertiaResponse
    {
        $perPage = $request->get('perPage') ?: 10;
        $search = $request->get('search') ?: '';
        $column = $request->get('column') ?: 'name';
        $userId = Auth::user()['id'];
        $myBook = Library::query()
            ->leftJoin('books', 'libraries.book_id', '=', 'books.id')
            ->where('libraries.user_id', $userId)
            ->whereRaw("UPPER(" . $column . ") LIKE '%" . strtoupper($search) . "%'")
            ->select('books.*')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
        return Inertia::render('Member/Index', [
            'dataBooks' => $myBook
        ]);

    }

    public function homeIndex(Request $request): inertiaResponse
    {
        $traffic = new TrafficController();
        $traffic->addTrafficPage('home');
        $myBook = Book::query()->where('display', 1)->get();
        return Inertia::render('Home/Index', [
            'dataBooks' => $myBook
        ]);
    }
}
