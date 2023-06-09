@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Список пользователей</div>
                <div class="card-body">
                    <?php
                    $servername = "localhost";
                    $username = "root";
                    $password = "root";
                    $dbname = "laravel";
                    $conn = mysqli_connect($servername, $username, $password, $dbname);
                    $sql = "SELECT name
                            FROM users";
                    $result = mysqli_query($conn, $sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $name = $row["name"];
                            echo "<a class=\"nav-link\" href=\"/user/$name\">$name</a>";
                        }
                    }
                    mysqli_close($conn);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
