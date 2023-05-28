/* 部員_権限を持つ方のみ */
DROP TABLE IF EXISTS master_admin_member;

CREATE TABLE master_admin_member (
    emproyee_no       SMALLINT UNSIGNED NOT NULL /* 社員番号 */
    ,mail_account     VARCHAR(20) UNIQUE         /* EBAメールアドレスの@より前 */
    ,domain           VARCHAR(30)                /* メンバーのドメイン */
    ,member_user_pass TEXT                       /* メンバーのパスワード */
    ,PRIMARY KEY(emproyee_no)
);