<?php

namespace App\Http\Controllers;

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
}
