<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);


// every 10 minute

$_TMPL = '<?php $data = [ {repos} ]; return $data;';

function fetch($url){
	$ch = curl_init();
	
	curl_setopt($ch, CURLOPT_HTTPHEADER, array( 'Accept: application/vnd.github.v3+json'));
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.2; WOW64; rv:17.0) Gecko/20100101 Firefox/17.0');
	$res=curl_exec($ch);
	curl_close($ch);
	
	return $res;
}

$user_list = require_once('user.array');

$_repos = [];

foreach($user_list as $user){
	$repos = json_decode( fetch('https://api.github.com/users/'.$user.'/repos') );
	foreach($repos as $repo){
		$_time = strtotime(str_replace(['T', 'Z'], ' ', $repo->updated_at));
		$_repos[] = "{$_time} => '{$repo->full_name}'";
	}
}

$_repos = implode(",\r", $_repos);

file_put_contents('repos', str_replace('{repos}', $_repos, $_TMPL));
