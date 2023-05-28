<?php
require_once('Db.php');
require_once('common_function.php');

class Yattemiyou extends Db
{
    const RETURN_CODE_SUCCESS = '0';
    const RETURN_CODE_FAILURE = '1';
    private $__isValidationError = '0';

    /**
     * ローカルストレージから社員情報を入手
     * @param object $post 社員番号
     *
     * @return array
     */
    public function fetchUserInfoByLocalStorage($post)
    {
        writeErrorLog(__FILE__, __FUNCTION__, __LINE__, '社員番号：'. $post->emproyeeNo. ' メールアドレスを取得');
        $res = [];
        try {
            $sql = 'SELECT emproyee_no, mail_account, domain FROM master_member WHERE emproyee_no = :emproyee_no';
            $stmt = $this->dbh->prepare($sql);
            $stmt->execute([':emproyee_no' => $post->emproyeeNo]);
            $res = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch(Exception $e) {
            writeErrorLog(__FILE__, '__FUNCTION__', __LINE__, $e->getMessage());
        }
        return $res;
    }

    /**
     * メールアドレスから社員情報を入手
     * @param object $post メールアカウントとドメイン
     *
     * @return array
     */

    /**
     * 出席ボタン押下時処理
     * ユーザー存在確認 ～ 出席済かどうか確認 ～ 出席登録
     * @param object
     *
     * @return array
    */
    public function attend($post)
    {
        writeErrorLog(__FILE__, __FUNCTION__, __LINE__, '出席登録開始！メールアドレス：'. $post->mailAccount. '@'. $post->domain);

        $msg = '';
        $returnCode = self::RETURN_CODE_SUCCESS;
        $emproyeeNo = '';

        $post->mailAccount = h($post->mailAccount);

        try {
            // ユーザー存在確認
            if (!$this->__checkMemberExist($post->mailAccount, $post->domain)) {
                $this->__isValidationError = '1';
                throw new Exception('マスタ登録がありません。');
            };

            // 出席済確認
            if ($this->__checkAttendance($post->mailAccount, $post->domain)) {
                $this->__isValidationError = '1';
                throw new Exception('本日は既に出席登録済です。');
            };

            // 社員番号取得
            $emproyeeNo = $this->__fetchEmoroyeeNo($post->mailAccount, $post->domain);

            // 出席登録
            $this->__resisterAttendance($post->mailAccount, $post->domain);
            $msg = '出席登録が完了しました！';
            writeErrorLog(__FILE__, __FUNCTION__, __LINE__, '出席登録完了！メールアドレス：'. $post->mailAccount. '@'. $post->domain);
        } catch(Exception $e) {
            writeErrorLog(__FILE__, '__FUNCTION__', __LINE__, $e->getMessage());
            $returnCode = self::RETURN_CODE_FAILURE;
            $msg = '登録に失敗しました。';
            writeErrorLog(__FILE__, __FUNCTION__, __LINE__, '出席登録失敗・・・、メールアドレス：'. $post->mailAccount. '@'. $post->domain);
            if ($this->__isValidationError === '1') {
                $msg = $e->getMessage();
            }
        }

        return ['msg' => $msg, 'returnCode' => $returnCode, 'emproyeeNo' => $emproyeeNo];
    }


    /**
     * ユーザー存在確認
     * @param string $mailAccount EBAメールアドレスの@より前
     * @param string $domain ドメイン
     *
     * @return bool
     */
    private function __checkMemberExist($mailAccount, $domain)
    {
        $sql = 'SELECT COUNT(emproyee_no) FROM master_member WHERE mail_account = :mail_account AND domain = :domain';
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute([':mail_account' => $mailAccount, ':domain' => $domain]);
        return !empty($stmt->fetchColumn());
    }

    /**
     * ユーザー存在確認
     * @param string $mailAccount EBAメールアドレスの@より前
     * @param string $domain ドメイン
     *
     * @return bool
     */
    private function __checkAttendance($mailAccount, $domain)
    {
        $sql = 'SELECT COUNT(mail_account) FROM attendance WHERE mail_account = :mail_account AND domain = :domain AND event_date = DATE_FORMAT(NOW(), \'%Y%m%d\')';
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute([':mail_account' => $mailAccount, ':domain' => $domain]);
        return !empty($stmt->fetchColumn());
    }

    /**
     * 社員番号取得
     * @param string $mailAccount EBAメールアドレスの@より前
     * @param string $domain ドメイン
     *
     * @return int
     */
    private function __fetchEmoroyeeNo($mailAccount, $domain)
    {
        $sql = 'SELECT emproyee_no FROM master_member WHERE mail_account = :mail_account AND domain = :domain';
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute([':mail_account' => $mailAccount, ':domain' => $domain]);
        return $stmt->fetchColumn();
    }

    /**
     * 出席登録
     * @param string $mailAccount EBAメールアドレスの@より前
     * @param string $domain ドメイン
     *
     * @return void
     */
    private function __resisterAttendance($mailAccount, $domain)
    {
        $sql = 'INSERT INTO attendance';
        $sql .= ' (mail_account, domain, member_name, member_name_kana, guest_flg, emproyee_no, event_date)';
        $sql .= ' SELECT';
        $sql .= ' mail_account, domain, member_name, member_name_kana, guest_flg, emproyee_no, DATE_FORMAT(NOW(), \'%Y%m%d\')';
        $sql .= ' FROM master_member';
        $sql .= ' WHERE mail_account = :mail_account AND domain = :domain';

        $stmt = $this->dbh->prepare($sql);
        $stmt->execute([':mail_account' => $mailAccount, ':domain' => $domain]);
    }
}

// POSTデータ受信
$raw = file_get_contents('php://input');
$param = json_decode($raw);

// 関数呼び出し～JSへ返還
$functionName = $param->functionName;
$yattemiyou = new Yattemiyou();
echo json_encode($yattemiyou->$functionName($param->data));
