<!DOCTYPE html>
<html>
  <head>
    <title>Envío código de seguridad</title>
    <style>
      body {
        font-family: Arial, Helvetica, sans-serif;
      }
      .card {
        min-height: 80%;
        margin: 0 auto;
        border-radius: 10px;
        overflow: hidden;
        background-color: #ffffff;
        color: #000000;
      }
      .card-header {
        background-color: #eff3f4;
        padding: 20px;
        border-radius: 10px 10px 0 0;
      }
      .card-body {
        padding: 20px;
        text-align: justify;
      }
      .card-body img {
        max-height: 167px;
        font-size: 12px;
      }
      .card-footer {
        text-align: center;
        font-size: 8px;
        margin-top: 20px;
        color: gray;
        margin: 20px;
        line-height: 100%;
      }
      .btn {
        background-color: #581845;
        border: none;
        color: #ffffff;
        padding: 10px 20px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 4px 2px;
        cursor: pointer;
        border-radius: 5px;
      }
      .btn:hover {
        background-color: #ff9f4d;
        color: white;
      }
      .note {
        font-size: 15px;
        text-align: center;
        margin: 2px;
      }
    </style>
  </head>

  <body>
    <div class="card">
      <div class="card-header">
        <!-- <img src="https://files-accl.zohoexternal.com/public/workdrive-external/download/sjistfa38b6412a82447c8bf6dc260f5414f8?x-cli-msg=%7B%22isFileOwner%22%3Afalse%2C%22version%22%3A%221.0%22%7D" alt="Logo" title="LogoAA" width="200"/> -->
      </div>
      <div class="card-body">
        <p>Hola,</p>
        <p>A continuación se ha generado un código de seguridad para finalizar su pago correctamente.</p>
        <p>Por favor dar click en "Finalizar pago" e ingresa el código recibido.</p>
      </div>
      <div class="note">
        <p>Código de seguridad:</p>
        <h3>{{ $code->code }}</h3>
        <a href="" target="_blank" class="btn">Finalizar pago</a>
        <p>Por su seguridad recuerde no compartirlo con nadie.</p>
        <p>Este códgio expirará en 10 minutos.</p>
      </div>
      <div class="card-footer">
        <p>Si usted no ha solicitado la generación de este código, omita este mensaje y comuníquese con el administrador.</p>
        <p>Este correo y sus anexos son confidenciales y están protegidos por derechos de autor, están dirigidos única y exclusivamente para uso de el(los) destinatario(s).</p>
        <p>Si usted por error lo ha recibido por favor notifíquelo inmediatamente al correo info@albertoalvarez.com y destrúyalo de su sistema. No debe copiar, ni imprimir, </p>
        <p>ni distribuir este correo o sus anexos, ni usarlos para propósito alguno ni dar a conocer su contenido a persona alguna. Las opiniones, conclusiones y otra información </p>
        <p>contenida en este correo no relacionadas con el cumplimiento del objetivo del Sistema Matchgénica, deben entenderse como personales y de ninguna manera son avaladas por el sistema</p>
      </div>
    </div>
  </body>
</html>
