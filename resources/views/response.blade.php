@guest
    @if (Route::has('register'))
        Доступ запрещён
    @endif
    @else
<?php
$user_name = Auth::user()->name;
if ($user_name == $_GET['user_name']) {
    echo $_GET['comment_id'] . "<br>" . $_GET['user_name'] . "<br>" . $_GET['header'] . "<br>" . $_GET['response'];
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "laravel";
    $response_id = 0;
    $comment_id = $_GET['comment_id'];
    $response_header = $_GET['header'];
    $response_text = $_GET['response'];
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    $sql = "SELECT *
                FROM users
                WHERE name = '$user_name'";
    $result_response_2 = mysqli_query($conn, $sql);
    if ($result_response_2->num_rows > 0) {
        while ($row_response_2 = $result_response_2->fetch_assoc()) {
            $user_name_2 = $row_response_2["id"];
        }
    }

    $sql = "SELECT *
            FROM comments
            WHERE id = '$comment_id'";
    $result_response_2 = mysqli_query($conn, $sql);
    if ($result_response_2->num_rows > 0) {
        while ($row_responses_2 = $result_response_2->fetch_assoc()) {
            $comment_id_2 = $row_responses_2["id"];
        }
    }

    $sql = "SELECT id
            FROM responses
            WHERE id = (SELECT MAX(id) FROM responses );";
    $result_response_3 = mysqli_query($conn, $sql);
    if ($result_response_3->num_rows > 0) {
        if ($row_responses_3 = $result_response_3->fetch_assoc()) {
            $response_id = $row_responses_3["id"];
        }
    }
    $response_id++;
    $sql = "INSERT INTO responses VALUES
                ($response_id, '$user_name_2', '$comment_id_2', '$response_header', '$response_text', 0)";
    mysqli_query($conn, $sql);
    mysqli_close($conn);
    header("Location:/user/$id");
    exit;
}
?>
@endguest
