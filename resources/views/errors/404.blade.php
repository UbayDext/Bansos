<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Halaman Tidak Ditemukan</title>
    <style>
        body {
            font-family: sans-serif;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #2d3748; /* Warna latar belakang gelap */
            color: #e2e8f0; /* Warna teks terang */
        }
        .container {
            text-align: center;
            padding: 20px;
            border-radius: 8px;
        }
        .code {
            font-size: 8rem;
            font-weight: bold;
            color: #f6ad55; /* Warna penekanan */
        }
        .message {
            font-size: 1.5rem;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="code">
            {{ $exception->getStatusCode() }}
        </div>

        <div class="message">
            {{ $exception->getMessage() ?: 'Halaman tidak ditemukan.' }}
        </div>

        <p><a href="{{ url('/') }}" style="color: #63b3ed; text-decoration: none;">Kembali ke Beranda</a></p>
    </div>
</body>
</html>
