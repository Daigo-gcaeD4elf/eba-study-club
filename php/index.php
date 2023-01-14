<?php
require_once('Db.php');
// echo 'どうして・・・';

class AdminLogin extends Db
{
    public function getMemberName()
    {
        $members = [];
        try {
            $sql = 'SELECT member_name, member_name_kana FROM master_member';
            $stmt = $this->dbh->query($sql);
            
            $members = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        return $members;
    }
}

$member = new AdminLogin();
var_dump($member->getMemberName());


// $sql = 'SELECT member_name, member_kana FROM admin_member WHERE admin_member_name = :name';
// $stmt = $this->dbh->prepare($sql);
// $stmt->execute([':name' => $_POST['username']]);

// $dbPass = $stmt->fetchAll(PDO::FETCH_COLUMN);

// return password_verify($_POST['pass'], $dbPass[0]);
