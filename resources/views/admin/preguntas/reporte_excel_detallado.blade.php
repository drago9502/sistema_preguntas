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
    @forelse ($preguntas as $pregunta)
         <table style="width: 100%" class="tablas">
        <thead>
            <tr>
                <th style=" border: 1px solid black; border-collapse: collapse;background-color: yellow ; color: black" colspan="3">
                    Pregunta: {{$pregunta->numero}}-{{$pregunta->pregunta}}
                </th>
                <th style=" border: 1px solid black; border-collapse: collapse;background-color: yellow ; color: black">
                    Participaciones: 
                </th>
                <th style=" border: 1px solid black; border-collapse: collapse;background-color: yellow ; color: black">
                    {{$pregunta->participaciones}}
                </th>
            </tr>
            <tr>
                <th style=" border: 1px solid black; border-collapse: collapse;background-color: lightgray ; color: black">
                    #
                </th>
                <th style=" border: 1px solid black; border-collapse: collapse;background-color: lightgray ; color: black">
                    Nombre usuario
                </th>
                <th style=" border: 1px solid black; border-collapse: collapse;background-color: lightgray ; color: black">
                    Correo
                </th>
                 <th style=" border: 1px solid black; border-collapse: collapse;background-color: lightgray ; color: black">
                    Modalidad
                </th>
                <th style=" border: 1px solid black; border-collapse: collapse;background-color: lightgray ; color: black">
                    Fecha y hora envió
                </th>
                <th style=" border: 1px solid black; border-collapse: collapse;background-color: lightgray ; color: black">
                    Respuesta
                </th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pregunta->respuestas as $respuesta)
                <tr>
                    <td style=" border: 1px solid black; border-collapse: collapse;">
                        {{ $loop->iteration }}
                    </td>
                    <td style=" border: 1px solid black; border-collapse: collapse;">
                        {{ $respuesta->asistente }}
                    </td>
                    <td style=" border: 1px solid black; border-collapse: collapse;">
                        {{ $respuesta->correo }}
                    </td>
                    <td style=" border: 1px solid black; border-collapse: collapse;">
                        {{ $respuesta->modalidad }}
                    </td>
                     <td style=" border: 1px solid black; border-collapse: collapse;">
                        {{ $respuesta->created_at }}
                    </td>
                    <td style=" border: 1px solid black; border-collapse: collapse;">
                        {{ $respuesta->respuesta }}
                    </td>
                </tr>

            @empty
            @endforelse


        </tbody>
    </table>
    @empty
        
    @endforelse
   





</body>

</html>
