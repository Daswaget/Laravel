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
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "laravel";
$i = 0;
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



    $sql = "SELECT *
FROM users
WHERE name = '$user_name_auth'";
    $result_auth = mysqli_query($conn, $sql);
    if ($result_auth->num_rows > 0) {
        while ($row_auth = $result_auth->fetch_assoc()) {
            $user_id_auth = $row_auth["id"];
        }

    $sql = "SELECT *
FROM libraries
WHERE user_id = '$user_id_auth'";
    $result_libraries = mysqli_query($conn, $sql);
    if ($result_libraries->num_rows > 0) {
        while ($row_libraries = $result_libraries->fetch_assoc()) {
            $library_id = $row_libraries["id"];
        }

        $sql = "SELECT *
                FROM library_access
                WHERE library_id = '$library_id' AND user_id = '$user_id'";
        $result_library_access = mysqli_query($conn, $sql);
        if ($result_library_access->num_rows > 0) {
            while ($row_library_access = $result_library_access->fetch_assoc()) {
                $library_access = $row_library_access["id"];
            }
        }
    }
}

if ($user_name_auth != "Guest") {
    $sql = "SELECT *
FROM libraries
WHERE user_id = '$user_id'";
    $result_libraries = mysqli_query($conn, $sql);
    if ($result_libraries->num_rows > 0) {
        while ($row_libraries = $result_libraries->fetch_assoc()) {
            $library_id_2 = $row_libraries["id"];
        }
        $sql = "SELECT *
                FROM library_access
                WHERE library_id = '$library_id_2' AND user_id = '$user_id_auth'";
        $result_library_access = mysqli_query($conn, $sql);
        if ($result_library_access->num_rows > 0) {
            while ($row_library_access = $result_library_access->fetch_assoc()) {
                $library_access_2 = $row_library_access["id"];
            }
        }
    }
}



?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Профиль <?php echo $id ?></div>
                    <div class="card-body">
                        <?php
                    if (isset($user_id)) {
                        echo "<a href=\"/home\">Вернуться на домашнюю страницу</a><br><br>";
                        if ($user_name_auth != "Guest" && (isset($library_access_2) || $user_name_auth == $id)) {
                            echo "<a href=\"$id/library\">Библиотека пользователя</a><br><br>";
                        }
                        if (($user_name_auth != "Guest" && $user_name_auth != $id && !isset($library_access)) && isset($library_id)) {
                            echo "<a href=\"$id/library_access\">Разрешить пользователю доступ к вашей библиотеке</a><br><br>";
                        } else if (($user_name_auth != "Guest" && $user_name_auth != $id && isset($library_access)) && isset($library_id)) {
                            echo "<a href=\"$id/library_access\">Запретить пользователю доступ к вашей библиотеке</a><br><br>";
                        }
                        if ($user_name_auth != "Guest") {
                            echo '<ul class="navbar-nav ml-auto"><li class="nav-item dropdown">
                                                      <a id="navbarDropdown" class="nav-link" style="margin-top: -8px;" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>Оставить комментарий</a>
                                                      <span class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown" style="width: 690px; padding: 10px;">';
                            echo "<form method='get' action=\"$id/comment\">
                                                        <input style='display: none;' type='text' name='user_id' value=\"$id\" />
                                                        <input style='display: none;' type='text' name='user_name' value=\"$user_name_auth\" />
                                                        <input style='float: left;' type='text' name='header' placeholder='Заголовок' />
                                                        <textarea style='width: 360px; margin-left: 10px;' type='text' name='comment' placeholder='Текст комментария'></textarea>
                                                        <input style='float: right;' type='submit' name='send_button' value='Отправить' />
                                                    </form>";
                            echo "</span></li></ul>";
                        }
                        $sql = "SELECT *
                        FROM comments
                        WHERE place = '$user_id' ORDER BY id DESC";
                        $result_comments = mysqli_query($conn, $sql);
                        if ($result_comments->num_rows > 0) {
                            while ($row_comments = $result_comments->fetch_assoc()) {
                                if ($i < 5) {
                                    $i++;
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
                            if ($i >= 5) {
                            echo "
                        <div id='hide'>
                            <br>
                            <form id='form' method='post'>
                                <input style='display: none;' type='text' name='user_name' value=\"$user_name_auth\" />
                                <input style='display: none;' type='text' name='comments' value=\"$id\" />
                                <input id='submit' type='submit' value='Показать все комментарии' />
                            </form>
                        </div>
                            <div id='result'></div>";}
                        ?>
                        <script>
                        document.querySelector("#submit").onclick = function(){
                        hide.style.display = "none";}
                        </script>
                        <?php
                        }
                    } else {
                        echo "Такого профиля не существует";
                    }
                    mysqli_close($conn);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
