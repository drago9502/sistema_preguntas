<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte {{ $evento->nombre }}</title>
    <style>

    </style>
</head>

<body>
    <h1 style="text-align: center">Reporte {{ $evento->nombre }} Registrados: {{$registrados}}</h1>

    {{-- egresos --}}
    <table style="width: 100%" class="tablas">
        <thead>
            <tr>
                <th style=" border: 1px solid black; border-collapse: collapse;">
                    Número
                </th>
                <th style=" border: 1px solid black; border-collapse: collapse;">
                    Pregunta
                </th>
                <th style=" border: 1px solid black; border-collapse: collapse;">
                    Opciones
                </th>
                <th style=" border: 1px solid black; border-collapse: collapse;">
                    Estadisticas
                </th>
            </tr>
        </thead>
        <tbody>
            @forelse ($preguntas as $pregunta)
                <tr>
                    <td style=" border: 1px solid black; border-collapse: collapse;">
                        {{ $pregunta->numero }}
                    </td>
                    <td style=" border: 1px solid black; border-collapse: collapse;">
                        {{ $pregunta->pregunta }}
                    </td>
                    <td style=" border: 1px solid black; border-collapse: collapse;">
                        @forelse ($pregunta->opciones as $opcion)
                            {{$opcion->numero_respuesta}}-{{$opcion->respuesta}} Conteo: {{$opcion->participaciones}}<br>
                        @empty
                            
                        @endforelse
                    </td>
                    <td style=" border: 1px solid black; border-collapse: collapse;">
                       Participaciones: {{ $pregunta->participaciones }}
                    </td>
                </tr>

            @empty
            @endforelse


        </tbody>
    </table>





</body>

</html>
