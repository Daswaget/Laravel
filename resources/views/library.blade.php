@extends('layouts.app')

@section('content')
@guest
@if (Route::has('register'))
<?php
header("Location:/user/$id");
exit;
$user_name_auth = "Guest";
?>
@endif
@else
@endguest
<?php
$user_name_auth = Auth::user()->name;

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "laravel";
$conn = mysqli_connect($servername, $username, $password, $dbname);

$sql = "SELECT *
FROM users
WHERE name = '$id'";
$result = mysqli_query($conn, $sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $user_id = $row["id"];
    }
}



$sql = "SELECT *
FROM users
WHERE name = '$user_name_auth'";
$result_auth = mysqli_query($conn, $sql);
if ($result_auth->num_rows > 0) {
    while ($row_auth = $result_auth->fetch_assoc()) {
        $user_id_auth = $row_auth["id"];
    }

    $sql = "SELECT *
FROM libraries
WHERE user_id = '$user_id_auth'";
    $result_libraries = mysqli_query($conn, $sql);
    if ($result_libraries->num_rows > 0) {
        while ($row_libraries = $result_libraries->fetch_assoc()) {
            $library_id = $row_libraries["id"];
        }

        $sql = "SELECT *
                FROM library_access
                WHERE library_id = '$library_id' AND user_id = '$user_id'";
        $result_library_access = mysqli_query($conn, $sql);
        if ($result_library_access->num_rows > 0) {
            while ($row_library_access = $result_library_access->fetch_assoc()) {
                $library_access = $row_library_access["id"];
            }
        }
    }
}

if ($user_name_auth != "Guest") {
    $sql = "SELECT *
FROM libraries
WHERE user_id = '$user_id'";
    $result_libraries = mysqli_query($conn, $sql);
    if ($result_libraries->num_rows > 0) {
        while ($row_libraries = $result_libraries->fetch_assoc()) {
            $library_id_2 = $row_libraries["id"];
        }
        $sql = "SELECT *
                FROM library_access
                WHERE library_id = '$library_id_2' AND user_id = '$user_id_auth'";
        $result_library_access = mysqli_query($conn, $sql);
        if ($result_library_access->num_rows > 0) {
            while ($row_library_access = $result_library_access->fetch_assoc()) {
                $library_access_2 = $row_library_access["id"];
            }
        }
    }
}

if (!isset($library_access_2) && $user_name_auth != $id) {
    header("Location:/user/$id");
    exit;
}

?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Библиотека <?php echo $id ?></div>
                <div class="card-body">
                    <?php
                    echo "<a href=\"../$id\">Вернуться в профилю пользователя</a><br><br>";
                    if ($user_name_auth != "Guest" && $user_name_auth == $id)
                        echo "<a href=\"library/write_book\">Написать книгу</a><br><br>";
                    $sql = "SELECT id
                            FROM users
                            WHERE name = '$id'";
                    $result_books_2 = mysqli_query($conn, $sql);
                    if ($result_books_2->num_rows > 0) {
                        while ($row_books_2 = $result_books_2->fetch_assoc()) {
                            $user_id_2 = $row_books_2["id"];
                        }
                    }

                    $sql = "SELECT name
                            FROM books
                            WHERE user_id = '$user_id_2' ORDER BY id DESC";
                    $result_books_3 = mysqli_query($conn, $sql);
                    if ($result_books_3->num_rows > 0) {
                        echo "<h4><b>Список книг</b></h4><ul>";
                        while ($row_books_3 = $result_books_3->fetch_assoc()) {
                            $book = $row_books_3["name"];
                            echo "<li><a href=\"library/$book\">$book</a></li>";
                        }
                        echo "</ul>";
                    } else {
                        echo "У данного пользователя ещё нет книг";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
mysqli_close($conn);
?>
@endsection
