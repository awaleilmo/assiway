<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Library;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
            ->whereRaw("UPPER(" . $column . ") LIKE '%" . strtoupper($search) . "%'")
            ->orderBy('noInvoice', 'asc')
            ->paginate($perPage);
        return Inertia::render('Admin/Invoice', [
            'dataInvoice' => $invoice
        ]);
    }

    public function create(Request $request): RedirectResponse
    {
        try{
            $validate = Validator::make($request->all(), [
                'book_id' => 'required',
                'user_id' => 'required',
                'price' => 'required',
            ]);
            if ($validate->fails()) {
                return Redirect::back()->with('response', [
                    'status' => false,
                    'color' => 'bg-red-50 text-red-600',
                    'message' => $validate->errors()->first(),
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
            return Redirect::back()->with('response', [
                'status' => true,
                'color' => 'bg-green-50 text-green-600',
                'message' => 'Data has been saved',
            ]);
        } catch (Throwable $th) {
            return Redirect::back()->with('response', [
                'status' => false,
                'color' => 'bg-red-50 text-red-600',
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function updateStatus(Request $request): RedirectResponse
    {
        try{
            $validate = Validator::make($request->all(), [
                'id' => 'required',
                'status' => 'required',
            ]);
            if ($validate->fails()) {
                return Redirect::back()->with('response', [
                    'status' => false,
                    'color' => 'bg-red-50 text-red-600',
                    'message' => $validate->errors()->first(),
                ]);
            }
            $form = Invoice::query()->find($request->get('id'));
            $form->setAttribute('status', $request->get('status'));
            if($request->get('status') == 2) {
                try {
                    $fromNew = new Library();
                    $fromNew->setAttribute('user_id', $form->getAttribute('user_id'));
                    $fromNew->setAttribute('book_id', $form->getAttribute('book_id'));
                    $fromNew->save();
                } catch (Throwable $th) {
                    return Redirect::back()->with('response', [
                        'status' => false,
                        'color' => 'bg-red-50 text-red-600',
                        'message' => $th->getMessage(),
                    ]);
                }
            }
            $form->save();
            return Redirect::back()->with('response', [
                'status' => true,
                'color' => 'bg-green-50 text-green-600',
                'message' => 'Data has been saved',
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
