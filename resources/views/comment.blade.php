@guest
    @if (Route::has('register'))
        Доступ запрещён
    @endif
    @else
<?php
$user_name = Auth::user()->name;
if ($user_name == $_GET['user_name']) {
    echo $_GET['user_id'] . "<br>" . $_GET['user_name'] . "<br>" . $_GET['header'] . "<br>" . $_GET['comment'];
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "laravel";
    $comment_id = 0;
    $comment_user_id = $_GET['user_id'];
    $comment_header = $_GET['header'];
    $comment_text = $_GET['comment'];
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    $sql = "SELECT *
                FROM users
                WHERE name = '$user_name'";
    $result_comments_2 = mysqli_query($conn, $sql);
    if ($result_comments_2->num_rows > 0) {
        while ($row_comments_2 = $result_comments_2->fetch_assoc()) {
            $user_name_2 = $row_comments_2["id"];
        }
    }

    $sql = "SELECT *
            FROM users
            WHERE name = '$comment_user_id'";
    $result_comments_2 = mysqli_query($conn, $sql);
    if ($result_comments_2->num_rows > 0) {
        while ($row_comments_2 = $result_comments_2->fetch_assoc()) {
            $user_id_2 = $row_comments_2["id"];
        }
    }

    $sql = "SELECT id
            FROM comments
            WHERE id = (SELECT MAX(id) FROM comments );";
    $result_comments_3 = mysqli_query($conn, $sql);
    if ($result_comments_3->num_rows > 0) {
        if ($row_comments_3 = $result_comments_3->fetch_assoc()) {
            $comment_id = $row_comments_3["id"];
        }
    }
    $comment_id++;
    $sql = "INSERT INTO comments VALUES
                ($comment_id, '$user_name_2', '$user_id_2', '$comment_header', '$comment_text', 0)";
    mysqli_query($conn, $sql);
    mysqli_close($conn);
    header("Location:/user/$id");
    exit;
}
?>
@endguest
