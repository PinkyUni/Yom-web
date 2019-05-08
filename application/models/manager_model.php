<?php
/**
 * Created by PhpStorm.
 * User: Anya
 * Date: 07.05.2019
 * Time: 22:57
 */

class Manager_Model extends Model
{
    public function get_votes()
    {
        require_once 'mysqlconnector.php';

        $mySQLConnector = MySQLConnector::getInstance();

        $query = "SELECT * FROM votes";
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

    public function delete_voting($id) {
        require_once "mysqlconnector.php";
        $mysqlconnector = MySQLConnector::getInstance();

        $query = "DELETE FROM votes WHERE id = $id;";
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

        $query = "SELECT username FROM recipes WHERE id = $rec_id;";
        $username = $mySQLConnector->getSingleValue($query, 'username');

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

            $res = mail($email, $subject, $message, $headers);
        }
    }
}