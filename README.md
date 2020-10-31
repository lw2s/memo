# memo 

## 概要

一言メモや過去に実行したコマンドをメモ（txtファイルに保存）する

```
memo [-h]
```

## 必要

- PHP7以上
- Composer
- zsh

## インストール

```
$ git clone https://github.com/lw2s/memo.git
$ cd memo
$ composer install
```

## 設定

.zshrcに以下を書き込む
```
// $HOME/.zshrc

export PATH=$HOME/memo:$PATH
```

読み込む
```
$ source ~/.zshrc
```

memoのパーミッションを755に変更

```
$ cd memo
$ chmod 755 memo
```

## オプション

|  オプション  |  内容  |
| ---- | ---- |
|  なし |   入力されたtextを保存   |
|  -h  |  過去に実行したコマンドを保存 |

## 使用例

- **オプションなし**
```
$ memo

Please input text: なにか入力
```

- **-h**

_複数の数字を入力する場合_

1つ数字入力、1つ空白を空ける

 ```
$ memo -h
 
977:　git push
976:　git diff origin/main
975:　git diff
973:　git checkout main
972:　git checkout master

Please choose a number or some numbers: 977 972
 ```

_1つの数字を入力する場合_

```
$ memo -h
 
977:　git push
976:　git diff origin/main
975:　git diff
973:　git checkout main
972:　git checkout master

Please choose a number or some numbers: 977
 ```