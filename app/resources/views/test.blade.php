<?php
class NumPrint
{
    // プロパティ
    public $num = 0;
    // staticプロパティ
    public static $staticNum = 0;
    public function addNum()
    {
        // プロパティを加算
        $this->num++;
        // staticプロパティを加算
        self::$staticNum++;
    }
}

$numPrint = new NumPrint();
$numPrint->addNum();

print "プロパティの値" . $numPrint->num;
print ", staticプロパティの値" . NumPrint::$staticNum;

$numPrint2 = new NumPrint();
$numPrint2->addNum();

print "<br />プロパティの値" . $numPrint->num;
print ", staticプロパティの値" . NumPrint::$staticNum;
