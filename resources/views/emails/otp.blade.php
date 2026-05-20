<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kode OTP Bursa Tenaga Kerja</title>
</head>
<body style="margin: 0; padding: 0; background-color: #FEF9F2; font-family: Arial, sans-serif;">

    <div style="max-width: 560px; margin: 40px auto; background-color: #ffffff; border-radius: 16px; padding: 32px; box-shadow: 0 8px 30px rgba(15, 40, 84, 0.08);">

        <h2 style="margin: 0 0 12px; color: #0F2854;">
            Bursa Tenaga Kerja
        </h2>

        <p style="color: #64748B; font-size: 14px; line-height: 1.7;">
            Gunakan kode OTP berikut untuk proses {{ $purpose }} akun Anda.
        </p>

        <div style="margin: 28px 0; padding: 20px; background-color: #F8F3EC; border: 1px solid #BDE8F5; border-radius: 12px; text-align: center;">

            <p style="margin: 0 0 10px; color: #64748B; font-size: 13px;">
                Kode OTP Anda
            </p>

            <div style="font-size: 34px; font-weight: 700; letter-spacing: 8px; color: #1A4885;">
                {{ $otpCode }}
            </div>

        </div>

        <p style="color: #64748B; font-size: 13px; line-height: 1.7;">
            Kode ini berlaku selama 5 menit. Jangan bagikan kode ini kepada siapa pun.
        </p>

        <p style="color: #94A3B8; font-size: 12px; margin-top: 28px;">
            Jika Anda tidak merasa melakukan permintaan ini, abaikan email ini.
        </p>

    </div>

</body>
</html>