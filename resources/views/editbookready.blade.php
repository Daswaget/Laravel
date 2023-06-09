@guest
    @if (Route::has('register'))
        header("Location:/user/$id");
        exit;
    @endif
    @else
<?php
$user_name_auth = Auth::user()->name;
if ($user_name_auth == $id) {
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "laravel";
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    $books_id = 0;
    $book_text = $_GET['book_text'];
    $book_name = $_GET['book_name'];

    $sql = "SELECT id
        FROM users
        WHERE name = '$id'";
    $result_books_2 = mysqli_query($conn, $sql);
    if ($result_books_2->num_rows > 0) {
        while ($row_books_2 = $result_books_2->fetch_assoc()) {
            $user_id_2 = $row_books_2["id"];
        }
    }

    $sql = "SELECT *
        FROM books
        WHERE user_id = '$user_id_2' ORDER BY id DESC";

    $sql = "SELECT id
        FROM books
        WHERE id = (SELECT MAX(id) FROM books);";
    $result_comments_3 = mysqli_query($conn, $sql);
    if ($result_comments_3->num_rows > 0) {
        if ($row_comments_3 = $result_comments_3->fetch_assoc()) {
            $books_id = $row_comments_3["id"];
        }
    }

    $sql = "UPDATE books
        SET name = '$book_name', text = '$book_text'
        WHERE id = '$books_id'";
    mysqli_query($conn, $sql);

    echo $_GET['book_text'];
    mysqli_close($conn);
    header("Location:/user/$id/library/$book_name");
    exit;
} else {
    header("Location:/home");
    exit;
}
?>
@endguest
