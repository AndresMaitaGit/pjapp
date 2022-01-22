<?php

namespace App\Http\Controllers;

use App\Models\Pending;
use App\Models\Product;
use App\Models\ProductBuy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Response;

class ComprarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productos = Product::all();
            return view('comprar', compact('productos'));
    }


    public function store(Request $request)
    {
        $response = array('state'=>false,'message'=>'success');

        $data = $request->input();

        $vld = Validator::make($data, [
            'item_comprar' => ['required'],
        ]);
            
        if ($vld->fails()) {
            $response['message'] = $vld->errors()->first(); 
            return Response::json($response); 
        }
            
            $product_buy = new ProductBuy();
            $product_buy->user_id = auth()->user()->id;
            $product_buy->product_id = $request->item_comprar;
            $product_buy->facturado = 0;  
            $product_buy->save();
            
            $total_sin_impuesto = 0;
            $total_de_impuesto = 0;
            $total_a_pagar = 0;
                $products_pendientes = ProductBuy::where('user_id',auth()->user()->id)->where('facturado', 0)->get();
                foreach ($products_pendientes as $productBuy) {
                    $producto = Product::findOrfail($productBuy->product_id);
                    $total_sin_impuesto = $total_sin_impuesto + $producto->price;
                    $total_de_impuesto = $total_de_impuesto + ($producto->price * $producto->impuesto)/100;
                    $total_a_pagar = $total_sin_impuesto + $total_de_impuesto;
                }
                $validar = DB::table('pendings')->where('user_id',auth()->user()->id)->exists();
                if($validar){
                    Pending::where('user_id',auth()->user()->id)->delete();
                }
                $pending = new Pending();
                $pending->user_id = auth()->user()->id;
                $pending->products = json_encode($products_pendientes);
                $pending->total_sin_impuesto = $total_sin_impuesto; 
                $pending->total_de_impuesto = $total_de_impuesto; 
                $pending->total_a_pagar = $total_a_pagar; 
                $pending->save();
                 
                $response['state'] = true;
                return Response::json($response);
            
            
    }
}
