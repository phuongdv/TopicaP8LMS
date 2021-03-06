<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

// we set this here so Pro can set the correct SITE_REF
$config['cache_path'] = APPPATH . 'cache/codeigniter/';

$config['cache_dir'] = APPPATH.'cache/';

$config['cache_default_expires'] = 86400;//1 ngày

// Will soon make these options into settings items
$config['navigation_cache'] = 86400; //1 ngày
$config['rss_cache'] = 86400; //1 ngày

// Set the location for simplepie cache
$config['simplepie_cache_dir'] = APPPATH . 'cache/simplepie/';

// Make sure all the folders exist
is_dir($config['cache_path']) OR mkdir($config['cache_path'], DIR_WRITE_MODE, true);
is_dir($config['cache_dir']) OR mkdir($config['cache_dir'], DIR_WRITE_MODE, true);
is_dir($config['simplepie_cache_dir']) OR mkdir($config['simplepie_cache_dir'], DIR_WRITE_MODE, true);