# memo

## 概要

一言メモや過去に実行したコマンドをメモ（txt ファイルに保存）する

```
memo [-h]
```

## 必要

- PHP7 以上
- Composer
- zsh

## インストール

```
$ git clone https://github.com/lw2s/memo.git
$ cd memo
$ composer install
```

## 設定

.zshrc に以下を書き込む

```
// $HOME/.zshrc

export PATH=$HOME/memo:$PATH
```

読み込む

```
$ source ~/.zshrc
```

memo のパーミッションを 755 に変更

```
$ cd memo
$ chmod 755 memo
```

## オプション

| オプション | 内容                         |
| ---------- | ---------------------------- |
| なし       | 入力された text を保存       |
| -h         | 過去に実行したコマンドを保存 |

## 使用例

- **オプションなし**

```
$ memo

Please input text: なにか入力
```

- **-h**

_複数の数字を入力する場合_

1 つ数字入力、1 つ空白を空ける

```
$ memo -h

972:　git checkout master
973:　git checkout main
975:　git diff
976:　git diff origin/main
977:　git push

Please choose a number or some numbers: 977 972
```

_1 つの数字を入力する場合_

```
$ memo -h

972:　git checkout master
973:　git checkout main
975:　git diff
976:　git diff origin/main
977:　git push

Please choose a number or some numbers: 977
```
