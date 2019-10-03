<table>
    <thead>
    <tr>
        <th>Nombre</th>
        <th>Identificación</th>
        <th>Paralelo</th>
        <th>Año lectivo</th>
        <th>Codigo</th>
        <th>Foto</th>
    </tr>
    </thead>
    <tbody>
    @foreach($usuarios as $user)
        <tr>
            <td>{{ $user->full_name }}</td>
            <td>{{ $user->cedula }}</td>
            <td>{{ $user->alumno->paralelo }}</td>
            <td>{{ $user->alumno->ano_lectivo }}</td>
            <td>{{ ($user->tarjetas->count()>0)?$user->tarjetas[0]->codigo:'Sin codigo' }}</td>
            <td>{{ $user->foto }}</td>
        </tr>
    @endforeach
    </tbody>
</table>