<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Inertia\Response as inertiaResponse;
use Throwable;

class BookController extends Controller
{
    public function AdminIndex(Request $request): inertiaResponse
    {
        $perPage = $request->get('perPage') ?: 10;
        $search = $request->get('search') ?: '';
        $column = $request->get('column') ?: 'name';
        $book = Book::query()
            ->whereRaw("UPPER(" . $column . ") LIKE '%" . strtoupper($search) . "%'")
            ->orderBy('name', 'asc')
            ->paginate($perPage);
        return Inertia::render('Admin/Book', [
            'dataBooks' => $book
        ]);
    }

    public function createOrEdit(Request $request): RedirectResponse
    {
        try {
            $validate = Validator::make($request->all(), [
                'name' => 'required',
                'author' => 'required',
                'description' => 'required',
                'year' => 'required',
                'publisher' => 'required',
                'price' => 'required',
                'cover' => 'required',
                'coverType' => 'required',
                'fileData' => 'required',
            ]);
            if ($validate->fails()) {
                return Redirect::back()->with('response', [
                    'status' => false,
                    'color' => 'bg-red-50 text-red-600',
                    'message' => $validate->errors()->first(),
                ]);
            }
            $request->get('id') !== null ? $form = Book::query()->find($request->get('id')) : $form = new Book();
            $file = $request->file('fileData');
            $tanggal = Carbon::now()->format('Ymd');
            $nama_file = 'book' . $tanggal . '_' . $file->getClientOriginalName();
            $file->storeAs('book/', $nama_file);
            $form->setAttribute('name', $request->get('name'));
            $form->setAttribute('author', $request->get('author'));
            $form->setAttribute('description', $request->get('description'));
            $form->setAttribute('years', $request->get('year'));
            $form->setAttribute('publisher', $request->get('publisher'));
            $form->setAttribute('price', $request->get('price'));
            $form->setAttribute('cover', $request->get('cover'));
            $form->setAttribute('coverType', $request->get('coverType'));
            $form->setAttribute('file', $nama_file);
            $form->save();
            return Redirect::back()->with('response', [
                'status' => true,
                'color' => 'bg-green-100 text-green-600',
                'message' => 'Data berhasil disimpan',
            ]);
        } catch (Throwable $th) {
            return Redirect::back()->with('response', [
                'status' => false,
                'color' => 'bg-red-50 text-red-600',
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function delete(Request $request): RedirectResponse
    {
        try {
            Book::query()->find($request->get('id'))->delete();
            return Redirect::back()->with('response', [
                'status' => true,
                'color' => 'bg-green-100 text-green-600',
                'message' => 'Data berhasil dihapus',
            ]);
        } catch (Throwable $th) {
            return Redirect::back()->with('response', [
                'status' => false,
                'color' => 'bg-red-50 text-red-600',
                'message' => $th->getMessage(),
            ]);
        }
    }
}
