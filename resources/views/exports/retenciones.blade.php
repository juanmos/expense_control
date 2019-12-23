<table  id="tableFisicas" class="table table-hover"  style="width:100%">
    <thead>
        <tr>
            <th>Fecha</th>
            <th>Razón social</th>  
            <th>Nombre comercial</th>
            <th>RUC</th>
            <th>Numero</th>
            <th>Clave acceso</th>
            <th>Retencion IVA</th>    
            <th>Retencion Renta</th>       
        </tr>
    </thead>
    <tbody id="entrydata">
        @foreach ( $retenciones as $retencion)
            <tr>
                <td>{{$retencion->fecha}}</td>
                <td>{{$retencion->cliente->cliente->razon_social}}</td>
                <td>{{$retencion->cliente->cliente->nombre_comercial}}</td>
                <td>{{$retencion->cliente->cliente->ruc}}</td>
                <td>{{$retencion->factura_numero}}</td>
                <td>{{$retencion->claveAcceso}}</td>
                <td>
                    {{array_reduce($retencion->impuestos,function($carry,$item){
                        if($item['nombreImpuesto']=='IVA')
                            return $carry + $item['valor'];
                        else
                            return $carry;
                    })}}
                </td>
                <td>
                    {{array_reduce($retencion->impuestos,function($carry,$item){
                        if($item['nombreImpuesto']=='RENTA')
                            return $carry + $item['valor'];
                        else
                            return $carry;
                    })}}
                </td>
                
            </tr>
        @endforeach
        @foreach ($documentos as $retencion)
            <tr>
                <td>{{$retencion->fecha}}</td>
                <td>{{$retencion->cliente->razon_social}}</td>
                <td>{{$retencion->cliente->nombre_comercial}}</td>
                <td>{{$retencion->cliente->ruc}}</td>
                <td>Documento fisico</td>
                <td>Documento fisico</td>
                
                <td>{{$retencion->ret_iva}}</td>
                <td>{{$retencion->ret_renta}}</td>
            </tr>
        @endforeach
    </tbody>
</table>