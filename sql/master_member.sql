DROP TABLE IF EXISTS master_member;

/* 部員情報 */
CREATE TABLE master_member (
    emproyee_no       SMALLINT UNSIGNED DEFAULT NULL /* 社員番号 */
    ,mail_account     VARCHAR(20)                    /* EBAメールアドレスの@より前 ログインで使用 */
    ,domain           VARCHAR(30)                    /* ドメイン */
    ,member_name      VARCHAR(20)                    /* メンバー名(漢字表記) */
    ,member_name_kana VARCHAR(20)                    /* メンバー名(ふりがな) */
    ,guest_flg        TINYINT                        /* 0:通常の部員 1:同好会に3つ以上在籍しているためゲストとして扱う */
    ,PRIMARY KEY(mail_account, domain)
);
