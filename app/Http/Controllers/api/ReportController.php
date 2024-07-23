<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Purchase;

class ReportController extends Controller
{
    public function stock()
        {
            try {
                $purchased = Purchase::with([
                    'carModel:id,mst_brand_type_id,model',
                    'color:id,color',
                    'brand:id,type',
                ])
                ->Selected()
                ->withSum('refurbishment', 'total_amount')
                ->whereIn('status', [6, 7])
                ->where('is_sold', '!=', 1)
                ->orderBy('id', 'desc')
                ->get()
                ->makeHidden(['refurbishment_sum_total_amount','pending_image_status','fuel_type','status','mst_brand_type_id','mst_model_id','mst_color_id','brand','carModel','color']);

                if ($purchased->isEmpty()) {
                    return response()->json([
                        'status' => false,
                        'message' => 'No stock found',
                        'data' => []
                    ], 404);
                }

                return response()->json([
                    'status' => true,
                    'message' => 'Stock successfully fetched',
                    'data' => $purchased
                ], 200);

            } catch (QueryException $e) {
                \Log::error('QueryException: ' . $e->getMessage());
                return response()->json([
                    'status' => false,
                    'message' => 'Error fetching stock. Please try again later.'
                ], 500);
            } catch (\Exception $e) {
                \Log::error('Exception: ' . $e->getMessage());
                return response()->json([
                    'status' => false,
                    'message' => $e->getMessage()
                ], 500);
            }
        }
}
