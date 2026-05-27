<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nueva Solicitud de Reserva</title>
</head>
<body style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f3f4f6; padding: 20px; color: #1f2937;">
    <table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="background-color: #ffffff; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); overflow: hidden; border: 1px solid #e5e7eb;">
        <!-- Header -->
        <tr>
            <td style="background-color: #1e3a8a; padding: 30px; text-align: center;">
                <h1 style="color: #ffffff; margin: 0; font-size: 24px; font-weight: 700;">Nueva Solicitud de Reserva</h1>
                <p style="color: #93c5fd; margin: 5px 0 0 0; font-size: 14px;">Gestión de Recursos Universitarios</p>
            </td>
        </tr>
        
        <!-- Content -->
        <tr>
            <td style="padding: 30px;">
                <p style="font-size: 16px; line-height: 1.5; margin-top: 0;">Estimado Docente,</p>
                <p style="font-size: 16px; line-height: 1.5;">Se ha registrado una nueva solicitud de reserva de recurso que requiere de su revisión y aprobación. A continuación se presentan los detalles:</p>
                
                <table width="100%" style="border-collapse: collapse; margin: 20px 0;">
                    <tr>
                        <td width="35%" style="padding: 10px; border-bottom: 1px solid #f3f4f6; font-weight: bold; color: #4b5563;">Estudiante:</td>
                        <td style="padding: 10px; border-bottom: 1px solid #f3f4f6;">{{ $reserva->usuario->nombre_completo }} ({{ $reserva->usuario->correo }})</td>
                    </tr>
                    <tr>
                        <td style="padding: 10px; border-bottom: 1px solid #f3f4f6; font-weight: bold; color: #4b5563;">Recurso:</td>
                        <td style="padding: 10px; border-bottom: 1px solid #f3f4f6;">{{ $reserva->recurso->nombre }} ({{ $reserva->recurso->tipo_texto }})</td>
                    </tr>
                    <tr>
                        <td style="padding: 10px; border-bottom: 1px solid #f3f4f6; font-weight: bold; color: #4b5563;">Ubicación:</td>
                        <td style="padding: 10px; border-bottom: 1px solid #f3f4f6;">{{ $reserva->recurso->ubicacion }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 10px; border-bottom: 1px solid #f3f4f6; font-weight: bold; color: #4b5563;">Fecha:</td>
                        <td style="padding: 10px; border-bottom: 1px solid #f3f4f6;">{{ \Carbon\Carbon::parse($reserva->fecha)->format('d/m/Y') }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 10px; border-bottom: 1px solid #f3f4f6; font-weight: bold; color: #4b5563;">Horario:</td>
                        <td style="padding: 10px; border-bottom: 1px solid #f3f4f6;">{{ $reserva->horario }}</td>
                    </tr>
                    @if($reserva->motivo)
                    <tr>
                        <td style="padding: 10px; border-bottom: 1px solid #f3f4f6; font-weight: bold; color: #4b5563;">Motivo:</td>
                        <td style="padding: 10px; border-bottom: 1px solid #f3f4f6;">{{ $reserva->motivo }}</td>
                    </tr>
                    @endif
                </table>
                
                <p style="font-size: 16px; line-height: 1.5; margin-bottom: 25px;">Por favor, ingrese al sistema para responder a esta solicitud aprobándola o rechazándola.</p>
                
                <div style="text-align: center;">
                    <a href="{{ route('login') }}" style="background-color: #2563eb; color: #ffffff; padding: 12px 24px; text-decoration: none; border-radius: 6px; font-weight: bold; display: inline-block;">Acceder al Sistema</a>
                </div>
            </td>
        </tr>
        
        <!-- Footer -->
        <tr>
            <td style="background-color: #f9fafb; padding: 20px; text-align: center; border-top: 1px solid #e5e7eb; font-size: 12px; color: #6b7280;">
                <p style="margin: 0;">Este es un correo automático. Por favor no responda a este mensaje.</p>
                <p style="margin: 5px 0 0 0;">&copy; {{ date('Y') }} Sistema de Gestión de Recursos Universitarios</p>
            </td>
        </tr>
    </table>
</body>
</html>
