<?php
/**
 * Created by PhpStorm.
 * User: Anya
 * Date: 30.04.2019
 * Time: 12:40
 */

class Recipe_Model extends Model
{

    public function get_data($id)
    {
        $recipe = $this->get_recipe($id);
        $comments = $this->get_comments($id);
        $data = array(
            'recipe' => $recipe,
            'comments' => $comments,
        );
        return $data;
    }

    public function get_recipe($id)
    {
        require_once 'mysqlconnector.php';

        $mySQLConnector = MySQLConnector::getInstance();

        $table = "recipes";

        $query = "SELECT * FROM $table WHERE id = $id";
        $data = $mySQLConnector->getQueryResult($query);

        if (count($data)) {
            foreach ($data as $elem) {
                $recipe = array(
                    'username' => $elem['username'],
                    'id' => $elem['id'],
                    'name' => $elem['name'],
                    'img' => $elem['img'],
                    'portions' => $elem['portions'],
                    'calories' => $elem['calories'],
                    'time' => date("h:i", strtotime($elem['time'])),
                    'ingredients' => $elem['ingredients'],
                    'cooking' => $elem['cooking'],
                );
            }
            return $recipe;
        } else
            header("Location: /error");
    }

    public function add_comment($id)
    {
        if (isset($_SESSION['session_username'])) {
            if (isset($_POST['place']) && !empty($_POST['comment-text'])) {

                require_once 'mysqlconnector.php';

                $mySQLConnector = MySQLConnector::getInstance();

                $username = $_SESSION['session_username'];
                $img = $_SESSION['user_img'];
                $text = trim($_POST['comment-text']);
                date_default_timezone_set('Europe/Minsk');
                $time = date("Y-m-d H:i:s");

                $query = "INSERT INTO comments (recipe_id, username, img, text, time, accepted) VALUES ($id, '$username', '$img', '$text', '$time', 0);";
                $res = $mySQLConnector->executeQuery($query);

                if ($res) {
                    $this->mail_admin();
                }
            }
        } else {
            header("Location: /login");
        }
    }

    private function mail_admin($username = 'admin') {
        require_once 'mysqlconnector.php';

        $mySQLConnector = MySQLConnector::getInstance();

            $query = "SELECT email FROM users WHERE name = '$username';";
            $email = $mySQLConnector->getSingleValue($query, 'email');

            $subject = "New comment!";

            $message = "<p>There's a new comment! Check it <a href='yom.com/comments_manager' style='color: gold;'>here</a></p>";

            $headers = "From: Yom.com <yom.com.recipes@gmail.com>\r\n";
            $headers .= "Reply-To: keklolpukger@gmail.com\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-type: text/html; charset=windows-1251 \r\n";

            mail($email, $subject, $message, $headers);
    }

    public function get_comments($id)
    {
        require_once 'mysqlconnector.php';

        $mySQLConnector = MySQLConnector::getInstance();

        $table = "comments";
        $comments = array();

        $query = "SELECT * FROM $table WHERE recipe_id = $id AND accepted = 1;";
        $data = $mySQLConnector->getQueryResult($query);

        foreach ($data as $elem) {
            $comments[] = array(
                'username' => $elem['username'],
                'img' => $elem['img'],
                'text' => $elem['text'],
                'time' => $elem['time'],
            );
        }
        return $comments;
    }
}