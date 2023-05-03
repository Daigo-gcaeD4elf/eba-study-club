<?php
require_once('Db.php');
require_once('common_function.php');

class EbaStudyTop extends Db
{
    private $__memberUserId = 't.masaki';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 最新の出席者一覧
     *
     * @return array
     */
    public function fetchAttendedMembers()
    {
        $sql = 'SELECT';
        $sql .= ' member_name, guest_flg, trial_flg';
        $sql .= ' FROM attendance';
        $sql .= ' WHERE';
        $sql .= ' event_date = DATE_FORMAT(NOW(), \'%Y%m%d\')';
        $sql .= ' ORDER BY';
        $sql .= ' trial_flg ASC';
        $sql .= ' ,guest_flg ASC';
        $sql .= ' ,emproyee_no ASC';

        $stmt = $this->dbh->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

$msg = '';
$inputtedMemberUserId = '';

$ebaStudyTop = new EbaStudyTop();

try {
    // 出席者(テキストボックスに描写予定)
    $attendedMembers = $ebaStudyTop->fetchAttendedMembers();

    // todoEba投稿用にテキスト編集
    $attendedMembersText = '';
    foreach ($attendedMembers as $member) {
        $attendedMembersText .= $member['member_name'];
        if ($member['guest_flg'] === '1') {
            $attendedMembersText .= '(ゲスト)';
        }
        if ($member['trial_flg'] === '1') {
            $attendedMembersText .= '(体験)';
        }
        $attendedMembersText .= PHP_EOL;
    }

} catch (Exception $e) {
    echo $e->getMessage();
}

// todoEba投稿者


require_once('../html/eba_study_top.html');