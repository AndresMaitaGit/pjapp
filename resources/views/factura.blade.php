@extends('layouts.app')
@section('add_head')
<style>
.factura {
    table-layout: fixed;
  }
  
  .fact-info > div > h5 {
    font-weight: bold;
  }
  
  .factura > thead {
    border-top: solid 3px #000;
    border-bottom: 3px solid #000;
  }
  
  .factura > thead > tr > th:nth-child(2), .factura > tbod > tr > td:nth-child(2) {
    width: 300px;
  }
  
  .factura > thead > tr > th:nth-child(n+3) {
    text-align: right;
  }
  
  .factura > tbody > tr > td:nth-child(n+3) {
    text-align: right;
  }
  
  .factura > tfoot > tr > th, .factura > tfoot > tr > th:nth-child(n+3) {
    font-size: 24px;
    text-align: right;
  }
  
  .cond {
    border-top: solid 2px #000;
  }
</style>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body text-center">
                    <button id="emitir_invoices" class="btn btn-primary m-3"> Emitir Facturas Pendientes</button>
                    <button id="listar_invoices" class="btn btn-primary m-3"> Listar Factoras Emitidas </button>
                <div class="invalid"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<section id="demo">

</section>





<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>
<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function refresh(){
        //Actualiza la página
        location.reload();
    }
    $("#emitir_invoices").click(function(event) {
        event.preventDefault();
        let validacion = true;
        if(validacion !== false){

        $.ajax({
            method: 'post',
            processData: false,
            contentType: false,
            cache: false,
            enctype: 'multipart/form-data',
            url: '{{route('invoice.emitir')}}',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function(response){
                console.log(response);
                if(response['state'] == true){
                    Swal.fire({
                    title: "!Generación de facturas exitosamente!",
                    text: '',
                    icon: 'success',
                    showConfirmButton: false
                    });
                    setTimeout(refresh, 2000); 
                } else if(response['state'] == false){
                    $('.invalid').html('*'+ response['message']);
                }
                
            },
            error: function(response){
                console.log("error");
                console.log(response);
              
            }
        });
        }
    });
    $("#listar_invoices").click(function(event) {
        event.preventDefault();
        let validacion = true;
        if(validacion !== false){

        $.ajax({
            method: 'post',
            processData: false,
            contentType: false,
            cache: false,
            enctype: 'multipart/form-data',
            url: '{{route('invoice.listar')}}',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function(response){
                let products = response['products'];
                console.log(products[0]['name_product']);
                if(response['state'] == true){

                    let tabla = ""; 
                    // tabla_vacia = `<option value="" selected disabled></option>`;       
                    // tabla += `<option value="" selected disabled> </option>`;       
                    response.facturas.forEach(lista => {
                        tabla += `<div class="container mt-5">
                                    <div class="card mx-2">
                                        <div class="row justify-content-center">
                                            <div class="col-md-8">
                                                <div class="row mt-4">
                                                    <div class="col-10">
                                                        <h1>Factura</h1>
                                                    </div>
                                                </div>
                                            
                                                <hr />
                                            
                                                <div class="row fact-info mt-3">
                                                    <div class="col-3">
                                                        <h5>Facturar a</h5>
                                                        <p>
                                                            ${lista.name_client}
                                                        </p>
                                                    </div>
                                                    <div class="col-3">
                                                    </div>
                                                    <div class="col-3">
                                                        <h5>N° de factura</h5>
                                                        <h5>Fecha</h5>
                                                    </div>
                                                    <div class="col-3">
                                                        <h5>000${lista.id}</h5>
                                                        <p>${lista.created_at.substr(0,10)}</p>
                                                    </div>
                                                </div>
                                            
                                                <div class="row my-3">
                                                    <table class="table table-borderless factura">
                                                        <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Producto</th>
                                                            <th>price</th>
                                                            <th>impuesto</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>`;
                                            let cont = 1;
                                            let compras = JSON.parse(lista.products);
                                            // console.log(compras);
                                            compras.forEach(buy => {
                                                tabla += `<tr>
                                                            <td>${cont}</td>
                                                            <td>${products[buy.product_id -1]['name_product']}</td>
                                                            <td>${products[buy.product_id -1]['price']}</td>
                                                            <td>${products[buy.product_id -1]['impuesto']}</td>
                                                        </tr>`;
                                                   cont++;                             
                                            });         
                                                        
                                            tabla +=   `</tbody>
                                                        <tfoot>
                                                            <tr>
                                                            <th></th>
                                                            <th></th>
                                                            <th>Total Productos</th>
                                                            <th>$${lista.total_sin_impuesto}</th>
                                                        </tr>
                                                        <tr>
                                                            <th></th>
                                                            <th></th>
                                                            <th>Total Impuesto</th>
                                                            <th>$${lista.total_de_impuesto}</th>
                                                        </tr>
                                                        <tr>
                                                            <th></th>
                                                            <th></th>
                                                            <th>Total Factura</th>
                                                            <th>$${lista.total_a_pagar}</th>
                                                        </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            
                                                <div class="cond row">
                                                    <div class="col-12 mt-3">
                                                        <h4>Condiciones y formas de pago</h4>
                                                        <p>El pago se debe realizar en un plazo de 15 dias.</p>
                                                        <p>
                                                        Banco Banreserva
                                                        <br />
                                                        IBAN: DO XX 0075 XXXX XX XX XXXX XXXX
                                                        <br />
                                                        Código SWIFT: BPDODOSXXXX
                                                        </p>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>  
                                </div>`;
                        // console.log(JSON.parse(lista.products));               
                    });       
                    $('#demo').html(tabla);

                } else if(response['state'] == false){
                    Swal.fire({
                    title: '*'+ response['message'],
                    text: '',
                    icon: 'error',
                    showConfirmButton: false
                    });
                }
                
            },
            error: function(response){
                console.log("error");
                console.log(response);
              
            }
        });
        }
    });

</script>
@endsection
