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
<?php
$user_name_auth = Auth::user()->name;
?>
@endguest
<?php
$book_name = "Ошибка";
$book_text = "Ошибка";
$link_access = 0;
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "laravel";
$conn = mysqli_connect($servername, $username, $password, $dbname);
$sql = "SELECT *
        FROM books
        WHERE name = '$book'";

$result_books_2 = mysqli_query($conn, $sql);
if ($result_books_2->num_rows > 0) {
    while ($row_books_2 = $result_books_2->fetch_assoc()) {
        $book_name = $row_books_2["name"];
        $book_text = $row_books_2["text"];
        $link_access = $row_books_2["link_access"];
    }
}






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

if ((!isset($library_access_2) && $user_name_auth != $id) && $link_access == 0) {
    header("Location:/user/$id");
    exit;
}








mysqli_close($conn);
?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><?php echo $book ?></div>
                <div class="card-body">
                    <?php
                    echo "<a href=\"../library\">Вернуться в библиотеку</a><br><br>";
                    if ($user_name_auth != "Guest" && $user_name_auth == $id) {
                        echo "<a href=\"$book/edit_book\">Редактировать книгу</a><br><br>";
                        if ($link_access == 0)
                            echo "<a href=\"$book/book_link_access\">Разрешить доступ к книге по ссылке</a><br><br>";
                        else
                            echo "<a href=\"$book/book_link_access\">Запретить доступ к книге по ссылке</a><br><br>";
                    }
                    echo "Автор: $id<br><br>";

                    echo "<h4><b>" . $book_name . "</b></h4>";
                    echo $book_text;
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
