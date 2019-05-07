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

                $query = "INSERT INTO comments (id, username, img, text, time) VALUES ($id, '$username', '$img', '$text', '$time');";
                $res = $mySQLConnector->executeQuery($query);

                if ($res)
                    $this->send_email($id, $text);

            }
        } else {
            header("Location: /login");
        }
    }

    private function send_email($id, $text)
    {
        require_once 'mysqlconnector.php';

        $mySQLConnector = MySQLConnector::getInstance();

        $query = "SELECT username FROM recipes WHERE id = $id;";
        $username = $mySQLConnector->getSingleValue($query, 'username');

        $query = "SELECT subscribed FROM users WHERE name = '$username';";
        $subscribed = $mySQLConnector->getSingleValue($query, 'subscribed');

        if (strcmp($subscribed, 'yes') == 0) {

            $query = "SELECT email FROM users WHERE name = '$username';";
            $email = $mySQLConnector->getSingleValue($query, 'email');

            $subject = "New comment!";

            $link = "yom.com/recipe/$username/$id";
            $text = str_replace("\n", "<br>", $text);

            $message = '<section style="margin: 2vw 30%;padding: 2vw;text-align: center;border-radius: 5px;border: 1px solid #9e9e9e;font-family: Georgia, serif;color: #585858;">
            <nav><h1 style="margin: 0;padding: 0.5em 0;font-size: 3em;">Yom</h1></nav><hr style="width: 100%;"><article><h2 style="color: #edb025;">You have a new comment!</h2>
            <h3 style="color: #585858;">' . $username . ' posted a new comment under your recipe:</h3><div style="text-align: left;padding: 1vw;margin-bottom: 1vw;border: 1px solid #cccccc;border-radius: 10px;">
        ' . $text . '</div><div>Check <a href=' . $link . ' style="color: #e2b03f;">here.</a></div></article></section>';


            $headers = "From: Yom.com <yom.com.recipes@gmail.com>\r\n";
            $headers .= "Reply-To: keklolpukger@gmail.com\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-type: text/html; charset=windows-1251 \r\n";

            $res = mail($email, $subject, $message, $headers);
            var_dump($res);
        }
    }

    public function get_comments($id)
    {
        require_once 'mysqlconnector.php';

        $mySQLConnector = MySQLConnector::getInstance();

        $table = "comments";
        $comments = array();

        $query = "SELECT * FROM $table WHERE id = $id;";
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