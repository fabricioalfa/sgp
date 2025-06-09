<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"></head>
<body>
  <h2>Restablecer tu contraseña</h2>
  <p>Para elegir una nueva contraseña, haz clic en el botón:</p>
  <a href="{{ url('/password/restablecer?token='.$token.'&email='.urlencode($email)) }}"
     style="display:inline-block;padding:10px 20px;background:#E9A209;color:#fff;border-radius:5px;text-decoration:none">
    Restablecer contraseña
  </a>
  <p>Si no solicitaste este correo, puedes ignorarlo.</p>
</body>
</html>
