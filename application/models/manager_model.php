<?php
/**
 * Created by PhpStorm.
 * User: Anya
 * Date: 07.05.2019
 * Time: 22:57
 */

class Manager_Model extends Model
{
    public function get_users()
    {
        require_once 'mysqlconnector.php';

        $mySQLConnector = MySQLConnector::getInstance();

        $query = "SELECT * FROM users WHERE admin_level = 0;";
        $data = $mySQLConnector->getQueryResult($query);

        $users = array();
        foreach ($data as $elem) {
            $query = "SELECT * FROM recipes WHERE username = '" . $elem['name'] . "';";
            $recipes = $mySQLConnector->getQueryResultWithoutTransformation($query);
            $count = $mySQLConnector->getRowsNumber($recipes);

            $faves = explode(' ', $elem['fav_recipes']);
            $faves = \array_diff($faves, ['']);
            $fav_count = 0;
            if (is_array($faves))
                $fav_count = count($faves);

            $users[] = array(
                'id' => $elem['id'],
                'name' => $elem['name'],
                'img' => $elem['img'],
                'fav_recipes' => $fav_count,
                'recipes' => $count,
            );
        }
        return $users;
    }

    public function get_admins()
    {
        require_once 'mysqlconnector.php';
        $mySQLConnector = MySQLConnector::getInstance();

        $query = "SELECT * FROM users WHERE admin_level > 0;";
        $data = $mySQLConnector->getQueryResult($query);

        $admins = array();
        foreach ($data as $elem) {
            $admins[] = array(
                'id' => $elem['id'],
                'name' => $elem['name'],
                'img' => $elem['img'],
                'admin_level' => $elem['admin_level'],
            );
        }
        return $admins;
    }

    public function get_votes()
    {
        require_once 'mysqlconnector.php';

        $mySQLConnector = MySQLConnector::getInstance();

        $query = "SELECT * FROM votes;";
        $data = $mySQLConnector->getQueryResult($query);

        $votes = array();
        foreach ($data as $elem) {
            $votes[] = array(
                'id' => $elem['id'],
                'name' => $elem['name'],
                'info' => $elem['info'],
                'var1' => $elem['var1'],
                'var2' => $elem['var2'],
                'var3' => $elem['var3'],
                'var4' => $elem['var4'],
            );
        }
        return $votes;
    }

    public function get_recipes()
    {
        require_once 'mysqlconnector.php';
        $mySQLConnector = MySQLConnector::getInstance();

        $query = "SELECT * FROM recipes;";
        $data = $mySQLConnector->getQueryResult($query);

        $recipes = array();
        foreach ($data as $elem) {
            $recipes[] = array(
                'id' => $elem['id'],
                'name' => $elem['name'],
                'img' => $elem['img'],
                'portions' => $elem['portions'],
                'calories' => $elem['calories'],
                'time' => date("h:i", strtotime($elem['time'])),
                'ingredients' => $elem['ingredients'],
                'username' => $elem['username'],
            );
        }
        $recipes = $this->customMultiSort($recipes, 'name');
        return $recipes;
    }

    private function customMultiSort($array, $field)
    {
        $sortArr = array();
        foreach ($array as $key => $val) {
            $sortArr[$key] = $val[$field];
        }
        array_multisort($sortArr, $array);
        return $array;
    }

    public function has_user()
    {
        require_once 'mysqlconnector.php';
        $mysqlconnector = MySQLConnector::getInstance();
        $res = $mysqlconnector->getQueryResultWithoutTransformation("SELECT * FROM users WHERE name='" . $_SESSION['session_username'] . "';");
        return $mysqlconnector->getRowsNumber($res);
    }

    public function get_name_by_id($id)
    {
        require_once "mysqlconnector.php";
        $mysqlconnector = MySQLConnector::getInstance();

        $query = "SELECT name FROM users WHERE id = $id;";
        return $mysqlconnector->getSingleValue($query, 'name');
    }

    public function delete_by_id($id, $table)
    {
        require_once "mysqlconnector.php";
        $mysqlconnector = MySQLConnector::getInstance();

        $query = "DELETE FROM $table WHERE id = $id;";
        $mysqlconnector->executeQuery($query);
    }

    public function get_comments()
    {
        require_once 'mysqlconnector.php';

        $mySQLConnector = MySQLConnector::getInstance();

        $query = "SELECT * FROM comments WHERE accepted = 0";
        $data = $mySQLConnector->getQueryResult($query);

        $comments = array();
        foreach ($data as $elem) {
            $comments[] = array(
                'id' => $elem['id'],
                'text' => $elem['text'],
            );
        }
        return $comments;
    }

    public function accept_data()
    {
        require_once 'mysqlconnector.php';

        $mySQLConnector = MySQLConnector::getInstance();

        foreach ($_POST['comments'] as $comment) {
            $query = "UPDATE comments SET accepted = 1 WHERE id = $comment;";
            $mySQLConnector->executeQuery($query);
            $this->send_email($comment);
        }
    }

    public function delete_data()
    {
        require_once 'mysqlconnector.php';

        $mySQLConnector = MySQLConnector::getInstance();

        var_dump($_POST['comments']);
        foreach ($_POST['comments'] as $comment) {
            $query = "DELETE FROM comments WHERE id = $comment;";
            $mySQLConnector->executeQuery($query);
        }
    }

    private function send_email($id)
    {
        require_once 'mysqlconnector.php';

        $mySQLConnector = MySQLConnector::getInstance();

        $query = "SELECT * FROM comments WHERE id = $id;";
        $comment_info = $mySQLConnector->getQueryResult($query);

        $rec_id = $comment_info[0]['recipe_id'];
        $username = $this->get_user_id_by_recipe_id($rec_id);

        $query = "SELECT * FROM users WHERE name = '$username';";
        $user_info = $mySQLConnector->getQueryResult($query);
        $subscribed = $user_info[0]['subscribed'];

        if (strcmp($subscribed, 'yes') == 0) {

            $email = $user_info[0]['email'];
            $text = $comment_info[0]['text'];

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

            mail($email, $subject, $message, $headers);
        }
    }

    public function user_exists($id)
    {
        require_once 'mysqlconnector.php';

        $mySQLConnector = MySQLConnector::getInstance();

        $query = "SELECT username FROM recipes WHERE id = $id;";
        $user = $mySQLConnector->getQueryResultWithoutTransformation($query);
        return $mySQLConnector->getRowsNumber($user);
    }

    public function get_user_id_by_recipe_id($recipe_id)
    {
        require_once 'mysqlconnector.php';

        $mySQLConnector = MySQLConnector::getInstance();

        $query = "SELECT username FROM recipes WHERE id = $recipe_id;";
        $name = $mySQLConnector->getSingleValue($query, 'username');

        $query = "SELECT id FROM users WHERE name = '$name';";
        $id = $mySQLConnector->getSingleValue($query, 'id');

        echo $id;
        return $id;
    }

    public function delete_notice($id, $message)
    {
        require_once 'mysqlconnector.php';

        $mySQLConnector = MySQLConnector::getInstance();

        $query = "SELECT email FROM users WHERE id = $id;";
        $email = $mySQLConnector->getSingleValue($query, 'email');

        $subject = "Important!";

        $headers = "From: Yom.com <yom.com.recipes@gmail.com>\r\n";
        $headers .= "Reply-To: keklolpukger@gmail.com\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=windows-1251 \r\n";

        mail($email, $subject, $message, $headers);
    }
}