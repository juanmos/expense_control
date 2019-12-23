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
            <th>Total</th>     
        </tr>
    </thead>
    <tbody id="entrydata">
        @foreach ($compras as $compra)
            <tr>
                <td>{{$compra->fecha}}</td>
                <td>{{$compra->cliente->cliente->razon_social}}</td>
                <td>{{$compra->cliente->cliente->nombre_comercial}}</td>
                <td>{{$compra->cliente->cliente->ruc}}</td>
                <td>{{$compra->factura_numero}}</td>
                <td>{{$compra->claveAcceso}}</td>
                <td>
                    {{array_reduce($compra->impuestos,function($carry,$item){
                        if($item['valorPorcentaje']>0)
                            return $carry + $item['baseImponible'];
                        else
                            return $carry;
                    })}}
                </td>
                <td>
                    {{array_reduce($compra->impuestos,function($carry,$item){
                        if($item['valorPorcentaje']==0)
                            return $carry + $item['baseImponible'];
                        else
                            return $carry;
                    })}}
                </td>
                <td>{{$compra->totalDescuento}}</td>
                <td>
                    {{array_reduce($compra->impuestos,function($carry,$item){
                        
                        return $carry + $item['valor'];
                        
                    })}}
                </td>
                <td>{{$compra->propina}}</td>
                <td>{{$compra->total}}</td>
            </tr>
        @endforeach
        @foreach ($documentos as $compra)
            <tr>
                <td>{{$compra->fecha}}</td>
                <td>{{$compra->cliente->razon_social}}</td>
                <td>{{$compra->cliente->nombre_comercial}}</td>
                <td>{{$compra->cliente->ruc}}</td>
                <td>Documento fisico</td>
                <td>Documento fisico</td>
                <td>{{$compra->subtotal}}</td>
                <td>0</td>
                <td>0</td>
                <td>{{$compra->iva}}</td>
                <td>{{$compra->propina}}</td>
                <td>{{$compra->total}}</td>
            </tr>
        @endforeach
    </tbody>
</table>