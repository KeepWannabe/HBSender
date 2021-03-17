<?php
error_reporting(0);
// COLOR
$colors = array("green" => "\e[92m","purple" => "\033[0;35m","cyan" => "\033[0;36m","red" => "\033[0;31m","white" => "\033[0;37m","yellow" => "\e[0;33m");

function banner() {
global $colors;
system('clear');
echo $colors["purple"] ."
._____. ._____.
| ._. | | ._. |
| !_| |_|_|_! | ". $colors["white"] ."HYPEBROTHER CHECKER". $colors["purple"] ."
!___| |_______! ". $colors["green"] ."WANNABE IS A KEYS". $colors["cyan"] ."
.___". $colors["purple"] ."|". $colors["cyan"] ."_". $colors["purple"] ."|". $colors["cyan"] ."_| |___. ". $colors["white"] ."---------------". $colors["cyan"] ."
| ._____| |_. | ". $colors["green"] ."PLIVO". $colors["white"] ." CHECKER". $colors["cyan"] ."
| !_! | | !_! |
!_____! !_____!
". $colors["white"] ."

";
}
banner();

$time = date('D, d F Y, h:i:s');

//INPUT LIST
$inputlist = readline("[!] Input List : ".PHP_EOL);
if( !file_exists($inputlist))
die("[!]" . $colors["red"] ." File Not Found.");
echo "".PHP_EOL;

//PARSING
$parsing_list = explode("\r\n", file_get_contents($inputlist));
foreach($parsing_list as $key => $loop_check) {
$credential = explode("|", $loop_check);

// CHECK ACCOUNT 
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://api.plivo.com/v1/Account/'.$credential[0].'/');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

curl_setopt($ch, CURLOPT_USERPWD, $credential[0]. ':' .$credential[1]);

$result = curl_exec($ch);
if (preg_match('/Could not verify your access level for that URL./i', $result)) {
    echo $colors["white"]."[".$colors["red"]."✗".$colors["white"]."]———[".$colors["yellow"]." $time ".$colors["white"]."]—[".$colors["red"]." $credential[0] ".$colors["white"]."]".PHP_EOL;
} else {
$accountinfo = json_decode($result);
$balanceinfo = $accountinfo->cash_credits;
$rechargeinfo = $accountinfo->auto_recharge;

if ($rechargeinfo == 1) {
    echo $colors["white"]."[".$colors["green"]."✓".$colors["white"]."]———[".$colors["yellow"]." $time ".$colors["white"]."]—[".$colors["green"]." $credential[0] ".$colors["white"]."]—[BALANCE : ".$colors["green"]."$balanceinfo ".$colors["white"]."]—[ AUTO RECHARGE : ".$colors["green"]."TRUE ".$colors["white"]."]—[".$colors["purple"]." HYPE".$colors["cyan"]."BROTHER".$colors["white"]." CHECKER ]".PHP_EOL;
    $save = @fopen("valid_apikey_plivo.txt", "a");
    fwrite($save, $loop_check . "|[Balance : " . $balanceinfo . "]|[auto_recharge: true]" . "\n");
    fclose($save);
}
    else {
    echo $colors["white"]."[".$colors["green"]."✓".$colors["white"]."]———[".$colors["yellow"]." $time ".$colors["white"]."]—[".$colors["green"]." $credential[0] ".$colors["white"]."]—[ AUTO RECHARGE : ".$colors["red"]."FALSE ".$colors["white"]."]—[".$colors["purple"]." HYPE".$colors["cyan"]."BROTHER".$colors["white"]." CHECKER ]".PHP_EOL;
    $save = @fopen("valid_apikey_plivo.txt", "a");
    fwrite($save, $loop_check . "|[Balance : " . $balanceinfo . "]|[auto_recharge: false]" . "\n");
    fclose($save);
}
}
curl_close($ch);
}
