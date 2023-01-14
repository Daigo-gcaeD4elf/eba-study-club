<?php
require_once('Db.php');
require_once('common_function.php');

class Attend extends Db
{
    private $__memberUserId = 't.masaki';

    public function __construct($memberUserId)
    {
        parent::__construct();
        $this->__memberUserId = $memberUserId;
    }

    /**
     * ユーザー存在確認
     *
     * @return array
     */
    public function checkMemberExist()
    {
        $sql = 'SELECT COUNT(member_id) AS member_exist, member_name FROM master_member WHERE member_user_id = :member_user_id';
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute([':member_user_id' => $this->__memberUserId]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * 出席状況チェック
     *
     * @return int
     */
    public function checkAttendance()
    {
        $sql = 'SELECT COUNT(member_id) FROM attendance WHERE member_user_id = :member_user_id AND event_date = DATE_FORMAT(NOW(), \'%Y%m%d\')';
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute([':member_user_id' => $this->__memberUserId]);

        return $stmt->fetch(PDO::FETCH_COLUMN);
    }

    /**
     * 出席登録
     *
     * @return void
     */
    public function resisterAttendance()
    {
        $sql = 'INSERT INTO attendance';
        $sql .= ' (member_id, member_user_id, member_name, member_name_kana, guest_flg, emproyee_no, event_date)';
        $sql .= ' SELECT';
        $sql .= ' member_id, member_user_id, member_name, member_name_kana, guest_flg, emproyee_no, DATE_FORMAT(NOW(), \'%Y%m%d\')';
        $sql .= ' FROM master_member';
        $sql .= ' WHERE member_user_id = :member_user_id';

        $stmt = $this->dbh->prepare($sql);
        $stmt->execute([':member_user_id' => $this->__memberUserId]);
    }
}

if (!empty($_POST['member_user_id'])) {
    try {
        $attend = new Attend($_POST['member_user_id']);

        $member = $attend->checkMemberExist();
        var_dump($member);
        if (empty($member['member_exist'])) {
            $msg = 'ユーザーが見つかりません';
            throw new Exception('マスタに登録が見つかりません。ユーザーID:'. $_POST['member_user_id']);
        }

        if ((int)$attend->checkAttendance() > 0) {
            $msg = '出席登録済です';
            throw new Exception('出席登録済。ユーザーID:'. $_POST['member_user_id']);
        }

        $attend->resisterAttendance();
        $msg = $member['member_name']. 'さん、出席を登録しました。';

    } catch (Exception $e) {
        // $msg = $e->getMessage();
    }
}

require_once('../html/attend.html');