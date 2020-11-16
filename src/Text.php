<?php

namespace App;

class Text
{
    /** コマンドラインで入力されたテキスト */
    private $text;
    private $filename;

    public function __construct()
    {
        $this->filename = date("YmdHis") . "_memo.txt";
    }

    /**
     * コマンドラインで何もパラメータがついていない場合実行
     */
    public function execute()
    {
        $this->display();
        $this->inputText();
        $this->register();
    }

    /**
     * テキストの入力受付
     */
    public function display()
    {
        $text = "Please input text: ";
        // 緑色で表示
        echo "\033[0;32m$text\033[0m";
    }

    /**
     * 入力されたテキストをプロパティに設定
     */
    public function inputText()
    {
        // 標準入力受け付けて、末尾の文字（改行）を取り除く
        $this->text = trim(fgets(STDIN));
    }

    /**
     * 入力されたテキストをTXTファイルに書き出し
     */
    public function register()
    {
        file_put_contents(__DIR__ . "/../storage/" . $this->filename, $this->text);
    }
}