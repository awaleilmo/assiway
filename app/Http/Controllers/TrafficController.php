<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Traffic;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class TrafficController extends Controller
{
    public function addTrafficPage($page): JsonResponse
    {
        try{
            $traffic = Traffic::query()
                ->where('page', $page)
                ->first();

            $traffic->increment('view');
            $traffic->save();
            return response()->json([
                'status' => true,
                'message' => 'Success'
            ]);
        }catch (Throwable $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function addTrafficBook($book): JsonResponse
    {
        try{
            $traffic = Traffic::query()
                ->where('book_id', $book)
                ->first();
            if($traffic === null){
                $traffic = new Traffic();
                $traffic->setAttribute('book_id', $book);
                $traffic->setAttribute('view', 1);
            }else{
                $traffic->increment('view');
            }
            $traffic->save();
            return response()->json([
                'status' => true,
                'message' => 'Success'
            ]);
        }catch (Throwable $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function statistics(): JsonResponse
    {
        $graphPenjualan = Invoice::query()->whereNotIn('status', [0, 3])->selectRaw('count(*) as total')->first();
        $graphBelumBayar = Invoice::query()->where('status', 0)->selectRaw('count(*) as total')->first();
        $graphPenjualanPerBook = Invoice::query()
            ->leftJoin('books', 'books.id', '=', 'invoices.book_id')
            ->whereNotIn('invoices.status', [0, 3])
            ->selectRaw('count(invoices.book_id) as data, books.name as name')
            ->groupBy('invoices.book_id','books.name')->get();
        $graphPengunjung = Traffic::query()->where('page', '!=',null)->selectRaw('sum(view) as total')->first();
        return response()->json([
            'status' => true,
            'graphPenjualan' => $graphPenjualan,
            'graphPengunjung' => $graphPengunjung,
            'graphPenjualanPerBook' => $graphPenjualanPerBook,
            'graphBelumBayar' => $graphBelumBayar
        ]);
    }
}
