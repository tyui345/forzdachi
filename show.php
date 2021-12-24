<?php include("includes/header.php"); ?>

<?php
session_start();
if (!isset($_SESSION["session_user"])) {
    header("location:index.php");
}
?>
<div id="top_bar">
    <div id="logo_container">
        <div id="nav_block">
            <div class="nav_button"> Добро пожаловать: <span><?php echo $_SESSION['session_user']; ?></span></div>
            <div class="nav_button"><a href="logout.php">Выйти</a></div>
        </div>
    </div>
</div>
<?php

$employers = mysqli_query($con, "SELECT * FROM `employee`");
$primises = mysqli_query($con, "SELECT * FROM `primises`");
$servicess = mysqli_query($con, "SELECT * FROM `service`");
$sell_abonementss = mysqli_query($con, "SELECT * FROM `sell_abonement`");
// get values from the form
function getPosts()
{
    $posts = [
        htmlspecialchars($_POST['id']),
        htmlspecialchars($_POST['date']),
        htmlspecialchars($_POST['time_start']),
        htmlspecialchars($_POST['time_end']),
        htmlspecialchars($_POST['primises_id']),
        htmlspecialchars($_POST['employee_id']),
        htmlspecialchars($_POST['service_id']),
        htmlspecialchars($_POST['sell_abonement_id']),
    ];
    return $posts;
}

// Search

if (isset($_POST['search'])) {
    $data = getPosts();

    $searchQuery = "SELECT * FROM timetable WHERE id = '" . $data[0] . "'";

    $search_Result = mysqli_query($con, $searchQuery);

    if ($search_Result) {
        if (mysqli_num_rows($search_Result)) {
            while ($row = mysqli_fetch_array($search_Result)) {
                $id = $row['id'];
                $date = $row['date'];
                $timeStart = $row['time_start'];
                $timeEnd = $row['time_end'];
                $primisesId = $row['primises_id'];
                $employee_id = $row['employee_id'];
                $service_id = $row['service_id'];
                $sellAbonementId = $row['sell_abonement_id'];
            }
        } else {
            echo 'Не знайдено з таким ID';
        }
    } else {
        echo 'Result Error';
    }
    unset($_POST['search']);
}


// Insert
if (isset($_POST['insert'])) {
    $data = getPosts();
    $insertQuery = "INSERT INTO `timetable`(`date`,`time_start`,`time_end`,`primises_id`,`employee_id`,`service_id`,`sell_abonement_id`)
        VALUES ('" . $data[1] . "','" . $data[2] . "','" . $data[3] . "','" . $data[4] . "','" . $data[5] . "','" . $data[6] . "','" . $data[7] . "')";
    try {
        $insert_Result = mysqli_query($con, $insertQuery);

        if ($insert_Result) {
            if (mysqli_affected_rows($con) > 0) {
                echo 'Успішно додано.';
            } else {
                echo 'Дані введені не вірно!';
            }
        }
    } catch (Exception $ex) {
        echo 'Error Insert ' . $ex->getMessage();
    }
    unset($_POST['insert']);
}

// Delete
if (isset($_POST['delete'])) {
    $data = getPosts();
    $deleteQuery = "DELETE FROM `timetable` WHERE `id` = $data[0]";
    try {
        $delete_Result = mysqli_query($con, $deleteQuery);

        if ($delete_Result) {
            if (mysqli_affected_rows($con) > 0) {
                echo 'Успішно видалено.';
            } else {
                echo 'Дані введені не вірно!';
            }
        }
    } catch (Exception $ex) {
        echo 'Error Delete ' . $ex->getMessage();
    }
    unset($_POST['delete']);
}

// Edit
if (isset($_POST['update'])) {
    $data = getPosts();
    $updateQuery = "UPDATE `timetable` SET `categories`='$data[1]',`time_start`='$data[2]',`time_end`='$data[3]',`primises`='$data[4]',`employee_id`='$data[5]',`service_id`='$data[6]',`sell_abonement_id`='$data[7]'WHERE `id` = $data[0]";
    try {
        $update_Result = mysqli_query($con, $updateQuery);

        if ($update_Result) {
            if (mysqli_affected_rows($con) > 0) {
                echo 'Інформацію успішно змінено.';
            } else {
                echo 'Дані введені не вірно!';
            }
        }
    } catch (Exception $ex) {
        echo 'Error Update ' . $ex->getMessage();
    }
    unset($_POST['update']);
}

