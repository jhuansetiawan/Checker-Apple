<?php
/**
* Creator CLI by JOHN NERRY
* DONATE https://www.paypal.me/johnnerry
* Date: January 17 2018
*/
error_reporting(0);
ini_set("memory_limit", "-1");
date_default_timezone_set("Asia/Jakarta");
class apple
{
    function __construct()
    {
        echo "Enter Mailist : ";
        $this->file   = rtrim(fgets(STDIN));
        echo "Enter Folder  : ";
        $this->folder = rtrim(fgets(STDIN));
        if(is_dir($this->folder))
        {
            echo $this->folder."/folder are exists, append to them ? (y/n) : ";
            $this->input = rtrim(fgets(STDIN));
            if($this->input == 'y' || $this->input == 'Y')
            {
                $this->opendir = opendir($this->folder);
                while(($this->readdir = readdir($this->opendir)) !== false)
                {
                    unlink($this->folder."/".$this->readdir);
                }
                closedir($this->opendir);
            }
            else
            {
                $this->opendir = opendir($this->folder);
                while(($this->readdir = readdir($this->opendir)) !== false)
                {
                    unlink($this->folder."/".$this->readdir);
                }
                closedir($this->opendir);
                rmdir($this->folder);
                echo "Enter Folder  : ";
                $this->folder = rtrim(fgets(STDIN));
                mkdir($this->folder);
            }
        }
        else
        {
            mkdir($this->folder);
        }
    }
    public function myfile()
    {
        $this->myfile  = file_get_contents($this->file);
        if(!file_exists($this->file))
        {
            echo "File not found!";
            exit();
        }

        return array(
        	'list'  => explode("\r\n", $this->myfile),
            'count' => count(explode("\r\n", $this->myfile))
        );
    }
    public function savefile($namefile = null, $content = null)
    {
    	$fp = fopen($namefile, "a+");
    	$fw = fwrite($fp, $content);
    	if($fw)
    	{
    		return true;
    		fclose($fp);
    	}
    	else
    	{
    		return false;
    		fclose($fp);
    	}
    }
    public function getheader($url) 
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 0);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd() . "/cookies.txt");
        curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd() . "/cookies.txt");
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36");

        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }
    public function applecheck($email, $scnt) 
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
        curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd() . "/cookies.txt");
        curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd() . "/cookies.txt");
        curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"emailAddress\":\"$email\"}");
        curl_setopt($ch, CURLOPT_URL, "https://appleid.apple.com/account/validation/appleid");
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36");
        $headers = array();
        $headers[] = "Scnt: $scnt";
        $headers[] = "Origin: https://appleid.apple.com";
        $headers[] = "Accept-Encoding: gzip, deflate, br";
        $headers[] = "X-Apple-I-Fd-Client-Info: {\"U\":\"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3239.132 Safari/537.36\",\"L\":\"en-GB\",\"Z\":\"GMT+07:00\",\"V\":\"1.1\",\"F\":\"V8a44j1e3NlY5BSo9z4ofjb75PaK4Vpjt.gEngMQEjZr_WhXTA2s.XTVV26y8GGEDd5ihORoVyFGh8cmvSuCKzIlnY6xljQlpRD.arbo8vLUGvLG9mhORoVidPZW2AUMnGWVQdgMVQdg1kzoMpwoNJ9z4oYYLzZ1kzDlSgyyITL5q8sgEV18u1.BUs_43wuZPup_nH2t05oaYAhrcpMxE6DBUr5xj6Kks1QTUFbhOx6hO3f9p_nH1zDz0oc4xUC569XXTqbOtJJIqSI6KUMnGWpwoNSUC56MnGW87gq1HACVdXVApv9_2q2pjAT5Ju30m_dhre9zH_y3Cmd.1wcDclruAs.eNk0JkLJsVRcWprTMez1KyJCp0iK7.M_Kpil1BNlY6SF0Y5BOgkLT0XxU..5f2\"}";
        $headers[] = "Accept-Language: en-GB,en-US;q=0.9,en;q=0.8";
        $headers[] = "X-Requested-With: XMLHttpRequest";
        $headers[] = "Cookie: idclient=web; dslang=GB-EN; site=GBR; aidsp=071E36DE8931545C650EEF055F9ED2B9A92773AEE5EB8A3C77CE887BABD11AEEBC35D2A45EC421AF4A60266F3753A23D683C5F9C0F8AB5F95FAD5F61992D4B27D8504E095CCDCC32B96787DD464834C893F77D428C2824345C9652593C05C408694991093AB17A959C60CBDE0CB5418BD349D51AED1004F9; ccl=0f9nnGqTs7u/Cz0vYpHmMQ==; geo=ID";
        $headers[] = "Connection: keep-alive";
        $headers[] = "X-Apple-Api-Key: cbf64fd6843ee630b463f358ea0b707b";
        $headers[] = "X-Apple-Id-Session-Id: 071E36DE8931545C650EEF055F9ED2B9A92773AEE5EB8A3C77CE887BABD11AEEBC35D2A45EC421AF4A60266F3753A23D683C5F9C0F8AB5F95FAD5F61992D4B27D8504E095CCDCC32B96787DD464834C893F77D428C2824345C9652593C05C408694991093AB17A959C60CBDE0CB5418BD349D51AED1004F9";
        $headers[] = "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36";
        $headers[] = "Content-Type: application/json";
        $headers[] = "Accept: application/json, text/javascript, */*; q=0.01";
        $headers[] = "Referer: https://appleid.apple.com/account";
        $headers[] = "X-Apple-Request-Context: create";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        curl_close ($ch);

        return $result;
    }
    public function close() {
        $path = getcwd();
        echo "################################################\n";
        echo "Save to " . $path . "/" . $this->folder . "\n";
        echo "################################################\n";
    }
    public function exec()
    {
        $list = $this->myfile();
        $no   = 1;
        $red  = "\033[1;31m";
        $yell = "\033[1;33m";
        $grn  = "\033[1;32m";
        $blue = "\033[1;34m";
        $prpl = "\033[1;35m";
        $orng = "\033[0;33m";
        $cyan = "\033[1;36m";
        $whit = "\033[37m";
        $wht  = "\033[37m";
        $end  = "\033[0m";
        $size = filesize($this->file)/1024;
		$size = round($size,3);
		if($size >= 1024){
			$size = round($size/1024,2).' MB';
		}else{
			$size = $size.' KB';
		}
        echo "################################################\n";
        echo "INFO\n";
        echo "File Size: " . $size . "\n";
        echo "To Folder: " . $this->folder . "\n";
        echo "From     : " . $this->file . "\n";
        echo "################################################\n";
        foreach($list['list'] as $key => $email)
        {
            $get   = $this->getheader("https://appleid.apple.com/account");
            preg_match_all("/scnt: (.*)\b/i", $get, $header);
            $val   = $this->applecheck($email, $header[1][0]);
            $json  = json_decode($val, true);
            unlink("cookies.txt");
            if(filter_var($email, FILTER_VALIDATE_EMAIL)) 
            {
                if($json['used'] === true)
                {
                    echo $wht . "[From " . $this->file . " to folder " . $this->folder . "] " . $prpl . "[" . $no . "/" . $list['count'] . "] " . $yell . "LIVE => " . $email . " " . $whit . "[VALIDATIR APPLE - JOHN NERRY]" . $end . "\n";
                    $this->savefile($this->folder . "/apple-live.txt", "LIVE => " . $email . "\r\n");
                }
                else
                {
                	if($json['used'] === false)
                	{
                		echo $wht . "[From " . $this->file . " to folder " . $this->folder . "] " . $prpl . "[" . $no . "/" . $list['count'] . "] " . $red . "DEAD => " . $email . " " . $whit . "[VALIDATIR APPLE - JOHN NERRY]" . $end . "\n";
                    	$this->savefile($this->folder . "/apple-dead.txt", "DEAD => " . $email . "\r\n");
                	}
                	else
                	{
                		echo $wht . "[From " . $this->file . " to folder " . $this->folder . "] " . $prpl . "[" . $no . "/" . $list['count'] . "] " . $cyan . "UNKNOWN => " . $email . " " . $whit . "[VALIDATIR APPLE - JOHN NERRY]" . $end . "\n";
                    	$this->savefile($this->folder . "/apple-unknown.txt", "UNKNOWN => " . $email . "\r\n");
                	}
                }
            }
            else
            {
                echo $wht . "[From " . $this->file . " to folder " . $this->folder . "] " . $prpl . "[" . $no . "/" . $list['count'] . "] " . $orng . "WRONG FORMAT => " . $email . " " . $whit . "[VALIDATIR APPLE - JOHN NERRY]" . $end . "\n";
                    $this->savefile($this->folder . "/apple-wrong.txt", "WRONG => " . $email . "\r\n");
            }
            $no++;
        }
    }
}
$apple = new apple;
print_r($apple->exec());
$apple->close();
