<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Worker Dashboard</title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f5f5f5;
        }

        .navbar {
            background: #222;
            color: white;
            padding: 18px 30px;

            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 22px;
            font-weight: bold;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
        }

        .logout-button {
            background: #dc3545;
            border: none;
            color: white;
            padding: 9px 16px;
            border-radius: 5px;
            cursor: pointer;
        }

        .container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .welcome {
            background: white;
            padding: 30px;
            border-radius: 10px;
            margin-bottom: 25px;

            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        }

        .welcome h1 {
            margin-top: 0;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 10px;

            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        }

        .card h3 {
            margin-top: 0;
        }

        @media (max-width: 768px) {

            .navbar {
                flex-direction: column;
                gap: 15px;
            }

            .cards {
                grid-template-columns: 1fr;
            }

        }

    </style>
</head>

<body>

    <!-- Navbar -->

    <nav class="navbar">

        <div class="logo">
            Wedding Halls
        </div>

        <div class="nav-links">

            <a href="{{ route('worker.dashboard') }}">
                Dashboard
            </a>

            <a href="{{ route('profile.edit') }}">
                Profile
            </a>

            <form
                action="{{ route('logout') }}"
                method="POST"
                style="display: inline;"
            >
                @csrf

                <button
                    type="submit"
                    class="logout-button"
                >
                    Logout
                </button>
            </form>

        </div>

    </nav>


    <!-- Main Content -->

    <main class="container">

        <div class="welcome">

            <h1>
                Worker Dashboard
            </h1>

            <p>
                Welcome,
                {{ auth()->user()->name ?? auth()->user()->fullname ?? 'Worker' }}
            </p>

            <p>
                You are logged in as a Worker.
            </p>

        </div>


        <!-- Cards -->

        <div class="cards">

            <div class="card">

                <h3>
                    Reservations
                </h3>

                <p>
                    View and manage your assigned reservations.
                </p>

            </div>


            <div class="card">

                <h3>
                    Tasks
                </h3>

                <p>
                    View your assigned tasks.
                </p>

            </div>


            <div class="card">

                <h3>
                    Profile
                </h3>

                <p>
                    Manage your account information.
                </p>

                <a href="{{ route('profile.edit') }}">
                    Open Profile
                </a>

            </div>

        </div>

    </main>

</body>
</html>