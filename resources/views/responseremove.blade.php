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
        $result_response_2 = mysqli_query($conn, $sql);
        if ($result_response_2->num_rows > 0) {
            while ($row_response_2 = $result_response_2->fetch_assoc()) {
                $user_id_2 = $row_response_2["id"];
            }
        }

        $sql = "SELECT *
                FROM responses
                WHERE id = '$response'";
        $result_responses_3 = mysqli_query($conn, $sql);
        if ($result_responses_3->num_rows > 0) {
            while ($row_responses_3 = $result_responses_3->fetch_assoc()) {
                $response_user_id = $row_responses_3["user_id"];
            }
        }

        $sql = "SELECT *
                FROM users
                WHERE name = '$user_name'";
        $result_responses_4 = mysqli_query($conn, $sql);
        if ($result_responses_4->num_rows > 0) {
            while ($row_responses_4 = $result_responses_4->fetch_assoc()) {
                $response_user_id2 = $row_responses_4["id"];
            }
        }

        if ($id == $user_name || $response_user_id == $response_user_id2) {
            $sql = "UPDATE responses
                    SET removed = '1'
                    WHERE id = '$response'";
            mysqli_query($conn, $sql);
        };
        mysqli_close($conn);
        header("Location:/user/$id");
        exit;
?>
@endguest
