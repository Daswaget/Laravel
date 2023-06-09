@guest
    @if (Route::has('register'))
        header("Location:/user/$id");
        exit;
    @endif
    @else
<?php
$user_name_auth = Auth::user()->name;
if ($user_name_auth != $id) {
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


    $sql = "SELECT id
        FROM users
        WHERE name = '$user_name_auth'";
    $result_auth = mysqli_query($conn, $sql);
    if ($result_auth->num_rows > 0) {
        while ($row_auth = $result_auth->fetch_assoc()) {
            $user_auth_id = $row_auth["id"];
        }
    }


    $sql = "SELECT *
        FROM libraries
        WHERE user_id = '$user_auth_id'";
    $result_library_2 = mysqli_query($conn, $sql);
    if ($result_library_2->num_rows > 0) {
        while ($row_library_2 = $result_library_2->fetch_assoc()) {
            $library_id_2 = $row_library_2["id"];
        }
    }



    $sql = "SELECT id
            FROM library_access
            WHERE id = (SELECT MAX(id) FROM library_access );";
    $result_library_access_3 = mysqli_query($conn, $sql);
    if ($result_library_access_3->num_rows > 0) {
        if ($row_library_access_3 = $result_library_access_3->fetch_assoc()) {
            $library_access_id = $row_library_access_3["id"];
        }
    } else {
        $library_access_id = 0;
    }
    $sql = "SELECT id
        FROM library_access
        WHERE id = '$library_access_id' AND library_id = '$library_id_2' AND user_id = '$user_id_2'";
    $result_library_access_4 = mysqli_query($conn, $sql);
    if ($result_library_access_4->num_rows > 0) {
        if ($row_library_access_4 = $result_library_access_4->fetch_assoc()) {
            $library_access_2 = $row_library_access_4["id"];
        }
    }

    if (!isset($library_access_2)) {
        $library_access_id++;
        $sql = "INSERT INTO library_access VALUES
                ($library_access_id, '$library_id_2', '$user_id_2')";
    } else {
        $sql = "DELETE FROM library_access
        WHERE id = '$library_access_id' AND library_id = '$library_id_2' AND user_id = '$user_id_2'";
    }
    mysqli_query($conn, $sql);
    mysqli_close($conn);
}
    header("Location:/user/$id");
    exit;
?>
@endguest
