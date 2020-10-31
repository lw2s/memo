<?php

namespace App;

class Command
{
    /** コマンドラインで入力したオブション */
    private $option;
    /** オプションをクラス名にしたもの */
    private $className;

    /**
     * コマンドライン引数があればオプションプロパティに設定
     */
    public function __construct()
    {
        if (isset($_SERVER["argv"][1])) {
            $this->option = $_SERVER["argv"][1];
        }
    }

    /**
     * 入力されたオプションをクラス名にする
     */
    public function convertOptionName()
    {
        $optionList = [
            "-h" => "History",
        ];

        $this->className = $optionList[$this->option];
    }

    /**
     * インスタンス生成
     */
    public function createInstance()
    {
        $class = __NAMESPACE__ . '\\' .  $this->className;
        return new $class;
    }

    /**
     * 実行
     */
    public function run()
    {
        if (isset($this->option)) {
            $this->convertOptionName();
            $instance = $this->createInstance();
            $instance->execute();
        } else {
            $instance = new Text;
            $instance->execute();
        }
    }
}
