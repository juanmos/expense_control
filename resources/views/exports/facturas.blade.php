<table  id="tableFisicas" class="table table-hover"  style="width:100%">
    <thead>
        <tr>
            <th>Fecha</th>
            <th>Razón social</th>  
            <th>Nombre comercial</th>
            <th>RUC</th>
            <th>Factura</th>
            <th>Clave acceso</th>
            <th>Subtotal</th>    
            <th>Subtotal 0</th>    
            <th>Descuento</th>    
            <th>IVA</th>  
            <th>Propina</th>    
            <th>Servicio</th>    
            <th>Total</th>     
        </tr>
    </thead>
    <tbody id="entrydata">
        @foreach ($facturas as $factura)
            <tr>
                <td>{{$factura->fecha}}</td>
                <td>{{$factura->cliente->cliente->razon_social}}</td>
                <td>{{$factura->cliente->cliente->nombre_comercial}}</td>
                <td>{{$factura->cliente->cliente->ruc}}</td>
                <td>{{$factura->factura_numero}}</td>
                <td>{{$factura->clave}}</td>
                <td>{{$factura->subtotal}}</td>
                <td>{{$factura->subtotal0}}</td>
                <td>{{$factura->descuento}}</td>
                <td>{{$factura->iva}}</td>
                <td>{{$factura->propina}}</td>
                <td>{{$factura->servicio}}</td>
                <td>{{$factura->total}}</td>
            </tr>
        @endforeach
        @foreach ($documentos as $factura)
            <tr>
                <td>{{$factura->fecha}}</td>
                <td>{{$factura->cliente->razon_social}}</td>
                <td>{{$factura->cliente->nombre_comercial}}</td>
                <td>{{$factura->cliente->ruc}}</td>
                <td>Documento fisico</td>
                <td>Documento fisico</td>
                <td>{{$factura->subtotal}}</td>
                <td>0</td>
                <td>0</td>
                <td>{{$factura->iva}}</td>
                <td>{{$factura->propina}}</td>
                <td>{{$factura->servicio}}</td>
                <td>{{$factura->total}}</td>
            </tr>
        @endforeach
    </tbody>
</table>