<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Image Processor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .card {
            border-radius: 15px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
            border: none;
            margin-bottom: 25px;
        }

        .card-header {
            background-color: #6c5ce7;
            color: white;
            border-radius: 15px 15px 0 0 !important;
            padding: 15px 20px;
            font-weight: 600;
        }

        .btn-primary {
            background-color: #6c5ce7;
            border-color: #6c5ce7;
        }

        .btn-primary:hover {
            background-color: #5b4bc7;
            border-color: #5b4bc7;
        }

        .btn-success {
            background-color: #00b894;
            border-color: #00b894;
        }

        .btn-success:hover {
            background-color: #00a383;
            border-color: #00a383;
        }

        .img-preview {
            max-height: 300px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .filter-option {
            margin-bottom: 10px;
            cursor: pointer;
            transition: all 0.3s;
            border-radius: 10px;
            overflow: hidden;
            border: 3px solid transparent;
        }

        .filter-option:hover {
            transform: translateY(-5px);
        }

        .filter-option img {
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .filter-option.selected {
            border: 3px solid #6c5ce7;
        }

        .crop-container {
            max-height: 400px;
            margin-bottom: 20px;
        }

        .navbar {
            background-color: #6c5ce7;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            color: white;
            font-weight: bold;
            font-size: 24px;
        }

        .navbar-brand i {
            margin-right: 10px;
        }

        .loader {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #6c5ce7;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            animation: spin 2s linear infinite;
            margin: 0 auto;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .footer {
            margin-top: 40px;
            padding: 20px 0;
            background-color: #f8f9fa;
            border-top: 1px solid #e9ecef;
        }

        .form-check-input:checked {
            background-color: #6c5ce7;
            border-color: #6c5ce7;
        }

        .form-select:focus,
        .form-control:focus {
            border-color: #6c5ce7;
            box-shadow: 0 0 0 0.25rem rgba(108, 92, 231, 0.25);
        }

        .filter-preview {
            height: 80px;
            width: 100%;
            background-color: #e9ecef;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            margin-bottom: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .filter-label {
            font-weight: 500;
            text-align: center;
            display: block;
        }

        #processedImageContainer {
            min-height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ route('images.index') }}">
                <i class="fas fa-images"></i> Image Processor
            </a>
        </div>
    </nav>

    <div class="container">
        @yield('content')
    </div>

    <footer class="footer py-3">
        <div class="container text-center">
            <span class="text-muted">© {{ date('Y') }} Image Processor. All rights reserved.</span>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
    @yield('scripts')
</body>

</html>