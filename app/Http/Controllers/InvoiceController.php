<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Library;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Inertia\Response as inertiaResponse;
use Throwable;

class InvoiceController extends Controller
{
    public function adminIndex(Request $request): inertiaResponse
    {
        $perPage = $request->get('perPage') ?: 10;
        $search = $request->get('search') ?: '';
        $column = $request->get('column') ?: 'noInvoice';
        $invoice = Invoice::query()
            ->whereRaw("UPPER(invoices." . $column . ") LIKE '%" . strtoupper($search) . "%'")
            ->leftJoin('books', 'books.id', '=', 'invoices.book_id')
            ->leftJoin('users', 'users.id', '=', 'invoices.user_id')
            ->select('invoices.*', 'books.name as book_name', 'users.name as user_name')
            ->orderBy('invoices.noInvoice')
            ->paginate($perPage);
        return Inertia::render('Admin/Invoice', [
            'dataInvoice' => $invoice
        ]);
    }

    public function memberIndex(Request $request): inertiaResponse
    {
        $perPage = $request->get('perPage') ?: 10;
        $search = $request->get('search') ?: '';
        $column = $request->get('column') ?: 'noInvoice';
        $userId = Auth::user()['id'];
        $invoice = Invoice::query()
            ->whereRaw("UPPER(invoices." . $column . ") LIKE '%" . strtoupper($search) . "%'")
            ->where('invoices.user_id', $userId)
            ->leftJoin('books', 'books.id', '=', 'invoices.book_id')
            ->leftJoin('users', 'users.id', '=', 'invoices.user_id')
            ->select('invoices.*', 'books.name as book_name', 'users.name as user_name')
            ->orderBy('invoices.noInvoice')
            ->paginate($perPage);
        return Inertia::render('Member/Invoice', [
            'dataInvoice' => $invoice
        ]);
    }

    public function create(Request $request): JsonResponse
    {
        try{
            $validate = Validator::make($request->all(), [
                'book_id' => 'required',
                'user_id' => 'required',
                'price' => 'required',
            ]);
            if ($validate->fails()) {
                return response()->json([
                    'status' => false,
                    'color' => 'bg-red-50 text-red-600 border border-red-400',
                    'message' => $validate->errors()->first(),
                ]);
            }
            $validateDuplicate = Invoice::query()->where('book_id', $request->get('book_id'))->where('user_id', $request->get('user_id'))->first();
            if($validateDuplicate){
                return response()->json([
                    'status' => true,
                    'color' => 'bg-green-100 text-green-600 border border-green-400',
                    'message' => 'Kamu sudah memesan buku yang sama, Lihat Di menu invoice',
                    'contents' => $validateDuplicate
                ]);
            }
            $tanggal = Carbon::now()->format('YmdHis');
            $request->get('id') !== null ? $form = Invoice::query()->find($request->get('id')) : $form = new Invoice();
            $form->setAttribute('noInvoice', '#'. $request->get('user_id').'-' . $tanggal.'-' . $request->get('book_id'));
            $form->setAttribute('book_id', $request->get('book_id'));
            $form->setAttribute('user_id', $request->get('user_id'));
            $form->setAttribute('price', $request->get('price'));
            $form->setAttribute('status', 0);
            $form->save();
            return response()->json([
                'status' => true,
                'color' => 'bg-green-100 text-green-600 border border-green-400',
                'message' => 'data has been saved',
                'contents' => $form
            ]);
        } catch (Throwable $th) {
            return response()->json([
                'status' => false,
                'color' => 'bg-red-50 text-red-600 border border-red-400',
                'message' => $th->getMessage(),
                'contents' => []
            ]);
        }
    }

    public function updateStatus(Request $request): JsonResponse
    {
        try{
            $validate = Validator::make($request->all(), [
                'id' => 'required',
                'status' => 'required',
            ]);
            if ($validate->fails()) {
                return response()->json([
                    'status' => false,
                    'color' => 'bg-red-50 text-red-600 border border-red-400',
                    'message' => $validate->errors()->first(),
                ]);
            }

            $form = Invoice::query()->find($request->get('id'));
            $form->setAttribute('status', $request->get('status'));
            $checkLibrary = Library::query()
                ->where('book_id', $form->getAttribute('book_id'))
                ->where('user_id', $form->getAttribute('user_id'))
                ->first();
            if($checkLibrary){
                return response()->json([
                    'status' => false,
                    'color' => 'bg-red-50 text-red-600 border border-red-400',
                    'message' => 'Data ini sudah dibayarkan',
                ]);
            }
            if($request->get('status') == 1) {
                try {
                    $fromNew = new Library();
                    $fromNew->setAttribute('user_id', $form->getAttribute('user_id'));
                    $fromNew->setAttribute('book_id', $form->getAttribute('book_id'));
                    $fromNew->save();
                } catch (Throwable $th) {
                    return response()->json([
                        'status' => false,
                        'color' => 'bg-red-50 text-red-600 border border-red-400',
                        'message' => $th->getMessage(),
                    ]);
                }
            }
            $form->save();
            return response()->json([
                'status' => true,
                'color' => 'bg-green-100 text-green-600 border border-green-400',
                'message' => 'Data has been saved',
            ]);
        } catch (Throwable $th) {
            return response()->json([
                'status' => false,
                'color' => 'bg-red-50 text-red-600 border border-red-400',
                'message' => $th->getMessage(),
            ]);
        }
    }
}
