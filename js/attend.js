// fetch API 使用時に送るパラメータ bodyは呼び出し前に指定
let param = {
    method : 'POST',
    headers: { 'Content-Type': 'application/json' },
}

let mailAccoutInputTag = document.getElementById('js_mail_account');
let domainSelectTag    = document.getElementById('js_domain');
let attendMsgTag       = document.getElementById('js_attend_message');

// ローカルストレージが残っていれば、自動でメールアカウントを入力
let ebaEmproyeeNoByLocalStorage = localStorage.getItem('ebaEmproyeeNo');

console.log('ebaEmproyeeNoByLocalStorage : ' + ebaEmproyeeNoByLocalStorage);

if (ebaEmproyeeNoByLocalStorage) {

    let fetchUserInfoParams = {
        functionName : 'fetchUserInfoByLocalStorage',
        data : {
            emproyeeNo : ebaEmproyeeNoByLocalStorage,
        }
    }
    param.body = JSON.stringify(fetchUserInfoParams);

    fetch('../php/attend.php', param)
    .then(response => response.json())
    .then((res) => {
        if (res) {
            mailAccoutInputTag.value = res.mail_account;
            domainSelectTag.value = res.domain;
        }
    });
}

// 出席ボタン押下で出席登録
let attendBtn = document.getElementById('js_attend_button');
attendBtn.addEventListener('click', () => {

    attendMsgTag.innerText = '';

    let inputtedParams = {
        functionName : 'attend',
        data : {
            mailAccount : mailAccoutInputTag.value,
            domain : domainSelectTag.value,
        }
    }
    param.body = JSON.stringify(inputtedParams);

    fetch('../php/attend.php', param)
    .then(response => response.json())
    .then((res) => {
        // メッセージを表示
        attendMsgTag.innerText = res.msg;

        // ローカルストレージに保存
        if (res.returnCode === '0' && res.emproyeeNo !== Number(ebaEmproyeeNoByLocalStorage)) {
            console.log('ローカルストレージ保存するやで');
            localStorage.setItem('ebaEmproyeeNo', res.emproyeeNo);
        } else {
            console.log('ローカルストレージ保存できぬ');
        }
    });
})

