{{-- 10 columnas --}}
<table border="1" style="border-collapse:collapse;">
    <thead>
        <tr>
            <th colspan="10"></th>
        </tr>
        <tr>
            <th colspan="6"
                style="background:#215967; color:white; font-weight:bold; text-align:center; vertical-align:middle;"
                height="100px">
                DIRECCIÓN DE ACREDITACIÓN Y FORTALECIMIENTO DE LA OFERTA <br>
                FORMULARIO DE ASIGNACIÓN DE CÓDIGOS A ESTUDIANES <br>
                - CAPACITACIÓN CONTINUA - Formulario f1
            </th>
            <th colspan="4"></th>
        </tr>
        <tr>
            <th colspan="10"></th>
        </tr>
        <tr>
            <th colspan="2"></th>
            <th style="text-align:center; vertical-align:middle;">Identificación del Curso</th>
            <th style="text-align:center; vertical-align:middle;" colspan="2">{{ $course->name }}</th>
            <th colspan="4"></th>
        </tr>
        <tr>
            <th colspan="5"></th>
            <th colspan="1" style="background:#215967; color:white; text-align:center; vertical-align:middle;">Número
            </th>
            <th colspan="4"></th>
        </tr>
        <tr>
            <th></th>
            <th style="background:#215967; color:white; text-align:center; vertical-align:middle;">NOMBRE DEL INSTITUTO
            </th>
            <th style="text-align:center; vertical-align:middle;">INSTITUTO SUPERIOR TECNOLÓGICO SUCÚA</th>
            <th style="text-align:center; vertical-align:middle;" rowspan="3" width="170px" height="40px">
                {{-- LOGO DEL ISTS --}}</th>
            <th style="background:#215967; color:white; text-align:center; vertical-align:middle;">Estudiantes que
                Aprobaron</th>
            <th style="font-weight:bold; text-align:center; vertical-align:middle;">{{ $total_aproveds }}</th>
            <th colspan="4"></th>
        </tr>
        <tr>
            <th></th>
            <th style="background:#215967; color:white; text-align:center; vertical-align:middle;">NOMBRE DEL CURSO</th>
            <th style="text-align:center; vertical-align:middle;">{{ $course->name }}</th>
            <th style="background:#215967; color:white; text-align:center; vertical-align:middle;">Estudiantes que
                Reprobaron</th>
            <th style="font-weight:bold; text-align:center; vertical-align:middle;">{{ $total_desaproveds }}</th>
            <th colspan="4"></th>
        </tr>
        <tr>
            <th></th>
            <th style="background:#215967; color:white; text-align:center; vertical-align:middle;">ÁREA DEL CURSO</th>
            <th style="text-align:center; vertical-align:middle;">TECNOLOGÍAS DE LA INFORMACIÓN Y COMUNICACIÓN</th>
            <th style="background:#215967; color:white; text-align:center; vertical-align:middle;">TOTAL</th>
            <th style="text-align:center; font-weight:bold; vertical-align:middle;">{{ $total_inscriptions }}</th>
            <th style="text-align:center; vertical-align:middle;" colspan="4"></th>
        </tr>
        <tr>
            <th></th>
            <th style="background:#215967; color:white; text-align:center; vertical-align:middle;">DOCENTE</th>
            <th style="text-align:center; vertical-align:middle;">{{ $teacher->name }} {{ $teacher->lastname }}</th>
            <th colspan="8"></th>
        </tr>
        <tr>
            <th></th>
            <th style="background:#215967; color:white; text-align:center; vertical-align:middle;">FECHA DE INICIO</th>
            <th style="text-align:center; vertical-align:middle;">{{ $course->date_start }}</th>
            <th colspan="8"></th>
        </tr>
        <tr>
            <th></th>
            <th style="background:#215967; color:white; text-align:center; vertical-align:middle;">FECHA DE FIN</th>
            <th style="text-align:center; vertical-align:middle;">{{ $course->date_end }}</th>
            <th colspan="8"></th>
        </tr>
        <tr>
            <th colspan="10"></th>
        </tr>
        <tr>
            <th style="text-align:center; vertical-align:middle; background:#215967; color:white; text-align:center;">
                No.</th>
            <th width="200px"
                style="background:#215967; color:white; text-align:center; text-align:center; vertical-align:middle;">
                Nombres</th>
            <th width="250px"
                style="background:#215967; color:white; text-align:center; text-align:center; vertical-align:middle;">
                Apellidos</th>
            <th width="200px"
                style="background:#215967; color:white; text-align:center; text-align:center; vertical-align:middle;">
                Número de Cédula</th>
            <th width="180px"
                style="background:#215967; color:white; text-align:center; text-align:center; vertical-align:middle;">
                Autodefinición</th>
            <th width="200px"
                style="background:#215967; color:white; text-align:center; text-align:center; vertical-align:middle;">
                Posee alguna Discapacidad</th>
            <th width="150px"
                style="background:#215967; color:white; text-align:center; text-align:center; vertical-align:middle;">
                Género</th>
            <th width="70px"
                style="background:#215967; color:white; text-align:center; text-align:center; vertical-align:middle;">
                Edad</th>
            <th width="200px"
                style="background:#215967; color:white; text-align:center; text-align:center; vertical-align:middle;">
                Correo Electrónico</th>
            <th width="70px"
                style="background:#215967; color:white; text-align:center; text-align:center; vertical-align:middle;">
                Código</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($inscriptions as $index => $inscription)
            <tr>
                <td style="text-align:center; vertical-align:middle;">{{ $index + 1 }}</td>
                <td style="text-align:center; vertical-align:middle;">{{ $inscription->student->name }}</td>
                <td style="text-align:center; vertical-align:middle;">{{ $inscription->student->lastname }}</td>
                <td style="text-align:center; vertical-align:middle;">{{ $inscription->student->dni }}</td>
                <td style="text-align:center; vertical-align:middle;">Mestizo</td>
                <td style="text-align:center; vertical-align:middle;">No</td>
                <td style="text-align:center; vertical-align:middle;">{{ $inscription->student->sex }}</td>
                <td style="text-align:center; vertical-align:middle;"></td>
                <td style="text-align:center; vertical-align:middle;">{{ $inscription->student->email }}</td>
                <td style="text-align:center; vertical-align:middle;"></td>
            </tr>
        @endforeach
    </tbody>
</table>
