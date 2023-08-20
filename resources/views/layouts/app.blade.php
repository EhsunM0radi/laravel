<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel App - @yield('title')</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        .sidebar {
            background-color: #333;
            color: #fff;
            padding: 15px;
            min-height: 100vh;
        }
        .sidebar h2 {
            margin-bottom: 20px;
            text-align: center;
        }
        .sidebar a {
            color: #fff;
            text-decoration: none;
            display: block;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .sidebar a:hover {
            background-color: #444;
        }
        .content {
            padding: 20px;
        }
        .content h1 {
            margin-bottom: 20px;
        }
        .navbar-nav {
            display: none;
        }

        /* Responsive Styles */
        @media (max-width: 767px) {
            .sidebar {
                display: none;
                padding-top: 60px;
                min-height: auto;
                text-align: center;
            }
            .sidebar a {
                margin-bottom: 10px;
            }
            .navbar-brand {
                padding: 10px;
            }
            .navbar-nav {
                display: flex;
                margin-top: 15px;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark">
        <a class="navbar-brand" href="{{route('home')}}">Dashboard</a>
        <form action="{{route('logout')}}" method="POST">
            @csrf
            @method('POST')
            <button type="submit" class="btn btn-dark">Logout</button>
        </form>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="{{route('home')}}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('projects.index')}}">Projects</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('tasks.index')}}">Tasks</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-2 col-md-3 sidebar">
                <a href="{{route('home')}}">Home</a>
                <a href="{{route('projects.index')}}">Projects</a>
                <a href="{{route('tasks.index')}}">Tasks</a>                
            </div>
            <!-- Main Content -->
            <div class="col-lg-10 col-md-9 content">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
        $('.js-example-basic-multiple').select2();
    });
    
    </script>
</body>
</html>
