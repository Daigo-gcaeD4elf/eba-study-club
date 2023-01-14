/* 部員_権限を持つ方のみ */
CREATE TABLE master_admin_member (
    admin_member_id            SMALLINT NOT NULL      /* ID (master_memberのmember_idと紐づけ) */
    ,member_user_id            VARCHAR(20) UNIQUE     /* メンバーのユーザーID(EBAメールアドレスの@より前) */
    ,member_user_pass          TEXT                   /* メンバーのユーザーID(EBAメールアドレスの@より前) */
    ,PRIMARY KEY(admin_member_id)
);