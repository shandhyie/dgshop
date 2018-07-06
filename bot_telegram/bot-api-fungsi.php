<?php
function myPre($value)
{
    print_r($value);
}

function apiRequest($method, $data){
    if (!is_string($method)) {
        error_log("Nama method harus bertipe string!\n");
        return false;
    }

    if (!$data) {
        $data = array();
    } elseif (!is_array($data)) {
        error_log("Data harus bertipe array\n");
        return false;
    }

    $url = 'https://api.telegram.org/bot'.$GLOBALS['token'].'/'.$method;

    $options = array(
        'http' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data)
        )
    );
    $context = stream_context_create($options);

    $result = file_get_contents($url, false, $context);   
	return $result;
}

//long poll
function getApiUpdate($offset){
    $method = 'getUpdates';
    $data['offset'] = $offset;

    $result = apiRequest($method, $data);

    $result = json_decode($result, true);
    if ($result['ok'] == 1) {
        return $result['result'];
    }

    return array();
}

function sendApiMsg($chatid, $text, $msg_reply_id = false, $parse_mode = false, $disablepreview = false){
    $method = 'sendMessage';
    $data = array('chat_id' => $chatid, 'text'  => $text);

    if ($msg_reply_id) {
        $data['reply_to_message_id'] = $msg_reply_id;
    }
    if ($parse_mode) {
        $data['parse_mode'] = $parse_mode;
    }
    if ($disablepreview) {
        $data['disable_web_page_preview'] = $disablepreview;
    }
	
	/* ke database  *
	$chatid = $chatid; 
	$command = $text;
	require_once("concon.php");
	$sql = "insert into temp values(null,now(),'$chatid','$command')";
	mysql_query($sql);
	/**/
	
	//ke API TELEGRAM
	$result = apiRequest($method, $data);
	//ke cmd
	if ($GLOBALS['debug']){
		echo "\r\n===== ApiMsg dikirim \r\n";
		mypre($result);
	}
}

function sendApiAction($chatid, $action = 'typing'){
    $method = 'sendChatAction';
    $data = array(
        'chat_id' => $chatid,
        'action'  => $action,
    );
    $result = apiRequest($method, $data);
	if ($GLOBALS['debug']){
		echo "\r\n===== Api Action dikirim \r\n";
		mypre($result);
	}
}

function sendApiPhoto($chatid){
	$bot_url    = "https://api.telegram.org/bot".$GLOBALS['token']."/";
	$url        = $bot_url . "sendPhoto?chat_id=" . $chatid ;

	$post_fields = array('chat_id'   => $chatid,
	    'photo'     => new CURLFile(realpath("../images/logo/dgshop.png"))
	    // 'reply_markup' => json_encode(array('inline_keyboard' => $keyboard))
	);

	$ch = curl_init(); 
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
	    "Content-Type:multipart/form-data"
	));
	//tidak bagus untuk production, sebaiknya untuk mendevelopment 
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields); 
	$output = curl_exec($ch);
}

function sendApi_foto_desain($chatid, $gambar){
	$bot_url    = "https://api.telegram.org/bot".$GLOBALS['token']."/";
	$url        = $bot_url . "sendPhoto?chat_id=" . $chatid ;

	$post_fields = array('chat_id'   => $chatid,
	    'photo'     => new CURLFile(realpath("../images/produk/$gambar")) //diubah sesuaikan folder web
	    // 'reply_markup' => json_encode(array('inline_keyboard' => $keyboard))
	);

	$ch = curl_init(); 
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
	    "Content-Type:multipart/form-data"
	));
	//tidak bagus untuk production, sebaiknya untuk mendevelopment 
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields); 
	$output = curl_exec($ch);
}

function sendApiKeyboard($chatid,$keyboard = array(), $inline = false, $text){
	$method = 'sendMessage';
    $replyMarkup = array(
        'keyboard'        => $keyboard,
        'resize_keyboard' => true,	//smaller keyboard
		//'one_time_keyboard' => true, //dismiss keyboard after used
		//'selective' => true, //personal chat
    );
	
	$data = array('chat_id' => $chatid,'text' => $text,'parse_mode' => 'Markdown');

    $inline ? $data['reply_markup'] = json_encode(array('inline_keyboard' => $keyboard)) : $data['reply_markup'] = json_encode($replyMarkup);

	print_r($data);
    $result = apiRequest($method, $data);
	if ($GLOBALS['debug']){
		echo "\r\n===== Api keyboard dikirim \r\n";
		mypre($result);
	}
}

function sendApiData($chatid, $source, $data){
	if($data == 'vid'){
		$bot_url    = "https://api.telegram.org/bot".$GLOBALS['token']."/";
		$url        = $bot_url . "sendVideo?chat_id=" . $chatid ;

		$post_fields = array('chat_id'   => $chatid,
		    'video'     => new CURLFile(realpath("file/video/".$source))
		    // 'reply_markup' => json_encode(array('inline_keyboard' => $keyboard))
		);
	}
	elseif($data == 'doc'){
		$bot_url    = "https://api.telegram.org/bot".$GLOBALS['token']."/";
		$url        = $bot_url . "sendDocument?chat_id=" . $chatid ;

		$post_fields = array('chat_id'   => $chatid,
		    'document'     => new CURLFile(realpath("file/doc/".$source))
		    // 'reply_markup' => json_encode(array('inline_keyboard' => $keyboard))
		);
	}
	elseif($data == 'image'){
		$bot_url    = "https://api.telegram.org/bot".$GLOBALS['token']."/";
		$url        = $bot_url . "sendPhoto?chat_id=" . $chatid ;

		$post_fields = array('chat_id'   => $chatid,
		    'photo'     => new CURLFile(realpath("file/gambar/".$source))
		    // 'reply_markup' => json_encode(array('inline_keyboard' => $keyboard))
		);
	}
	elseif($data == 'audio'){
		$bot_url    = "https://api.telegram.org/bot".$GLOBALS['token']."/";
		$url        = $bot_url . "sendAudio?chat_id=" . $chatid ;

		$post_fields = array('chat_id'   => $chatid,
		    'audio'     => new CURLFile(realpath("file/audio/".$source))
		    // 'reply_markup' => json_encode(array('inline_keyboard' => $keyboard))
		);
	}
    
	$ch = curl_init(); 
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
	    "Content-Type:multipart/form-data"
	));
	//tidak bagus untuk production, sebaiknya untuk mendevelopment 
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields); 
	$output = curl_exec($ch);
}

// function sendApiVideo($chatid, $fileinfo, $caption, $keyboard = false){
// 	$method = 'sendDocument';
// 	$replyMarkup = array(
//         'keyboard'        => $keyboard,
//         'resize_keyboard' => true,	//smaller keyboard
// 		//'one_time_keyboard' => true, //dismiss keyboard after used
// 		//'selective' => true, //personal chat
//     );
	
// 	$data = array('chat_id' => $chatid, 'document'  => new CURLFile(realpath($fileinfo)), 'caption'=>$caption);
// 	$data['reply_markup'] = json_encode(array('inline_keyboard' => $keyboard));
	
// 	$result = apiRequest($method,$data);
// 	if ($GLOBALS['debug']){
// 		echo "\r\n===== ApiMsg dikirim \r\n";
// 		mypre($result);
// 	}
// }