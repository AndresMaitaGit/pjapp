<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Response;


class ProductosController extends Controller
{
    public function index()
    {
        $productos = Product::all();
        return view('productos', compact('productos'));
    }

    public function store(Request $request)
    {
        $response = array('state'=>false,'message'=>'success');

        $data = $request->input();

        $vld = Validator::make($data, [
            'name_product' => ['required', 'max:100'],
            'price' => ['required'],
            'impuesto' => ['required'],
        ]);
            
        if ($vld->fails()) {
            $response['message'] = $vld->errors()->first(); 
            return Response::json($response); 
        }
        
        $product = new Product();
        $product->name_product = $request->name_product;
        $product->price = $request->price;  
        $product->impuesto = $request->impuesto;   
        $product->save();
        $response['state'] = true;
        $response['message'] = 'Producto Guardado exitosamente.';
        return Response::json($response);
            

    }


    public function show(Request $request)
    {
       $product = Product::findOrfail($request->item_edit); // recuperará el primer resultado de la consulta
        return $product;
    }

    public function update(Request $request)

    {
        $response = array('state'=>false,'message'=>'success');

        $data = $request->input();

        $vld = Validator::make($data, [
            'item_id' => ['required', 'max:100'],
            'name_product_edit' => ['required', 'max:100'],
            'price_edit' => ['required'],
            'impuesto_edit' => ['required'],
        ]);
            
        if ($vld->fails()) {
            $response['message'] = $vld->errors()->first(); 
            return Response::json($response); 
        }
        
        $product = Product::findOrfail($request->item_id); //recuperará el primer resultado de la consulta            $product->user_id = auth()->user()->id;
        $product->name_product = $request->name_product_edit;
        $product->price = $request->price_edit;  
        $product->impuesto = $request->impuesto_edit;    
        $product->save();
        $response['state'] = true;
        $response['message'] = 'Producto Actualizado exitosamente.';
        return Response::json($response);
        
    }

    public function destroy(Request $request)
    {
        $response = array('state'=>false,'message'=>'success');


            $product = Product::destroy($request->item_delete);
            $response['state'] = true;
            return Response::json($response);
    }
}

