/* 履歴系 */
DROP TABLE IF EXISTS attendance;

/* 出席者 履歴 ※欠席の場合はレコードが残らない */
CREATE TABLE attendance (
    mail_account     VARCHAR(20)                /* EBAメールアドレスの@より前 */
    ,domain           VARCHAR(30)                /* メンバーのドメイン */
    ,member_name      VARCHAR(20)                /* メンバー名(漢字表記) */
    ,member_name_kana VARCHAR(20)                /* メンバー名(参加日) */
    ,guest_flg        TINYINT                    /* 0:通常の部員 1:同好会に3つ以上在籍しているためゲストとして扱う */
    ,trial_flg        TINYINT  DEFAULT 0         /* 0:通常参加 1:体験参加 */
    ,event_date       CHAR(8)                    /* 同好会に参加した日 */
    ,PRIMARY KEY(event_date, mail_account, domain)
);