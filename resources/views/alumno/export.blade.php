<table>
    <thead>
    <tr>
        <th>Nombre</th>
        <th>Identificación</th>
        <th>Codigo</th>
        <th>Foto</th>
    </tr>
    </thead>
    <tbody>
    @foreach($usuarios as $user)
        <tr>
            <td>{{ $user->full_name }}</td>
            <td>{{ $user->cedula }}</td>
            <td>{{ $user->codigo }}</td>
            <td>{{ $user->foto }}</td>
        </tr>
    @endforeach
    </tbody>
</table>