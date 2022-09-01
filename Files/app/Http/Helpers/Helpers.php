<?php

use App\Etemplate;
use App\GeneralSettings;
use Twilio\Rest\Client;

function active_menu($routename, $class = 'active open')
{
    if (is_array($routename)) {
        foreach ($routename as $key => $value) {
            if (request()->routeIs($value)) {
                return $class;
            }
        }
    } elseif (request()->routeIs($routename)) {
        return $class;
    }
}


function send_email($to, $name, $subject, $message)
{
    $temp = Etemplate::first();
    $gnl = GeneralSettings::first();
    $template = $temp->emessage;
    $from = $temp->esender;

    if ($gnl->email_notification == 1) {
        $headers = "From: $gnl->sitename <$from> \r\n";
        $headers .= "Reply-To: $name <$to> \r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

        $mm = str_replace("[[name]]", $name, $template);
        $msg = str_replace("[[message]]", $message, $mm);

        @mail($to, $subject, $msg, $headers);

    }
}



function send_email_verification($to, $name, $subject, $message)
{
    $temp = Etemplate::first();
    $gnl = GeneralSettings::first();
    $template = $temp->emessage;
    $from = $temp->esender;
    $headers = "From: $gnl->sitename <$from> \r\n";
    $headers .= "Reply-To: $gnl->sitename <$from> \r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
    $mm = str_replace("[[name]]", $name, $template);
    $msg = str_replace("[[message]]", $message, $mm);


    @mail($to, $subject, $msg, $headers);
}




function send_contact($to, $name, $subject, $message)
{
    $temp = Etemplate::first();
    $gnl = GeneralSettings::first();
    $template = $temp->emessage;
    $from = $temp->esender;

    if ($gnl->email_notification == 1) {
        $headers = "From: $name <$to> \r\n";
        $headers .= "Reply-To: $gnl->sitename <$from> \r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

        $mm = str_replace("[[name]]", "Dear Admin", $template);
        $msg = str_replace("[[message]]", $message, $mm);

        @mail($from, $subject, $msg, $headers);
    }
}




function send_sms($to, $message)
{
    $temp = Etemplate::first();
    $gnl = GeneralSettings::first();
    $gnlSMS = ($gnl->sms_from != null) ? $gnl->sms_from : '9991231234';

    if ($gnl->sms_notification == 1) {
        $sendtext = urlencode($message . "\n\nRegards,\n" . $gnl->sitename);
        $sid = $gnl->sid; // Your Account SID from www.twilio.com/console
        $token = $gnl->api_token; // Your Auth Token from www.twilio.com/console
        $client = new Twilio\Rest\Client($sid, $token);
        $message = $client->messages->create(
            preg_replace('/\D+/', '', $to), // Text this number
            [
                'from' => preg_replace('/\D+/', '', $gnlSMS), // From a valid Twilio number
                'body' => $sendtext
            ]
        );

    }
}



function send_sms_verification($to, $message){
    $temp = Etemplate::first();
    $gnl = GeneralSettings::first();
    $gnlSMS = ($gnl->sms_from != null) ? $gnl->sms_from : '9991231234';

    if ($gnl->sms_verification == 1) {
        $sendtext = urlencode($message . "\n\nRegards,\n" . $gnl->sitename);
        $sid = $gnl->sid; // Your Account SID from www.twilio.com/console
        $token = $gnl->api_token; // Your Auth Token from www.twilio.com/console
        $client = new Twilio\Rest\Client($sid, $token);
        $message = $client->messages->create(
            preg_replace('/\D+/', '', $to), // Text this number
            [
                'from' => preg_replace('/\D+/', '', $gnlSMS), // From a valid Twilio number
                'body' => $sendtext
            ]
        );
    }
}

function notify($user, $subject = null, $message)
{
    send_email($user->email, $user->name, $subject, $message);
    send_sms($user->phone, strip_tags($message));
}



function slug($string)
{
    return Illuminate\Support\Str::slug($string);
}

function str_slug($title = null)
{
    return \Illuminate\Support\Str::slug($title);
}

function str_limit($title = null, $length = 10)
{
    return \Illuminate\Support\Str::limit($title, $length);
}

function diffForHumans($date = null)
{
    return \Carbon\Carbon::parse($date)->diffForHumans();
}


function verification_code($length)
{
    if ($length == 0) return 0;
    $min = pow(10, $length - 1);
    $max = 0;
    while ($length > 0 && $length--) {
        $max = ($max * 10) + 9;
    }
    return random_int($min, $max);
}


function formatter_money($money, $currency = 2)
{
    return round($money, $currency);
}


function getTrx($length = 12)
{
    $characters = 'ABCDEFGHJKMNOPQRSTUVWXYZ123456789';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}


function curlContent($url)
{
    //open connection
    $ch = curl_init();
    //set the url, number of POST vars, POST data
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //execute post
    $result = curl_exec($ch);
    //close connection
    curl_close($ch);
    return $result;
}

function cryptoQR($wallet, $amount, $crypto = null)
{

    $varb = $wallet . "?amount=" . $amount;
    return "https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=$varb&choe=UTF-8";
}


