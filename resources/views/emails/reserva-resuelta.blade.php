<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resolución de Solicitud de Reserva</title>
</head>
<body style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f3f4f6; padding: 20px; color: #1f2937;">
    <table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="background-color: #ffffff; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); overflow: hidden; border: 1px solid #e5e7eb;">
        <!-- Header -->
        <tr>
            <td style="background-color: {{ $reserva->estado === 'aprobada' ? '#10b981' : '#ef4444' }}; padding: 30px; text-align: center;">
                <h1 style="color: #ffffff; margin: 0; font-size: 24px; font-weight: 700;">
                    Solicitud {{ ucfirst($reserva->estado_texto) }}
                </h1>
                <p style="color: #ffffff; margin: 5px 0 0 0; font-size: 14px; opacity: 0.9;">Gestión de Recursos Universitarios</p>
            </td>
        </tr>
        
        <!-- Content -->
        <tr>
            <td style="padding: 30px;">
                <p style="font-size: 16px; line-height: 1.5; margin-top: 0;">Hola {{ $reserva->usuario->nombre }},</p>
                <p style="font-size: 16px; line-height: 1.5;">
                    Tu solicitud de reserva de recurso ha sido revisada y resuelta por el docente <strong>{{ $docente->nombre_completo }}</strong>.
                </p>
                
                <div style="background-color: {{ $reserva->estado === 'aprobada' ? '#f0fdf4' : '#fef2f2' }}; border-left: 4px solid {{ $reserva->estado === 'aprobada' ? '#10b981' : '#ef4444' }}; padding: 15px; margin: 20px 0; border-radius: 4px;">
                    <p style="margin: 0; font-weight: bold; color: {{ $reserva->estado === 'aprobada' ? '#15803d' : '#991b1b' }};">
                        Estado: {{ $reserva->estado_texto }}
                    </p>
                </div>

                <h3 style="color: #374151; font-size: 16px; margin: 20px 0 10px 0; border-bottom: 2px solid #f3f4f6; padding-bottom: 5px;">Detalles de la Reserva:</h3>
                
                <table width="100%" style="border-collapse: collapse; margin-bottom: 20px;">
                    <tr>
                        <td width="35%" style="padding: 8px 0; border-bottom: 1px solid #f3f4f6; font-weight: bold; color: #4b5563;">Recurso:</td>
                        <td style="padding: 8px 0; border-bottom: 1px solid #f3f4f6;">{{ $reserva->recurso->nombre }} ({{ $reserva->recurso->tipo_texto }})</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; border-bottom: 1px solid #f3f4f6; font-weight: bold; color: #4b5563;">Ubicación:</td>
                        <td style="padding: 8px 0; border-bottom: 1px solid #f3f4f6;">{{ $reserva->recurso->ubicacion }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; border-bottom: 1px solid #f3f4f6; font-weight: bold; color: #4b5563;">Fecha:</td>
                        <td style="padding: 8px 0; border-bottom: 1px solid #f3f4f6;">{{ \Carbon\Carbon::parse($reserva->fecha)->format('d/m/Y') }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; border-bottom: 1px solid #f3f4f6; font-weight: bold; color: #4b5563;">Horario:</td>
                        <td style="padding: 8px 0; border-bottom: 1px solid #f3f4f6;">{{ $reserva->horario }}</td>
                    </tr>
                </table>
                
                <div style="text-align: center; margin-top: 30px;">
                    <a href="{{ route('reservas.mis-reservas') }}" style="background-color: #2563eb; color: #ffffff; padding: 12px 24px; text-decoration: none; border-radius: 6px; font-weight: bold; display: inline-block;">Ver Mis Reservas</a>
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
