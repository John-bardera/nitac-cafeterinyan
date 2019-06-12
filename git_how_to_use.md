## branchの作り方移動
### branch一覧表示
`git branch`
### hogeという名前のbranchを作成
`git branch hoge`
### hogeという名前のbranchへ移動
`git checkout hoge`
### remotes(空に打ち上がってる)のbranchを表示
`git branch -a`

これで出てきた`remotes/~~`がremotesのbranch
### remotesをlocalにコピー
`git checkout -b ~~ origin/~~`

`remotes/origin/~~`を入力するんやで(remoteは入力するとき省略)
### `git branch hoge` と `git checkout hoge` を一緒に行う
`git checkout -b hoge`

## ファイルを変更したら
### 変更したファイルをgitちゃんに教える
`git add ./`

./のファイル全てをadd(変更したよ！記録をする)
### gitちゃんに変更したファイルたちがこれだけであることを教えてあげる
`git commit -m "hogeを実装しました！"`

"hogeを実装しました！"ってaddしたファイルの集合にタイトルをつけるイメージ
### ファイルの集合を空高く打ち上げる
`git push origin ~~`

\~\~には自分が今いるbranch(`git branch`で\*がついてるやつ)
これを実行して初めて他のPCからでも確認できる

これらはこの順番で実行しないといけない
`git add ./`
`git commit -m "hoge"`
`git push origin nyan`