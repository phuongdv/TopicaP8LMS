<?php
/**
*  Created by   :
*  @author		: Technical Group (technical@vietitech.com)
*  @date		: 2009/1/18
*  @version		: 2.1.1
*/
class rssGenerator {
	var $rss_version = '2.0';
	var $encoding = '';
	
	function cData($str)
		{
			return '<![CDATA['.$str.']]>';
		}
	
	function createFeed($channel) {
		$rss = '<?xml version="1.0"';
		if (!empty($this->encoding))
			{
				$rss .= ' encoding="'.$this->encoding.'"';
			}
		$rss .= '?>'."\n";
		$rss .= '<!-- Generated on '.date('r').' -->'."\n";
		$rss .= '<rss version="'.$this->rss_version.'">'."\n";
		$rss .= '  <channel>'."\r";
		$rss .= '    <title>'.$channel->title.'</title>'."\n";
		$rss .= '    <link>'.$channel->link.'</link>'."\n";
		$rss .= '    <description>'.$channel->description.'</description>'."\n";
		if (!empty($channel->language))
			{
				$rss .= '    <language>'.$channel->language.'</language>'."\n";
			}
		if (!empty($channel->copyright))
			{
				$rss .= '    <copyright>'.$channel->copyright.'</copyright>'."\n";
			}
		if (!empty($channel->pubDate))
			{
				$rss .= '    <pubDate>'.$channel->pubDate.'</pubDate>'."\n";
			}
		if (!empty($channel->lastBuildDate))
			{
				$rss .= '    <lastBuildDate>'.$channel->lastBuildDate.'</lastBuildDate>'."\n";
			}
		foreach ($channel->categories as $category)
			{
				$rss .= '    <category';
					if (!empty($category['domain']))
					{
						$rss .= ' domain="'.$category['domain'].'"';
					}
				$rss .= '>'.$category['name'].'</category>'."\n";
			}
		if (!empty($channel->extraXML))
			{
				$rss .= $channel->extraXML."\n";
			}
			
		foreach ($channel->items as $item)
			{
			 	$rss .= '    <item>'."\n";
			  	if (!empty($item->title))
					{
						$rss .= '      <title>'.$item->title.'</title>'."\n";
					}
			  	if (!empty($item->description))
					{
						$rss .= '      <description>'.$item->description.'</description>'."\n";
					}
			  	if (!empty($item->link))
					{
						$rss .= '      <link>'.$item->link.'</link>'."\n";
					}
			  	if (!empty($item->pubDate))
					{
						$rss .= '      <pubDate>'.$item->pubDate.'</pubDate>'."\n";
					}
			  	if (!empty($item->author))
					{
						$rss .= '      <author>'.$item->author.'</author>'."\n";
					}
			  	if (!empty($item->comments))
					{
						$rss .= '      <comments>'.$item->comments.'</comments>'."\n";
					}
				foreach ($item->categories as $category)
					{
						$rss .= '      <category';
						if (!empty($category['domain']))
							{
								$rss .= ' domain="'.$category['domain'].'"';
							}
						$rss .= '>'.$category['name'].'</category>'."\n";
					}
				$rss .= '    </item>'."\n";	
			}
		$rss .= '  </channel>'."\r";
    	
		return $rss .= '</rss>';
	}
}

class rssGeneratorChanel {
	var $title = '';
	var $link = '';
	var $description = '';
	var $language = '';
	var $copyright = '';
	var $pubDate = '';
  	var $lastBuildDate = '';
  	var $categories = array();
	var $items = array();
 	var $extraXML = '';
}

class rssGeneratorItem
{
	var $title = '';
	var $description = '';
	var $link = '';
	var $author = '';
	var $pubDate = '';
	var $comments = '';
	var $categories = array();
}
?>