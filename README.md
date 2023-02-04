# お勉強同好会のぺーじ

自身の環境で動かす場合は下記の設定を行って下さい

## DB接続設定(必須)

```text
phpフォルダ直下に
DbPass.php
ファイルを作成
```

↑DB自体はなんとかして自力で準備してください←  
XAMPPとかMAMPインストールすればなんとかなるはずです！！

### Db.Pass.php 中身

```text
<?php

define('HOST', '');    // ホスト情報(ローカルのDBだったら127.0.0.1でいけるはず。)
define('DBNAME', '');  // 使用するデータベース名
define('DBUSER', '');  // ユーザー名(XAMPPやMAMPの場合はrootとかの印象)
define('DBPASS', '');  // パスワード(XAMPPなら空、MAMPはpasswordがデフォルト？そうじゃない場合は各自で調査してください←)
```

↑HOST, DBNAME, DBUSER, DBPASS は各自の環境に合わせて設定

## Tailwind CSS 環境設定(必須ではない)

### ・モジュールをインストール

下記コマンド実行  
`npm install`

(Node.js入れてない方は入れておいて下さい)  
(正確にはnpmっていうのが必要らしいです)

### ・開発モードで使う

下記コマンド実行で開発モード(JIT Mode)が起動します  
`npm run jit`

あとはTailwindで使えるクラスをHTMLファイルに設定すれば適応されます！  
VSCodeをお使いの方は、拡張機能「Tailwind CSS IntelliSence」の導入を強くオススメします！！  
クラス名の補完が効くようになり、そのクラスのCSSも小窓でプレビューしてくれたりします。  
(なのでエディタはVSCodeがオススメ)

開発モードを終了する場合は、ターミナルで  
`ctrl + C`  

### ・本番用にCSSファイルをビルド

下記コマンド叩いてくれれば良いです  
`npm run build`
