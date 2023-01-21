/* 履歴系 */
/* 出席者 履歴 ※欠席の場合はレコードが残らない */
CREATE TABLE attendance (
    member_id            SMALLINT NOT NULL      /* ID (master_memberのmember_idと紐づけ) */
    ,member_user_id      VARCHAR(20)            /* メンバーのユーザーID(EBAメールアドレスの@より前) */
    ,member_name         VARCHAR(20)            /* メンバー名(漢字表記) */
    ,member_name_kana    VARCHAR(20)            /* メンバー名(参加日) */
    ,guest_flg           TINYINT                /* 0:通常の部員 1:同好会に3つ以上在籍しているためゲストとして扱う */
    ,trial_flg           TINYINT  DEFAULT 0     /* 0:通常参加 1:体験参加 */
    ,emproyee_no         SMALLINT DEFAULT NULL  /* 社員番号 */
    ,event_date          CHAR(8)                /* 同好会に参加した日 */
    ,PRIMARY KEY(event_date, member_id)
);