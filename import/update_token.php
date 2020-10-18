<?php
include("../excel_export/conn.php");
mysqli_query($conndb,"SET NAMES 'utf8'");
date_default_timezone_set("Asia/Bangkok");

                function getContentUrl($url,$arr_sso) {
                    $ch = curl_init($url);
                    $fields = array(
                        'Username' => 'jetsada.d@verztec.com', // array key corresponds to the name of a field on your form
                        'Password' => 'Jets@d@35',
                        'grant_type' => 'client_credentials',
                        'scope' => 'token,user',
                    );

                    $data = http_build_query($fields);
                    $decdata = $arr_sso['sso_client_id'].":".$arr_sso['sso_password'];
                    $decdata = utf8_encode($decdata);
                    //$sha1 = sha1($decdata, TRUE);
                    //$hash = hash_hmac( "sha256", $decdata, true );
                    $raw = base64_encode($decdata);
                    //echo $raw;
                    $headers = array(
                        'Content-type: application/x-www-form-urlencoded',
                        'Authorization: Basic '.$raw,
                    );
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
                    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/21.0 (compatible; MSIE 8.01; Windows NT 5.0)');
                    curl_setopt($ch, CURLOPT_TIMEOUT, 200);
                    curl_setopt($ch, CURLOPT_AUTOREFERER, false);
                    curl_setopt($ch, CURLOPT_REFERER, 'http://google.com');
                    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
                    curl_setopt($ch, CURLOPT_HEADER, 0);
                    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
                    $file = curl_exec($ch);
                    if($file === false) trigger_error(curl_error($ch));
                    curl_close ($ch);
                    return $file;
                }

                $sql_sso = "select * from LMS_SETTING_SSO where sso_id=1";
                $query_sso = mysqli_query($conndb,$sql_sso);
                $fetch_sso = mysqli_fetch_array($query_sso);

                $arr_sso = array(
                  'sso_client_id' => $fetch_sso['sso_client_id'],
                  'sso_password' => $fetch_sso['sso_password']
                );
                $arr_check = getContentUrl('https://sso-api.thaihealth.or.th:9100/oauth2/token',$arr_sso);
                $output = json_decode($arr_check,true);
                //print_r($output);
                if(isset($output['access_token'])){
                $sql_update = "update LMS_SETTING_SSO set sso_access_token='".$output['access_token']."',sso_modifieddate='".date('Y-m-d H:i:s')."' where sso_id='1'";
                $query_update = mysqli_query($conndb,$sql_update);
                }
?>