?>

<div class="container mshow_prod">
    <div id="show">
        <form action="show.php" method="post">
            <label for="1">
                <input class="input" type="number" name="id" placeholder="Id" value="<?php
                if (isset($id) && filter_var($id, FILTER_VALIDATE_INT)) {
                    echo $id;
                } else {
                    echo "";
                }
                ?>">
            </label>
            <br><br>
            <label for="2">
                <input class="input" type="date" name="date" placeholder="дата" value="<?php echo $date; ?>">
            </label>
            <br><br>
            <label for="3">
                <input class="input" type="time" name="time_start" placeholder="тайм старт"
                       value="<?php echo $timeStart; ?>">
            </label>
            <br><br>
            <label for="4">
                <input class="input" type="time" name="time_end" placeholder="тайм енд" value="<?php echo $timeEnd; ?>">
            </label>
            <br><br>
            <label for="5">
                <select name="primises_id" class="input">
                    <option value="null">&mdash;</option>
                    <?php foreach ($primises as $primis) {
                        echo "<option value='" . $primis['id'] . "' " . ($primis['id'] == $primisesId ? 'selected' : '') . ">" . $primis['name'] . "</option>";
                    }
                    ?>
                </select>
            </label>
            <br><br>
            <label for="6">
                <select name="employee_id" class="input">
                    <option value="null">&mdash;</option>
                    <?php foreach ($employers as $employer) {
                        echo "<option value='" . $employer['id'] . "' " . ($employer['id'] == $employee_id ? 'selected' : '') . ">" . $employer['name'] . "</option>";
                    }
                    ?>
                </select>
            </label>
            <br><br>
            <label for="7">
                <select name="service_id" class="input">
                    <option value="null">&mdash;</option>
                    <?php foreach ($servicess as $services) {
                        echo "<option value='" . $services['id'] . "' " . ($services['id'] == $service_id ? 'selected' : '') . ">" . $services['name'] . "</option>";
                    }
                    ?>
                </select>
            </label>
            <br><br>
            <label for="8">
                <select name="sell_abonement_id" class="input">
                    <option value="null">&mdash;</option>
                    <?php foreach ($sell_abonementss as $sell_abonements) {
                        echo "<option value='" . $sell_abonements['id'] . "' " . ($sell_abonements['id'] == $sellAbonementId ? 'selected' : '') . ">" . $sell_abonements['id'] . "</option>";
                    }
                    ?>
                </select>
            </label>
            <br><br>

            <div>
                <!-- Input For Add Values To Database-->
                <input type="submit" class="button" name="insert" value="Додати">

                <!-- Input For Edit Values -->
                <input type="submit" class="button" name="update" value="Редагувати">

                <!-- Input For Clear Values -->
                <input type="submit" class="button" name="delete" value="Видалити">

                <!-- Input For Find Values With The given ID -->
                <input type="submit" class="button" name="search" value="Знайти">
            </div>
        </form>
    </div>
    <div>
        <h2>Список товарів</h2>
        <?php
        $sql = "SELECT * FROM timetable";
        if ($result = $con->query($sql)) {
            $rowsCount = $result->num_rows; // количество полученных строк
            echo "<p>Всього товарів: $rowsCount</p>";
            echo "<table>
    <tr>
    <th>Id</th>
    <th>дата</th>
    <th>дата старт</th>
    <th>дата енд</th>
    <th>сотрудник</th>
    <th>название</th>
    <th>название</th>
    <th>sell_abonemnt</th>
    </tr>";
            foreach ($result as $row) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["date"] . "</td>";
                echo "<td>" . $row["time_start"] . "</td>";
                echo "<td>" . $row["time_end"] . "</td>";
                echo "<td>" . $row["primises_id"] . "</td>";
                echo "<td>" . $row["employee_id"] . "</td>";
                echo "<td>" . $row["service_id"] . "</td>";
                echo "<td>" . $row["sell_abonement_id"] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
            $result->free();
        } else {
            echo "Ошибка: " . $con->error;
        }
        ?>
        <?php include("includes/footer.php"); ?>
    </div>
</div>
</div>
