<?php

namespace App;

class History
{
    /** 最新50件のhistory */
    private $limit = 50;
    /** .zsh_history ファイル */
    private $history_file;
    /** 複数選んだ時に値をあてる */
    private $history_numbers;
    /** 1つだけ選んだ時に値をあてる */
    private $history_number;

    /**
     * Historyコンストラクタ
     * .zsh_historyを読み込み、history_fileに設定
     */
    public function __construct()
    {
        // ホームディレクトリの.zsh_historyを読み込み
        $this->history_file = file(posix_getpwuid(posix_geteuid())['dir'] . "/.zsh_history");
    }

    /**
     * コマンドラインでHistoryが選択された場合に実行
     */
    public function execute()
    {
        $this->displayHistory();
        $this->inputCommandLine();
        $this->register();
    }

    /**
     * 最新のhistoryを取得
     */
    public function displayHistory()
    {
        // historyから重複したコマンドを取り除く
        $commands = $this->removeDuplicate();
 
        foreach ($commands as $command => $line) {
            // historyを表示
            echo $line . ":　" . $command;
        }
    }

    /**
     * historyから重複したコマンドを取り除く
     * 
     * @return array
     */
    private function removeDuplicate()
    {
        $endline = count($this->history_file);
        $duplicate = [];
        for ($line = $endline; $endline - $this->limit < $line; $line--) {
            // ; 前後で分割
            $explode_line = explode(";", $this->history_file[$line - 1]);
            // 分割された場合と分割する必要が無かった場合
            if (isset($explode_line[1])) {
                $index = $explode_line[1];
            } else {
                $index = $explode_line[0];
            }
            // コマンドをインデックスに、行番号をvalueにして配列に格納
            $duplicate[$index] = $line;

            if ($line === 0) break;
        }

        return $duplicate;
    }

    /**
     * 数字を空白区切りで入力
     * 複数入力した場合と単数入力で処理を分ける
     */
    public function inputCommandLine()
    {
        echo "\n";
        $str = "Please choose a number or some numbers: ";
        // 緑色で表示
        echo "\033[0;32m$str\033[0m";
        // 標準入力受け付けて、末尾の文字（改行）を取り除く
        $tmp = trim(fgets(STDIN));
        // 空白文字で区切って配列に格納
        if (strpos($tmp, " ")) {
            $explode_tmp = explode(" ", $tmp);
            // 重複した値は削除
            $this->history_numbers = array_unique($explode_tmp);
        } else {
            $this->history_number = $tmp;
        }
    }

    /**
     * メモの登録
     * 複数入力した場合と単数入力で処理を分ける
     */
    public function register()
    {
        if (isset($this->history_numbers)) {
            $this->registerMultipleHistory();
        }
        if (isset($this->history_number)) {
            $this->registerSingleHistory();
        }
    }

    /**
     * 複数数字を入力した場合に複数のコマンドをTXTファイルに書き込む
     */
    public function registerMultipleHistory()
    {
        $contents = "";
        foreach ($this->history_numbers as $history_num)
        {
            $contents .= $this->explode_line($this->history_file[$history_num - 1]);
        }
        file_put_contents(__DIR__ . "/../storage/memo_history.txt", $contents);
    }

    /**
     * 単数の数字を入力した場合に1つのコマンドをTXTファイルに書き込む
     */
    public function registerSingleHistory()
    {
        $history_line = $this->explode_line($this->history_file[$this->history_number - 1]);
        file_put_contents(__DIR__ . "/../storage/single_memo_history.txt", $history_line);
    }

    /**
     * コマンドのみを取り出す
     * 
     * @param string $line
     * @return string
     */
    private function explode_line($line)
    {
        // ;前後で分割
        $explode_line = explode(";", $line);
        // $を頭に付け加えたコマンド（テキスト）を返す
        return "$ " . $explode_line[1];
    }
}