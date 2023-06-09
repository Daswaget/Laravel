@extends('layouts.app')

@section('content')

@guest
@if (Route::has('register'))
<?php
$user_name_auth = "Guest";
?>
@endif
@else
<?php
$user_name_auth = Auth::user()->name;
?>
@endguest
<?php
if ($user_name_auth != "Guest" && $user_name_auth == $id) {
?>
<div class="container" style="margin-bottom: 100px;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Редактор книг</div>
                <div class="card-body">
                    <?php
                        echo "<a href=\"../../library\">Вернуться к книге без изменений</a><br><br>";
                        $servername = "localhost";
                        $username = "root";
                        $password = "root";
                        $dbname = "laravel";
                        $conn = mysqli_connect($servername, $username, $password, $dbname);
                        $book_name = "Ошибка";
                        $book_text = "Ошибка";

                        $sql = "SELECT *
                                FROM books
                                WHERE name = '$book'";
                        $result_books_2 = mysqli_query($conn, $sql);
                        if ($result_books_2->num_rows > 0) {
                            while ($row_books_2 = $result_books_2->fetch_assoc()) {
                                $book_name = $row_books_2["name"];
                                $book_text = $row_books_2["text"];
                            }
                        }
                        echo "<form method='get' action=\"edit_book/ready\">
                                <input style='display: none;' type='text' name='user_id' value=\"$id\" />
                                <input style='display: none;' type='text' name='user_name' value=\"$user_name_auth\" />
                                <input style='width: 583px;' type='text' name='book_name' placeholder='Название книги' value=\"$book_name\" />
                                <input style='float: right;' type='submit' name='send_button' value='Сохранить' /><br>
                                <textarea style='width: 685px; min-height: 8000px; margin-top: 10px;' type='text' name='book_text' placeholder='Текст'>$book_text</textarea>
                            </form>";
                        mysqli_close($conn);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
} else {
    header("Location:../$book");
    exit;
}
?>
@endsection
