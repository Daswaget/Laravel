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
                    echo "<a href=\"../library\">Вернуться в библиотеку</a><br><br>";
                    $servername = "localhost";
                    $username = "root";
                    $password = "root";
                    $dbname = "laravel";
                    $conn = mysqli_connect($servername, $username, $password, $dbname);
                    echo "<form method='get' action=\"write_book/ready\">
                            <input style='display: none;' type='text' name='user_id' value=\"$id\" />
                            <input style='display: none;' type='text' name='user_name' value=\"$user_name_auth\" />
                            <input style='width: 600px;' type='text' name='book_name' placeholder='Название книги' />
                            <input style='float: right;' type='submit' name='send_button' value='Создать' /><br>
                            <textarea style='width: 685px; min-height: 8000px; margin-top: 10px;' type='text' name='book_text' placeholder='Текст'></textarea>
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
    header("Location:../library");
    exit;
}
?>
@endsection