function getIpInfo()
{
    $ip = Null;
    $deep_detect = TRUE;

    if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
        $ip = $_SERVER["REMOTE_ADDR"];
        if ($deep_detect) {
            if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
                $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
    }


    $xml = @simplexml_load_file("http://www.geoplugin.net/xml.gp?ip=" . $ip);


    $country = @$xml->geoplugin_countryName;
    $city = @$xml->geoplugin_city;
    $area = @$xml->geoplugin_areaCode;
    $code = @$xml->geoplugin_countryCode;
    $long = @$xml->geoplugin_longitude;
    $lat = @$xml->geoplugin_latitude;


    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    $os_platform = "Unknown OS Platform";
    $os_array = array(
        '/windows nt 10/i' => 'Windows 10',
        '/windows nt 6.3/i' => 'Windows 8.1',
        '/windows nt 6.2/i' => 'Windows 8',
        '/windows nt 6.1/i' => 'Windows 7',
        '/windows nt 6.0/i' => 'Windows Vista',
        '/windows nt 5.2/i' => 'Windows Server 2003/XP x64',
        '/windows nt 5.1/i' => 'Windows XP',
        '/windows xp/i' => 'Windows XP',
        '/windows nt 5.0/i' => 'Windows 2000',
        '/windows me/i' => 'Windows ME',
        '/win98/i' => 'Windows 98',
        '/win95/i' => 'Windows 95',
        '/win16/i' => 'Windows 3.11',
        '/macintosh|mac os x/i' => 'Mac OS X',
        '/mac_powerpc/i' => 'Mac OS 9',
        '/linux/i' => 'Linux',
        '/ubuntu/i' => 'Ubuntu',
        '/iphone/i' => 'iPhone',
        '/ipod/i' => 'iPod',
        '/ipad/i' => 'iPad',
        '/android/i' => 'Android',
        '/blackberry/i' => 'BlackBerry',
        '/webos/i' => 'Mobile'
    );
    foreach ($os_array as $regex => $value) {
        if (preg_match($regex, $user_agent)) {
            $os_platform = $value;
        }
    }
    $browser = "Unknown Browser";
    $browser_array = array(
        '/msie/i' => 'Internet Explorer',
        '/firefox/i' => 'Firefox',
        '/safari/i' => 'Safari',
        '/chrome/i' => 'Chrome',
        '/edge/i' => 'Edge',
        '/opera/i' => 'Opera',
        '/netscape/i' => 'Netscape',
        '/maxthon/i' => 'Maxthon',
        '/konqueror/i' => 'Konqueror',
        '/mobile/i' => 'Handheld Browser'
    );
    foreach ($browser_array as $regex => $value) {
        if (preg_match($regex, $user_agent)) {
            $browser = $value;
        }
    }

    $data['country'] = $country;
    $data['city'] = $city;
    $data['area'] = $area;
    $data['code'] = $code;
    $data['long'] = $long;
    $data['lat'] = $lat;
    $data['os_platform'] = $os_platform;
    $data['browser'] = $browser;
    $data['ip'] = request()->ip();
    $data['time'] = date('d-m-Y h:i:s A');
    return $data;
}


function admin_authorize($access)
{
    $access = json_decode($access);
    if (in_array(1, $access)) {
        return redirect()->route('admin.dashboard');
    } elseif (in_array(2, $access)) {
        return redirect()->route('admin.events');
    } elseif (in_array(3, $access)) {
        return redirect()->route('awaiting.winner');
    } elseif (in_array(4, $access)) {
        return redirect()->route('users');
    } elseif (in_array(5, $access)) {
        return redirect()->route('payment-log');
    } elseif (in_array(6, $access)) {
        return redirect()->route('withdraw-log');
    } elseif (in_array(7, $access)) {
        return redirect()->route('staff');
    } elseif (in_array(8, $access)) {
        return redirect()->route('admin.changePrefix');
    }

    elseif (in_array(9, $access)) {
        return redirect()->route('siteControl');
    } elseif (in_array(10, $access)) {
        return redirect()->route('admin.blog');
    } elseif (in_array(11, $access)) {
        return redirect()->route('testimonial');
    } elseif (in_array(12, $access)) {
        return redirect()->route('admin.about');
    }

    elseif (in_array(13, $access)) {
        return redirect()->route('admin.faqs');
    } elseif (in_array(14, $access)) {
        return redirect()->route('admin.terms');
    } elseif (in_array(15, $access)) {
        return redirect()->route('admin.policy');
    }

    elseif (in_array(16, $access)) {
        return redirect()->route('mail-setting');
    }
    elseif (in_array(17, $access)) {
        return redirect()->route('slider');
    }

}



// Helper Function

