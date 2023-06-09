@guest
    @if (Route::has('register'))
        header("Location:/user/$id");
        exit;
    @endif
    @else
        <?php
        $servername = "localhost";
        $username = "root";
        $password = "root";
        $dbname = "laravel";
        $conn = mysqli_connect($servername, $username, $password, $dbname);
        $user_name = Auth::user()->name;
        $sql = "SELECT *
                FROM users
                WHERE name = '$id'";
        $result_comments_2 = mysqli_query($conn, $sql);
        if ($result_comments_2->num_rows > 0) {
            while ($row_comments_2 = $result_comments_2->fetch_assoc()) {
                $user_id_2 = $row_comments_2["id"];
            }
        }

        $sql = "SELECT *
                FROM comments
                WHERE id = '$comment'";
        $result_comments_3 = mysqli_query($conn, $sql);
        if ($result_comments_3->num_rows > 0) {
            while ($row_comments_3 = $result_comments_3->fetch_assoc()) {
                $comment_user_id = $row_comments_3["user_id"];
            }
        }

        $sql = "SELECT *
                FROM users
                WHERE name = '$user_name'";
        $result_comments_4 = mysqli_query($conn, $sql);
        if ($result_comments_4->num_rows > 0) {
            while ($row_comments_4 = $result_comments_4->fetch_assoc()) {
                $comment_user_id2 = $row_comments_4["id"];
            }
        }

        if ($id == $user_name || $comment_user_id == $comment_user_id2) {
            $sql = "UPDATE comments
                    SET removed = '1'
                    WHERE id = '$comment'";
            mysqli_query($conn, $sql);
        };
        mysqli_close($conn);
        header("Location:/user/$id");
        exit;
?>
@endguest
