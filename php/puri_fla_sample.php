<?

header("Content-Type: application/x-shockwave-flash");
//header("Content-Type: text/html");
echo swf_wrapper('puri_fla_sample.swf',$_GET);

//
// for PHP4.0
//
if (!function_exists('http_build_query')) {
function http_build_query($data, $prefix='', $sep='', $key='') {
    $ret = array();
    foreach ((array)$data as $k => $v) {
        if (is_int($k) && $prefix != null) $k = urlencode($prefix . $k);
        if (!empty($key)) $k = $key.'['.urlencode($k).']';
        
        if (is_array($v) || is_object($v))
            array_push($ret, http_build_query($v, '', $sep, $k));
        else    array_push($ret, $k.'='.urlencode($v));
    }

    if (empty($sep)) $sep = ini_get('arg_separator.output');
    return implode($sep, $ret);
}}
//
//
//

function swf_wrapper($file,$item){
	$tags	= build_tags($item);
	$src	= file_get_contents($file);
	$i	= (ord($src[8])>>1)+5;
	$length	= ceil((((8-($i&7))&7)+$i)/8)+17;
	$head	= substr($src,0,$length);
	return(
		substr($head,0,4).
		pack("V",strlen($src)+strlen($tags)).
		substr($head,8).
		$tags.
		substr($src,$length)
	);
}

function build_tags($item){
	$tags = array();
	foreach($item as $k => $v){
		//$v = mb_convert_encoding($v,'SJIS','UTF-8');
		array_push( $tags, sprintf(
			"\x96%s\x00%s\x00\x96%s\x00%s\x00\x1d",
			pack("v",strlen($k)+2),	$k,
			pack("v",strlen($v)+2),	$v
		));
	}
	$s = implode('',$tags);
	return(sprintf(
		"\x3f\x03%s%s\x00",
		pack("V",strlen($s)+1),
		$s
	));
}

?>
