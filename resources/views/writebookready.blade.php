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
            WHERE name = '$user_name_auth'";
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
    $books_id++;

    $sql = "INSERT INTO books VALUES
                    ($books_id, '$user_id_2', '$book_text', '$book_name', '0')";
    mysqli_query($conn, $sql);

    $sql = "SELECT *
            FROM libraries
            WHERE user_id = '$user_id_2'";
    $result_library_2 = mysqli_query($conn, $sql);
    if ($result_library_2->num_rows > 0) {
        while ($row_library_2 = $result_library_2->fetch_assoc()) {
            $library_id_2 = $row_library_2["id"];
        }
    } else {
        $library_id_2 = -1;
    }

    if (!isset($library_id_2) || $library_id_2 == -1) {
        $sql = "SELECT id
                FROM libraries
                WHERE id = (SELECT MAX(id) FROM libraries );";
        $result_library_1 = mysqli_query($conn, $sql);
        if ($result_library_1->num_rows > 0) {
            if ($row_library_1 = $result_library_1->fetch_assoc()) {
                $library_id_1 = $row_library_1["id"];
            }
            $library_id_1++;
            $sql = "INSERT INTO libraries VALUES
                    ($library_id_1, '$user_id_2')";
            mysqli_query($conn, $sql);
        } else {
            $sql = "INSERT INTO libraries VALUES
                    (1, '$user_id_2')";
            mysqli_query($conn, $sql);
        }
    }
    mysqli_close($conn);
    header("Location:/user/$id/library");
    exit;
} else {
    header("Location:/home");
    exit;
}
?>
@endguest
