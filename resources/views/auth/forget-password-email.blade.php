<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
</head>
<body>
    <p>Hello,</p>
    
    <p>We received a request to reset your password. Please click the button below to reset your password.</p>
    
    <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="btn btn-primary">
        <tbody>
            <tr>
                <td align="center">
                    <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                        <tbody>
                            <tr>
                                <td>
                                    <a href="{{ $link }}" target="_blank">Reset Password</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
    
    <p>If you didn't request a password reset, you can safely ignore this email.</p>
    
    <p>Thank you,</p>
    <p>Your Application Team</p>
</body>
</html>
