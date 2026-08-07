<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mensaje de contacto de {{ $nombre }}</title>
</head>
<body style="margin:0;padding:0;background-color:#f3f4f6;font-family:Arial,Helvetica,sans-serif;">
    <div style="max-width:600px;margin:0 auto;padding:24px 16px;">
        <div style="background:#ffffff;border-radius:12px;border:1px solid #e5e7eb;overflow:hidden;">
            <div style="background:#0ea5e9;padding:24px 32px;color:#ffffff;">
                <h1 style="margin:0;font-size:22px;font-weight:bold;">Nuevo mensaje de contacto</h1>
            </div>
            <div style="padding:32px;">
                <table role="presentation" style="width:100%;border-collapse:collapse;">
                    <tr>
                        <td style="padding:8px 0;color:#6b7280;font-size:13px;text-transform:uppercase;letter-spacing:0.05em;font-weight:bold;width:110px;">Nombre</td>
                        <td style="padding:8px 0;color:#111827;font-size:15px;">{{ $nombre }}</td>
                    </tr>
                    <tr>
                        <td style="padding:8px 0;color:#6b7280;font-size:13px;text-transform:uppercase;letter-spacing:0.05em;font-weight:bold;">Email</td>
                        <td style="padding:8px 0;color:#111827;font-size:15px;">
                            <a href="mailto:{{ $email }}" style="color:#0284c7;text-decoration:none;">{{ $email }}</a>
                        </td>
                    </tr>
                    @if($telefono)
                    <tr>
                        <td style="padding:8px 0;color:#6b7280;font-size:13px;text-transform:uppercase;letter-spacing:0.05em;font-weight:bold;">Teléfono</td>
                        <td style="padding:8px 0;color:#111827;font-size:15px;">{{ $telefono }}</td>
                    </tr>
                    @endif
                </table>

                <div style="margin-top:24px;padding-top:24px;border-top:1px solid #e5e7eb;">
                    <p style="margin:0 0 8px;color:#6b7280;font-size:13px;text-transform:uppercase;letter-spacing:0.05em;font-weight:bold;">Mensaje</p>
                    <p style="margin:0;color:#111827;font-size:15px;line-height:1.6;white-space:pre-line;">{{ $mensaje }}</p>
                </div>
            </div>
        </div>
        <p style="text-align:center;color:#9ca3af;font-size:12px;margin-top:16px;">Respondé directamente a este mensaje para contactar a {{ $nombre }}.</p>
    </div>
</body>
</html>
