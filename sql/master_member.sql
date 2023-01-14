/* 部員情報 */
CREATE TABLE master_member (
    member_id                  SMALLINT NOT NULL      /* ID */
    ,member_user_id            VARCHAR(20) UNIQUE     /* メンバーのユーザーID(EBAメールアドレスの@より前) */
    ,member_name               VARCHAR(20)            /* メンバー名(漢字表記) */
    ,member_name_kana          VARCHAR(20)            /* メンバー名(ふりがな) */
    ,guest_flg                 TINYINT                /* 0:通常の部員 1:同好会に3つ以上在籍しているためゲストとして扱う */
    ,emproyee_no               SMALLINT DEFAULT NULL  /* 社員番号 */
    ,PRIMARY KEY(member_id)
);
