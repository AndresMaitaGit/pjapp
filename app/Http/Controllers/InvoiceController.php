<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Pending;
use App\Models\Product;
use App\Models\ProductBuy;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Response;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('factura');
    }

    function store(Request $request)
    {
        $response = array('state'=>false,'message'=>'success');

        $validar = DB::table('pendings')->exists();
        if($validar){
            $pendientes = Pending::all();
            foreach ($pendientes as $factura) {

                $pending = new Invoice();
                $pending->user_id = $factura->user_id;
                $pending->name_client = User::findOrfail($factura->user_id)->name;
                $pending->products = $factura->products;
                $products = json_decode($factura->products);
                foreach ($products as $product) {
                    $editar = ProductBuy::findOrfail($product->id);
                    $editar->facturado = 1;
                    $editar->save(); 
                }
                $pending->total_sin_impuesto = $factura->total_sin_impuesto; 
                $pending->total_de_impuesto = $factura->total_de_impuesto; 
                $pending->total_a_pagar = $factura->total_a_pagar; 
                $pending->save();

                $VaciarPendiente = Pending::where('user_id',$factura->user_id)->delete();
            }
            $response['state'] = true;
            return Response::json($response);
        } else {
            $response['state'] = false;
            $response['message'] = 'No hay facturas por emitir.';
            return Response::json($response);
        }
    }

    public function show()
    {
        $response = array('state'=>false,'message'=>'success');
        $validar = DB::table('invoices')->exists();
        if($validar){
            $facturas = Invoice::all();
            $response['state'] = true;
            $response['facturas'] = $facturas;
            $response['products'] = Product::all();
            return Response::json($response);
        } else {
            $response['state'] = false;
            $response['message'] = 'No hay Registros de Factura.';
            return Response::json($response);
        }
    }

}