function EXPORT_DATABASE($host,$user,$pass,$name,   $tables=false, $backup_name=false)
{
    set_time_limit(3000); $mysqli = new MySQLi($host,$user,$pass,$name); $mysqli->select_db($name); $mysqli->query("SET NAMES 'utf8'");
    $queryTables = $mysqli->query('SHOW TABLES'); while($row = $queryTables->fetch_row()) { $target_tables[] = $row[0]; }	if($tables !== false) { $target_tables = array_intersect( $target_tables, $tables); }
    $content = "SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";\r\nSET time_zone = \"+00:00\";\r\n\r\n\r\n/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;\r\n/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;\r\n/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;\r\n/*!40101 SET NAMES utf8 */;\r\n--\r\n-- Database: `".$name."`\r\n--\r\n\r\n\r\n";
    foreach($target_tables as $table){
        if (empty($table)){ continue; }
        $result	= $mysqli->query('SELECT * FROM `'.$table.'`');  	$fields_amount=$result->field_count;  $rows_num=$mysqli->affected_rows; 	$res = $mysqli->query('SHOW CREATE TABLE '.$table);	$TableMLine=$res->fetch_row();
        $content .= "\n\n".$TableMLine[1].";\n\n";   $TableMLine[1]=str_ireplace('CREATE TABLE `','CREATE TABLE IF NOT EXISTS `',$TableMLine[1]);
        for ($i = 0, $st_counter = 0; $i < $fields_amount;   $i++, $st_counter=0) {
            while($row = $result->fetch_row())	{ //when started (and every after 100 command cycle):
                if ($st_counter%100 == 0 || $st_counter == 0 )	{$content .= "\nINSERT INTO ".$table." VALUES";}
                $content .= "\n(";    for($j=0; $j<$fields_amount; $j++){ $row[$j] = str_replace("\n","\\n", addslashes($row[$j]) ); if (isset($row[$j])){$content .= '"'.$row[$j].'"' ;}  else{$content .= '""';}	   if ($j<($fields_amount-1)){$content.= ',';}   }        $content .=")";
                //every after 100 command cycle [or at last line] ....p.s. but should be inserted 1 cycle eariler
                if ( (($st_counter+1)%100==0 && $st_counter!=0) || $st_counter+1==$rows_num) {$content .= ";";} else {$content .= ",";}	$st_counter=$st_counter+1;
            }
        } $content .="\n\n\n";
    }
    $content .= "\r\n\r\n/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;\r\n/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;\r\n/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;";
    $backup_name = $backup_name ? $backup_name : $name.'___('.date('H-i-s').'_'.date('d-m-Y').').sql';
    ob_get_clean(); header('Content-Type: application/octet-stream');  header("Content-Transfer-Encoding: Binary");  header('Content-Length: '. (function_exists('mb_strlen') ? mb_strlen($content, '8bit'): strlen($content)) );    header("Content-disposition: attachment; filename=\"".$backup_name."\"");
    echo $content; exit;
}


function percent($num_amount, $num_total)
{
    if($num_total > 0){
        $count1 = $num_amount / $num_total;
        $count2 = $count1 * 100;
        $count = round($count2);
        return $count;
    }else{
        return 0; // or whatever you want
    }
}


function getImage($image, $clean = '')
{
    return file_exists($image) && is_file($image) ? asset($image) . $clean : asset(imagePath()['image']['default']);
}

function getAmount($amount)
{
    return $amount + 0;
}


function showDateTime($date, $format = 'd M, Y h:i a')
{

    return \Carbon\Carbon::parse($date)->format($format);
}

function imagePath()
{
    $data['gateway'] = [
        'path' => 'public/images/gateways',
        'size' => '800x800',
    ];

    $data['deposit'] = [
        'path' => 'public/images/verify_deposit',
    ];


    $data['image'] = [
        'default' => 'public/images/default.png',
    ];

    $data['withdraw'] = [
        'method' => [
            'path' => 'public/images/withdraw',
            'size' => '800x800',
        ],
        'verify' => [
            'path' => 'public/images/verify_withdraw'
        ]
    ];

    $data['ticket'] = [
        'path' => 'public/images/support',
    ];

    return $data;
}


function uploadImage($file, $location, $size = null, $old = null, $thumb = null)
{
    $path = makeDirectory($location);
    if (!$path) throw new Exception('File could not been created.');

    if (!empty($old)) {
        removeFile($location . '/' . $old);
        removeFile($location . '/thumb_' . $old);
    }


    $filename = uniqid() . time() . '.' . $file->getClientOriginalExtension();


    $image = Image::make($file);


    if (!empty($size)) {
        $size = explode('x', strtolower($size));
        $image->resize($size[0], $size[1]);
    }
    $image->save($location . '/' . $filename);

    if (!empty($thumb)) {

        $thumb = explode('x', $thumb);
        Image::make($file)->resize($thumb[0], $thumb[1])->save($location . '/thumb_' . $filename);
    }
    return $filename;
}



function makeDirectory($path)
{
    if (file_exists($path)) return true;
    return mkdir($path, 0755, true);
}

function removeFile($path)
{
    return file_exists($path) && is_file($path) ? @unlink($path) : false;
}


function inputTitle($text)
{
    return ucfirst(preg_replace("/[^A-Za-z0-9 ]/", ' ', $text));
}


