<?php
$id = $_POST['comments'];
$user_name_auth = $_POST['user_name'];
if (trim($id) != "") {
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "laravel";
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    $sql = "SELECT *
            FROM users
            WHERE name = '$id'";
    $result = mysqli_query($conn, $sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $user_id = $row["id"];
        }
    }
    if (isset($user_id)) {
        $i = 0;
        $sql = "SELECT *
                FROM comments
                WHERE place = '$user_id' ORDER BY id DESC";

        $result_comments = mysqli_query($conn, $sql);
        if ($result_comments->num_rows > 0) {
        }
            while ($row_comments = $result_comments->fetch_assoc()) {
                if ($i < 5) {
                    $i++;
                } else {
                $user_id_users = $row_comments["user_id"];
                    $comment_id = $row_comments["id"];
                    $br = 0;

                    $sql = "SELECT name
                                FROM users
                                WHERE id = '$user_id_users'";
                    $result_users = mysqli_query($conn, $sql);
                if ($row_comments["removed"] == 0) {
                    if ($result_comments->num_rows > 0) {
                        while ($row_users = $result_users->fetch_assoc()) {
                            echo "<br><div style=\"margin: 0px auto; padding: 0px;\">" . "Комментарий от: <a href=\"" . $row_users['name'] . "\">" . $row_users['name'] . "</a>";
                                if ($user_name_auth == $id || $user_name_auth == $row_users['name'])
                                    echo "<a style='color: #c2c2c2; float: right' href=\"" . $id . "/comment_remove/" . $row_comments['id'] . "\">удалить</a></div>";
                                }
                    }
                    echo "<h5 style=\"margin: 2px; margin-left: 5px;\"><b>" . $row_comments["header"] . "</h5></b><b>" . $row_comments["text"] . "</b><br>";
                    $sql = "SELECT *
                                FROM responses
                                WHERE comment_id = '$comment_id' ORDER BY id DESC";
                    $result_responses = mysqli_query($conn, $sql);
                    if ($result_responses->num_rows > 0) {
                        echo '<ul class="navbar-nav ml-auto"><li class="nav-item dropdown">
                                                  <a id="navbarDropdown" class="nav-link dropdown-toggle" style="margin-top: -8px;" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>Ответы</a>
                                                  <span class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown" style="width: 690px; padding: 10px;">';
                        while ($row_responses = $result_responses->fetch_assoc()) {
                            if ($row_responses["removed"] == 0) {
                                if ($br == 1)
                                    echo "<br>";
                                $user_id_users = $row_responses["user_id"];
                                $sql = "SELECT name
                                                            FROM users
                                                            WHERE id = '$user_id_users'";
                                $result_users = mysqli_query($conn, $sql);
                                if ($result_responses->num_rows > 0) {
                                    while ($row_users = $result_users->fetch_assoc()) {
                                        echo "<div style=\"margin: 0px auto; padding: 0px;\">" . "Ответ от: <a href=\"" . $row_users['name'] . "\">" . $row_users['name'] . "</a>";
                                        if ($user_name_auth == $id || $user_name_auth == $row_users['name']) {
                                            echo "<a style='color: #c2c2c2; float: right; margin-right: 5px;' href=\"" . $id . "/response_remove/" . $row_responses['id'] . "\">удалить</a></div>";
                                        }
                                    }
                                }
                                echo "<h5 style=\"margin: 2px; margin-left: 5px;\"><b>" . $row_responses["header"] . "</h5></b><b>" . $row_responses["text"] . "</b><br>";
                                $br = 1;
                            } else if ($row_responses["removed"] == 1) {
                                if ($br == 1)
                                    echo "<br>";
                                $user_id_users = $row_responses["user_id"];
                                $sql = "SELECT name
                                                            FROM users
                                                            WHERE id = '$user_id_users'";
                                $result_users = mysqli_query($conn, $sql);
                                if ($result_responses->num_rows > 0) {
                                    while ($row_users = $result_users->fetch_assoc())
                                        echo "<div style=\"margin: 0px auto; padding: 0px;\">" . "Ответ от: <a href=\"" . $row_users['name'] . "\">" . $row_users['name'] . "</a></div>";
                                }
                                echo "<b style=\"margin-left: 5px;\">Удалено</b><br>";
                                $br = 1;
                            }
                        }
                        echo "</span></li></ul>";
                    }
                    if ($user_name_auth != "Guest") {
                        echo '<ul class="navbar-nav ml-auto"><li class="nav-item dropdown">
                                                  <a id="navbarDropdown" class="nav-link" style="margin-top: -8px;" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>Ответить</a>
                                                  <span class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown" style="width: 690px; padding: 10px;">';
                        echo "<form method='get' action=\"$id/response\">
                                                    <input style='display: none;' type='text' name='comment_id' value=\"$comment_id\" />
                                                    <input style='display: none;' type='text' name='user_name' value=\"$user_name_auth\" />
                                                    <input style='float: left;' type='text' name='header' placeholder='Заголовок' />
                                                    <textarea style='width: 360px; margin-left: 10px;' type='text' name='response' placeholder='Текст комментария'></textarea>
                                                    <input style='float: right;' type='submit' name='send_button' value='Отправить' />
                                                </form>";
                        echo "</span></li></ul>";
                    }
                } else if ($row_comments["removed"] == 1) {
                    if ($result_comments->num_rows > 0) {
                        while ($row_users = $result_users->fetch_assoc())
                            echo "<br><div style=\"margin: 0px auto; padding: 0px;\">" . "Комментарий от: <a href=\"" . $row_users['name'] . "\">" . $row_users['name'] . "</a></div>";
                    }
                    echo "<b style=\"margin-left: 5px;\">Удалено</b><br>";
                    $sql = "SELECT *
                                FROM responses
                                WHERE comment_id = '$comment_id'";
                    $result_responses = mysqli_query($conn, $sql);
                    if ($result_responses->num_rows > 0) {
                        echo '<ul class="navbar-nav ml-auto"><li class="nav-item dropdown">
                                                  <a id="navbarDropdown" class="nav-link dropdown-toggle" style="margin-top: -8px;" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>Ответы</a>
                                                  <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown" style="width: 690px; padding: 10px;">';
                        while ($row_responses = $result_responses->fetch_assoc()) {
                            if ($row_responses["removed"] == 0) {
                                if ($br == 1)
                                    echo "<br>";
                                $user_id_users = $row_responses["user_id"];
                                $sql = "SELECT name
                                                            FROM users
                                                            WHERE id = '$user_id_users'";
                                $result_users = mysqli_query($conn, $sql);
                                if ($result_responses->num_rows > 0) {
                                    while ($row_users = $result_users->fetch_assoc()) {
                                        echo "<div style=\"margin: 0px auto; padding: 0px;\">" . "Ответ от: <a href=\"" . $row_users['name'] . "\">" . $row_users['name'] . "</a>";
                                        if ($user_name_auth == $id || $user_name_auth == $row_users['name']) {
                                            echo "<a style='color: #c2c2c2; float: right; margin-right: 5px;' href=\"" . $id . "/response_remove/" . $row_responses['id'] . "\">удалить</a></div>";
                                        }
                                    }
                                }
                                echo "<h5 style=\"margin: 2px; margin-left: 5px;\"><b>" . $row_responses["header"] . "</h5></b><b>" . $row_responses["text"] . "</b><br>";
                                $br = 1;
                            } else if ($row_responses["removed"] == 1) {
                                if ($br == 1)
                                    echo "<br>";
                                $user_id_users = $row_responses["user_id"];
                                $sql = "SELECT name
                                                            FROM users
                                                            WHERE id = '$user_id_users'";
                                $result_users = mysqli_query($conn, $sql);
                                if ($result_responses->num_rows > 0) {
                                    while ($row_users = $result_users->fetch_assoc())
                                        echo "<div style=\"margin: 0px auto; padding: 0px;\">" . "Ответ от: <a href=\"" . $row_users['name'] . "\">" . $row_users['name'] . "</a></div>";
                                }
                                echo "<b style=\"margin-left: 5px;\">Удалено</b><br>";
                                $br = 1;
                            }
                        }
                        echo "</div></li></ul>";
                    }
                }
            }
        }
    }
    mysqli_close($conn);
}
?>
