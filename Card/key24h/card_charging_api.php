<?php
/**
 * Card_charging API Class
 *
 * @version		1.1
 * @copyright	Copyright (c) 2016. 
 */
class Card_charging_api {
	
	// Api url
	const URL_API = 'https://key24h.com/card_charging_api';
	
	// Account id
	protected $_PartnerID;
	
	// Api id
	protected $_PartnerKey;

	
	// --------------------------------------------------------------------
	
	/**
	 * Constructor
	 * @param array $config		Parameters that initiate API
	 * The available parameters are:
	 * 	PartnerID		Được bên API cấp
	 * 	PartnerKey		Được bên API cấp
	 */
	public function __construct(array $config)
	{
		foreach (array('PartnerID', 'PartnerKey') as $p)
		{
			if ( ! isset($config[$p]))
			{
				 throw new Card_charging_Exception("This param is required - {$p}");
			}
			else 
			{
				$this->{'_'.$p} = $config[$p];
			}
		}
	}
	
	
	/**
	 * Lấy các loại thẻ đang hoạt động từ nhà mạng cung cấp
	 */
	public function get_card_keys()
	{
	    $params = new stdClass();
	    // Set api config
		$params->PartnerID    = $this->_PartnerID;
		$params->PartnerKey   = $this->_PartnerKey;
		
		// Request to api
		$url = self::URL_API . '/get_card_keys.html';
		
		$res = $this->_curl($url, $params);
	
		$res = @base64_decode($res);
		
		$res = @json_decode($res);

		return $res;
	}


	/**
	 * Lấy tất cả các loại thẻ từ nhà mạng cung cấp
	 * status = 1 (đang hoạt động) || = 0  là tạm dùng hoạt động
	 */
	public function get_cards()
	{
		$params = new stdClass();
		// Set api config
		$params->PartnerID    = $this->_PartnerID;
		$params->PartnerKey   = $this->_PartnerKey;

		// Request to api
		$url = self::URL_API . '/get_cards.html';

		$res = $this->_curl($url, $params);

		$res = @base64_decode($res);

		$res = @json_decode($res);

		return $res;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Kiểm tra ma the
	 * @param string 	$key	loại thẻ từ nhà mạng cung cấp
	 * @param string 	$code	Mã số dưới lớp tráng bạc trên thẻ
	 * @param string 	$serial		Số Serial thẻ cần check (VD: PM0000000001)
	 * @param float 	$request_id	Mã tự sinh trong mỗi giao dịch và không giống nhau (Chúng tôi sẽ lưu lại mã này để đối chiếu khi có khiếu lại)
	 */
	public function check_card($key, $code, $serial, $request_id)
	{
		$params = new stdClass();
		$params->key 	    = trim($key);
		$params->code 	    = trim($code);
		$params->serial 	= trim($serial);
		$params->request_id = trim($request_id);
		
		return $this->_exec($params);
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Send data to the API end received response
	 * @param array		$params		Params that will be send
	 */
	protected function _exec($params)
	{
		// Set api config
		$params->PartnerID    = $this->_PartnerID;
		$params->PartnerKey   = $this->_PartnerKey;
		
		$checksum = md5($params->PartnerID.$params->key.$params->serial.$params->request_id);
		$params->checksum    = $checksum;

		// Request to api
		$url = self::URL_API . '.html';
		$res = $this->_curl($url, $params);
		$res = @base64_decode($res);
		$res = @json_decode($res);

		return $res;
	}
	
	
	// --------------------------------------------------------------------
	
	/**
	 * Send data to the server end received response
	 * @param string 	$url	URL send request
	 * @param array 	$data	Data that will be send
	 */
	protected function _curl($url, $data)
	{
		// Check curl library
		if ( ! function_exists('curl_init'))
		{
			exit('Curl library not installed.');
		}
		
		// Set options
    	$opts = array();
        $opts[CURLOPT_URL] = $url;
        $opts[CURLOPT_USERAGENT] = 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.43 Safari/537.31';
        $opts[CURLOPT_HEADER] = false;
        $opts[CURLOPT_RETURNTRANSFER] = true;
        $opts[CURLOPT_TIMEOUT] = 15;
        
        if (count($data))
        {
        	$opts[CURLOPT_POST] = true;
        	$opts[CURLOPT_POSTFIELDS] = http_build_query($data);
        }
		
	  	if (preg_match('#^https:#i', $url))
        {
     		$opts[CURLOPT_SSL_VERIFYPEER] = FALSE;
        	$opts[CURLOPT_SSL_VERIFYHOST] = 0;
        	$opts[CURLOPT_SSLVERSION] = 1;
        }
        
		// Init curl
		$curl = curl_init();
		curl_setopt_array($curl, $opts);
		$res = curl_exec($curl);
		if (
			curl_errno($curl) ||
			curl_getinfo($curl, CURLINFO_HTTP_CODE) != 200
		)
		{
			return false;
		}
		
		return $res;
	}
	
}


/**
 * Card_charging Exception class
 */
if ( ! class_exists('Card_charging_Exception'))
{
	class Card_charging_Exception extends Exception {}
}

