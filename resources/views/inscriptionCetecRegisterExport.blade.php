{{-- 18 columnas --}}
<table border="1" style="border-collapse:collapse;">
    <thead>
        <tr>
            <th colspan="9" rowspan="3" height="45px">
                {{-- Logo de la SENECYT --}}
            </th>
            <th colspan="3" width="300px"
                style="text-align:center; vertical-align:middle; font-weight:bold; font-size:13rem;">INSTITUTO
                SUPERIOR
                TECNOLÓGICO SUCÚA</th>
            <th colspan="6" rowspan="3" width="350px">
                {{-- Logo del ISTS --}}
            </th>
        </tr>
        <tr>
            <th colspan="3" height="45px"
                style="color:red; text-align:center; font-weight:bold; vertical-align:middle; text-decoration:underline; font-size:11rem;">
                FORMULARIO:
                e1</th>
        </tr>
        <tr>
            <th colspan="3" height="45px"
                style="text-align:center; vertical-align:middle; font-weight:bold; font-size:13rem; font-style:italic;">
                REGISTRO DE PARTICIPANTES INSCRITOS Y
                MATRICULADOS</th>
        </tr>
        <tr>
            <th colspan="2" style="font-weight:bold; font-style:italic;">PROVINCIA:</th>
            <th colspan="8" width="80px">MORONA SANTIAGO</th>
            <th colspan="1" style="font-weight:bold; font-style:italic;">TIPO DE CURSO:</th>
            <th colspan="1">ADMINISTRATIVO:</th>
            <th colspan="1"></th>
            <th colspan="1">TECNICO:</th>
            <th colspan="1"></th>
            <th colspan="3"></th>
        </tr>
        <tr>
            <th colspan="2" style="font-weight:bold; font-style:italic;">CANTON:</th>
            <th colspan="8">SUCÚA</th>
            <th colspan="1" style="font-weight:bold; font-style:italic;">MODALIDAD DEL CURSO:</th>
            <th colspan="1">PRESENCIAL:</th>
            <th colspan="1"></th>
            <th colspan="1">VIRTUAL:</th>
            <th colspan="1"></th>
            <th colspan="3"></th>
        </tr>
        <tr>
            <th colspan="2" style="font-weight:bold; font-style:italic;">PARROQUIA:</th>
            <th colspan="8">SUCÚA</th>
            <th colspan="1" style="font-weight:bold; font-style:italic;">DURACIÓN DEL CURSO:</th>
            <th colspan="1">40 HORAS</th>
            <th colspan="1"></th>
            <th colspan="1"></th>
            <th colspan="1"></th>
            <th colspan="3"></th>
        </tr>
        <tr>
            <th colspan="2" style="font-weight:bold; font-style:italic;">LOCAL DONDE SE DICTA:</th>
            <th colspan="8">IST-SUCÚA</th>
            <th colspan="1" style="font-weight:bold; font-style:italic;">FECHA DE INICIACIÓN:</th>
            <th colspan="2"></th>
            <th colspan="5"></th>
        </tr>
        <tr>
            <th colspan="2" style="font-weight:bold; font-style:italic;">CONVENIO:</th>
            <th colspan="8"></th>
            <th colspan="1" style="font-weight:bold; font-style:italic;">FECHA PREVISTA DE FINALIZACIÓN:</th>
            <th colspan="2">{{ $course->date_end_str }}</th>
            <th colspan="2" style="font-weight:bold; font-style:italic;">HORARIO DEL CURSO:</th>
            <th colspan="3"></th>
        </tr>
        <tr>
            <th colspan="2" style="font-weight:bold; font-style:italic;">NOMBRE DEL CURSO:</th>
            <th colspan="8">{{ $course->name }}</th>
            <th colspan="1" style="font-weight:bold; font-style:italic;">FECHA REAL DE FINALIZACIÓN:</th>
            <th colspan="2">{{ $course->date_end_str }}</th>
            <th colspan="2" style="font-weight:bold; font-style:italic;">CÓDIGO DEL CURSO:</th>
            <th colspan="3"></th>
        </tr>
        <tr>
            <th colspan="18"></th>
        </tr>
        <tr>
            <th colspan="1" rowspan="3" style="font-weight:bold; font-style:italic;">Nº</th>
            <th colspan="1" rowspan="3" style="font-weight:bold; font-style:italic;">APELLIDOS Y NOMBRES</th>
            <th colspan="1" rowspan="3" style="font-weight:bold; font-style:italic;">DOCUMENTO DE IDENTIDAD</th>
            <th colspan="2" rowspan="2" style="font-weight:bold; font-style:italic;">SEXO</th>
            <th colspan="1" rowspan="3" style="font-weight:bold; font-style:italic;">EDAD / AÑOS</th>
            <th colspan="3" rowspan="2" style="font-weight:bold; font-style:italic;">NIVEL DE INSTRUCCIÓN</th>
            <th colspan="4" rowspan="1" style="font-weight:bold; font-style:italic;">DATOS DE LA EMPRESA</th>
            <th colspan="3" rowspan="1" style="font-weight:bold; font-style:italic;">DATOS DEL PARTICIPANTE</th>
            <th colspan="2" rowspan="2" style="font-weight:bold; font-style:italic;">RESULTADOS</th>
        </tr>
        <tr>
            <th rowspan="2" style="font-weight:bold; font-style:italic;">NOMBRE DE LA EMPRESA</th>
            <th rowspan="2" style="font-weight:bold; font-style:italic;">ACTIVIDAD DE LA EMPRESA</th>
            <th rowspan="2" style="font-weight:bold; font-style:italic;">DIRECCIÓN DE LA EMPRESA</th>
            <th rowspan="2" style="font-weight:bold; font-style:italic;">TELÉFONO</th>
            <th rowspan="2" style="font-weight:bold; font-style:italic;">DIRECCIÓN DOMICILIARIA</th>
            <th colspan="2" style="font-weight:bold; font-style:italic;">TELEFONOS</th>
        </tr>
        <tr>
            <th style="font-weight:bold; font-style:italic;">M</th>
            <th style="font-weight:bold; font-style:italic;">F</th>
            <th style="font-weight:bold; font-style:italic;">PRI</th>
            <th style="font-weight:bold; font-style:italic;">SEC</th>
            <th style="font-weight:bold; font-style:italic;">SUP</th>
            <th style="font-weight:bold; font-style:italic;">CELULAR</th>
            <th style="font-weight:bold; font-style:italic;">CONVEN</th>
            <th style="font-weight:bold; font-style:italic;">INSCRITO</th>
            <th style="font-weight:bold; font-style:italic;">MATRIC</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($inscriptions as $index => $inscription)
            <tr>
                <td style="text-align:center">{{ $index + 1 }}</td>
                <td style="text-align:center">{{ $inscription->student->lastname }} {{ $inscription->student->name }}
                </td>
                <td style="text-align:center">{{ $inscription->student->dni }}</td>
                <td style="text-align:center">{{ $inscription->student->sex == 'Masculino' ? 'X' : '' }}</td>
                <td style="text-align:center">{{ $inscription->student->sex != 'Masculino' ? 'X' : '' }}</td>
                <td style="text-align:center"></td>
                <td style="text-align:center">{{ $inscription->student->instruction == 'Primaria' ? 'X' : '' }}</td>
                <td style="text-align:center">
                    {{ $inscription->student->instruction == 'Secundaria' || $inscription->student->instruction == 'Tecnica' ? 'X' : '' }}
                </td>
                <td style="text-align:center">{{ $inscription->student->instruction == 'Superior' ? 'X' : '' }}</td>
                <td style="text-align:center">{{ $inscription->student->entity_name }}</td>
                <td style="text-align:center">{{ $inscription->student->entity_post }}</td>
                <td style="text-align:center">{{ $inscription->student->entity_address }}</td>
                <td style="text-align:center">{{ $inscription->student->entity_phone }}</td>
                <td style="text-align:center">{{ $inscription->student->address }}</td>
                <td style="text-align:center">{{ $inscription->student->cellphone }}</td>
                <td style="text-align:center">{{ $inscription->student->phone }}</td>
                <td style="text-align:center"></td>
                <td style="text-align:center">X</td>
            </tr>
        @endforeach
    </tbody>
</table>
