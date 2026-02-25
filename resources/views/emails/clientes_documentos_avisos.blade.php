<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>{{env('APP_NAME')}} - Aviso de Vencimento de Documento</title>
    </head>
    <body style="font-family: Arial, sans-serif; color: #333;">
        <table width="100%" cellpadding="10">
            <tr>
                <td>
                    <img src="https://sistema.gruposrmais.com.br/build/assets/images/image_logo_email.png" alt="Logo" height="90">
                </td>
            </tr>
            <tr>
                <td>
                    <h2 style="color: #007BFF;">Aviso de Vencimento de Documento</h2>
                    <p>Olá <strong>{{ $cliente_name }}</strong>,</p>
                    <p>Esperamos que esteja bem!</p>
                    <p>
                        Informamos que o documento <strong>{{ $documento_name }}</strong>,
                        emitido em <strong>{{ \Carbon\Carbon::parse($data_emissao)->format('d/m/Y') }}</strong>,
                        possui vencimento em <strong>{{ \Carbon\Carbon::parse($data_vencimento)->format('d/m/Y') }}</strong>.
                    </p>
                    <p>
                        Este é um aviso automático enviado em
                        <strong>{{ \Carbon\Carbon::parse($hoje)->format('d/m/Y') }}</strong>
                        para lembrá-lo sobre o prazo de vencimento.
                    </p>
                    <p>
                        Recomendamos que verifique sua situação e tome as providências necessárias
                        antes do vencimento para evitar pendências.
                    </p>
                    <br>
                    <p>
                        Atenciosamente,<br>
                        <strong>Equipe Grupo SR+</strong><br>
                        <small>Este é um e-mail automático, por favor não responda.</small>
                    </p>
                </td>
            </tr>
        </table>
    </body>
</html>
