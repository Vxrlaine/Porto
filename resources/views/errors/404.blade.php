<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Instrument Sans', sans-serif;
            background: #FDFDFC;
            color: #1b1b18;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 2rem;
        }
        .container {
            text-align: center;
            max-width: 600px;
        }
        .error-code {
            font-family: 'Anton', sans-serif;
            font-size: 8rem;
            color: #0d328f;
            line-height: 1;
            margin-bottom: 1rem;
        }
        .error-title {
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: #1b1b18;
        }
        .error-message {
            font-size: 1.1rem;
            color: #666;
            margin-bottom: 2rem;
            line-height: 1.6;
        }
        .btn {
            display: inline-block;
            background: #0d328f;
            color: white;
            padding: 1rem 2.5rem;
            border-radius: 2.5rem;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 8px 25px rgba(13, 50, 143, 0.4);
        }
        .btn:hover {
            background: #0a256b;
            transform: translateY(-3px);
            box-shadow: 0 12px 35px rgba(13, 50, 143, 0.5);
        }
        @media (max-width: 768px) {
            .error-code {
                font-size: 5rem;
            }
            .error-title {
                font-size: 1.5rem;
            }
            .error-message {
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="error-code">404</div>
        <h1 class="error-title">Page Not Found</h1>
        <p class="error-message">
            Oops! The page you're looking for doesn't exist. It might have been moved or deleted.
        </p>
        <a href="{{ url('/') }}" class="btn">Go Back Home</a>
    </div>
</body>
</html>
