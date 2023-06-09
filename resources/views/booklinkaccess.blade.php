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
    $link_access = 0;

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
        WHERE user_id = '$user_id_2' AND name = '$book'";
    $result_comments_3 = mysqli_query($conn, $sql);
    if ($result_comments_3->num_rows > 0) {
        if ($row_comments_3 = $result_comments_3->fetch_assoc()) {
            $books_id = $row_comments_3["id"];
        }
    }

    $sql = "SELECT *
        FROM books
        WHERE id = '$books_id'";
    $result_comments_4 = mysqli_query($conn, $sql);
    if ($result_comments_4->num_rows > 0) {
        while ($row_comments_4 = $result_comments_4->fetch_assoc()) {
            $link_access = $row_comments_4["link_access"];
        }
    }
    if ($link_access == 0) {
        $sql = "UPDATE books
        SET link_access = '1'
        WHERE id = '$books_id'";
    } else {
        $sql = "UPDATE books
        SET link_access = '0'
        WHERE id = '$books_id'";
    }
    mysqli_query($conn, $sql);
    mysqli_close($conn);
    header("Location:/user/$id/library/$book");
    exit;
} else {
    header("Location:/home");
    exit;
}
?>
@endguest
