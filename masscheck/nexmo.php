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
| ._____| |_. | ". $colors["green"] ."NEXMO". $colors["white"] ." CHECKER". $colors["cyan"] ."
| !_! | | !_! |
!_____! !_____!
". $colors["white"] ."

";
}
banner();

//INPUT LIST
$inputlist = readline("[!] Input List : ".PHP_EOL);
if( !file_exists($inputlist))
die("[!]" . $colors["red"] ." File Not Found.");
$phonecheck = readline("[?] Phone Number to Test (+1*********) : ".PHP_EOL);
echo "".PHP_EOL;

//PARSING
$parsing_list = explode("\r\n", file_get_contents($inputlist));
foreach($parsing_list as $key => $loop_check) {
$credential = explode("|", $loop_check);

// TIME
$time = date('D, d F Y, h:i:s');

// CHECK ACCOUNT 
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://rest.nexmo.com/account/get-balance?api_key='.$credential[0].'&api_secret='.$credential[1]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

$result = curl_exec($ch);
curl_close($ch); 
if (preg_match('/{"error-code":"401","error-code-label":"authentication failed"}/i', $result)) {
    echo $colors["white"]."[".$colors["red"]."✗".$colors["white"]."]———[".$colors["yellow"]." $time ".$colors["white"]."]—[".$colors["red"]." $credential[0] ".$colors["white"]."]".PHP_EOL;
} else {
$accountinfo = json_decode($result);
$balanceinfo = $accountinfo->value;
$rechargeinfo = $accountinfo->autoReload;

if ($rechargeinfo == 1) {
    echo $colors["white"]."[".$colors["green"]."✓".$colors["white"]."]———[".$colors["yellow"]." $time ".$colors["white"]."]—[".$colors["green"]." $credential[0] ".$colors["white"]."]—[ BALANCE : ".$colors["green"]."$balanceinfo ".$colors["white"]."]—[ AUTO RECHARGE : ".$colors["green"]."TRUE ".$colors["white"]."]—[".$colors["purple"]." HYPE".$colors["cyan"]."BROTHER".$colors["white"]." CHECKER ]".PHP_EOL;

    // CHECK SEND SMS
    $cx = curl_init();
    curl_setopt($cx, CURLOPT_URL, 'https://rest.nexmo.com/sms/json');
    curl_setopt($cx, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($cx, CURLOPT_POST, 1);
    curl_setopt($cx, CURLOPT_POSTFIELDS, 'from=HYPEBROTHER&text=Test Send SMS ['.$credential[0].']&to='.$phonecheck.'&api_key='.$credential[0].'&api_secret='.$credential[1]);

    $headers = array();
    $headers[] = 'Content-Type: application/x-www-form-urlencoded';
    curl_setopt($cx, CURLOPT_HTTPHEADER, $headers);
    
    $result_1 = curl_exec($cx);
    if (preg_match('/Non White-listed Destination - rejected/i', $result_1)) {
        echo $colors["white"]." └[".$colors["red"]."✗".$colors["white"]."]—[ CHECK SEND SMS ]—[".$colors["yellow"]." CAN'T SEND TO YOUR NUMBER ".$colors["white"]."]".PHP_EOL;
        echo $colors["white"]."——————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————".PHP_EOL;
    } elseif(preg_match('/"status": "0",/i', $result_1)) {
        echo $colors["white"]." └[".$colors["green"]."✓".$colors["white"]."]—[ CHECK SEND SMS ]—[".$colors["green"]." SUCCESS SEND TO YOUR NUMBER ".$colors["white"]."]".PHP_EOL;
        echo $colors["white"]."——————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————".PHP_EOL;
    } else {
        echo $colors["white"]." └[".$colors["yellow"]."?".$colors["white"]."]—[ CHECK SEND SMS ]—[".$colors["yellow"]." UNKNOWN PROBLEM ".$colors["white"]."]".PHP_EOL;
        echo $colors["white"]."——————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————".PHP_EOL;
    }
    curl_close($cx);

    $save = @fopen("valid_apikey_nexmo.txt", "a");
    fwrite($save, $loop_check . "|[Balance : " . $balanceinfo . "]|[auto_reload: true]" . "\n");
    fclose($save);
}
    else {
    echo $colors["white"]."[".$colors["green"]."✓".$colors["white"]."]———[".$colors["yellow"]." $time ".$colors["white"]."]—[".$colors["green"]." $credential[0] ".$colors["white"]."]—[ BALANCE : ".$colors["green"]."$balanceinfo ".$colors["white"]."]—[ AUTO RECHARGE : ".$colors["red"]."FALSE ".$colors["white"]."]—[".$colors["purple"]." HYPE".$colors["cyan"]."BROTHER".$colors["white"]." CHECKER ]".PHP_EOL;
    
        // CHECK SEND SMS
        $cx = curl_init();
        curl_setopt($cx, CURLOPT_URL, 'https://rest.nexmo.com/sms/json');
        curl_setopt($cx, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($cx, CURLOPT_POST, 1);
        curl_setopt($cx, CURLOPT_POSTFIELDS, 'from=HYPEBROTHER&text=Test Send SMS ['.$credential[0].']&to='.$phonecheck.'&api_key='.$credential[0].'&api_secret='.$credential[1]);
    
        $headers = array();
        $headers[] = 'Content-Type: application/x-www-form-urlencoded';
        curl_setopt($cx, CURLOPT_HTTPHEADER, $headers);
        
        $result_1 = curl_exec($cx);
        if (preg_match('/Non White-listed Destination - rejected/i', $result_1)) {
            echo $colors["white"]." └[".$colors["red"]."✗".$colors["white"]."]—[ CHECK SEND SMS ]—[".$colors["yellow"]." CAN'T SEND TO YOUR NUMBER ".$colors["white"]."]".PHP_EOL;
            echo $colors["white"]."——————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————".PHP_EOL;
        } elseif(preg_match('/"status": "0",/i', $result_1)) {
            echo $colors["white"]." └[".$colors["green"]."✓".$colors["white"]."]—[ CHECK SEND SMS ]—[".$colors["green"]." SUCCESS SEND TO YOUR NUMBER ".$colors["white"]."]".PHP_EOL;
            echo $colors["white"]."——————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————".PHP_EOL;
        } else {
            echo $colors["white"]." └[".$colors["yellow"]."?".$colors["white"]."]—[ CHECK SEND SMS ]——[".$colors["yellow"]." UNKNOWN PROBLEM ".$colors["white"]."]".PHP_EOL;
            echo $colors["white"]."——————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————".PHP_EOL;
        }
        curl_close($cx);

    $save = @fopen("valid_apikey_nexmo.txt", "a");
    fwrite($save, $loop_check . "|[Balance : " . $balanceinfo . "]|[auto_recharge: false]" . "\n");
    fclose($save);
}
}
}