<?
class BBCode extends DbBasic
{
	function BBCode(){
	
	}
	//Show BBCode Button
	function show()
	{
		global $lang;
		$html	.= $this->button("0","b","0","B", "font-weight:bold").$this->button("2","i","2","I", "font-style:italic").$this->button("4","u","4","U","text-decoration:underline");
		$html	.= $this->choose_font();
		$html	.= $this->font_size();
		$html	.= $this->font_color();
		// Link
		$html	.=	"<br><input type='button' class='button' accesskey='h' value=' http:// ' onclick='tag_url()' name='url' onmouseover=\"helptext('http')\" onmouseout=\"helptext('htext')\"/>";
		// IMG 
		$html	.= "&nbsp;<input type='button' class='button' accesskey='m' value=' IMG ' onclick='tag_img()' name='img' onmouseover=\"helptext('img')\" onmouseout=\"helptext('htext')\"/>";
		// Quote
		$html	.= "&nbsp;".$this->button("8","quote","8","QUOTE");
		// PHP code
//		$html	.= $this->button("6","php","6","PHP");
		// CODE
		$html	.= $this->button("10","code","10","CODE");

		$html	.= "<br><INPUT 
			style='width:100%;font-size:11px;font-family:verdana,arial;border:0px' readonly='readonly'
			value='".$lang['fag_use_cttcode']."' 
			name=helpbox>";
		return $html;
	}
	//Show BBCode Smile 
	function show_smilies($root=""){
		$clsEmoticons = new Emoticons();
		$arrListEmoticons=$clsEmoticons->getAll();
		$html .= "<table class='tableborder' border=0 cellpadding='0' cellspacing='0'><tr>";
		$count = 0;
		foreach ($arrListEmoticons as $key => $val){
			if($count%4==0) $html .= "</tr><tr>";
			$html .= $this->drawbutton($val['typed'], $val['image'], $root);
			$count++;
		}
		$html .= "</tr></table>";
		return $html;		
	}
	//Parse BBC Text => Html Text
	function parse($text){
		//$text	= htmlspecialchars($text);
		//$text	= htmlentities($text);
		$text	= ereg_replace("'","&#39;",$text);
		// tab
		$text	= ereg_replace("\t","&nbsp;&nbsp;&nbsp;&nbsp;", $text);
		// br
		$text	= $this-> nltobr($text);
		// bold
		$text 	= preg_replace( "#\[B\](.+?)\[/B\]#is", "<b>\\1</b>", $text );
		// italic
		$text 	= preg_replace( "#\[I\](.+?)\[/I\]#is", "<i>\\1</i>", $text );
		// underline
		$text 	= preg_replace( "#\[U\](.+?)\[/U\]#is", "<u>\\1</u>", $text );	
		// Tag [IMG]
		$strOnLoad = 'onload="if(this.width>'.MAX_WIDTH_IMG.') {this.width='.MAX_WIDTH_IMG.';this.alt=\'Click here to see a large version\';}" onmouseover="if(this.alt) this.style.cursor=\'pointer\';" ';
		$text 	= preg_replace( "#\[IMG\](.+?)\[/IMG\]#is"  , " <img src='\\1' border='0' $strOnLoad onclick=\"if(this.alt) window.open('\\1');\"/> ", $text );
		// Tag [FONT]
		$text 	= preg_replace( "#\[FONT=(.+?)\](.+?)\[/FONT\]#is"  , " <span style='font-family:\\1'>\\2</span> ", $text );
		// Tag [SIZE]
		$text 	= preg_replace( "#\[SIZE=(.+?)\](.+?)\[/SIZE\]#is"  , " <span style='font-size:\\1pt;line-height:100%'>\\2</span> ", $text );
		// Tag [URL]
		$text 	= preg_replace( "#\[URL=(.+?)\](.+?)\[/URL\]#is"  , " <a href='\\1' target='_blank'>\\2</a> ", $text );
		// Tag [COLOR]
		while( preg_match( "#\[color=([^\]]+)\](.+?)\[/color\]#ies", $text ) )
		{
			$text = preg_replace( "#\[color=([^\]]+)\](.+?)\[/color\]#ies"  , "\$this->regex_font_attr(array('s'=>'col' ,'1'=>'\\1','2'=>'\\2'))", $text );
		}
		// emoticon
		$text	= $this->smilies($text);
		// code
		$text = preg_replace( "#\[code\](.+?)\[/code\]#ies", "\$this->regex_code_tag('\\1')", $text );
		// quote
		$text = preg_replace( "#(\[quote(.+?)?\].*\[/quote\])#ies" , "\$this->regex_parse_quotes('\\1')"  , $text );
		
		//$text = html_entity_decode($text);
		return $this->find_url($text);
		
	}
	//Unconvert Html Text => BBC Text
	function unconvert($txt="", $code=1, $html=0) {
	
		if ($code == 1)
		{
			$txt = preg_replace( "#<!--emo&(.+?)-->.+?<!--endemo-->#", "\\1" , $txt );
			
			$txt = preg_replace( "#<!--sql-->(.+?)<!--sql1-->(.+?)<!--sql2-->(.+?)<!--sql3-->#eis"    , "\$this->unconvert_sql(\"\\2\")", $txt);
			$txt = preg_replace( "#<!--html-->(.+?)<!--html1-->(.+?)<!--html2-->(.+?)<!--html3-->#e", "\$this->unconvert_htm(\"\\2\")", $txt);
		
			$txt = preg_replace( "#<!--Flash (.+?)-->.+?<!--End Flash-->#e"  , "\$this->unconvert_flash('\\1')", $txt );
			$txt = preg_replace( "#<img src=[\"'](\S+?)['\"].+?".">#"           , "\[IMG\]\\1\[/IMG\]"            , $txt );
			
			$txt = preg_replace( "#<a href=[\"']mailto:(.+?)['\"]>(.+?)</a>#"                         , "\[EMAIL=\\1\]\\2\[/EMAIL\]"   , $txt );
			$txt = preg_replace( "#<a href=[\"'](http://|https://|ftp://|news://)?(\S+?)['\"].+?".">(.+?)</a>#" , "\[URL=\\1\\2\]\\3\[/URL\]"  , $txt );
			
			$txt = preg_replace( "#<!--c1-->(.+?)<!--ec1-->#", '[CODE]'   , $txt );
			$txt = preg_replace( "#<!--c2-->(.+?)<!--ec2-->#", '[/CODE]'  , $txt );
			
			$txt = preg_replace( "#<!--QuoteBegin-->(.+?)<!--QuoteEBegin-->#"                , '[QUOTE]'         , $txt );
			$txt = preg_replace( "#<!--QuoteBegin-{1,2}([^>]+?)\+([^>]+?)-->(.+?)<!--QuoteEBegin-->#"  , "[QUOTE=\\1,\\2]" , $txt );
			$txt = preg_replace( "#<!--QuoteBegin-{1,2}([^>]+?)\+-->(.+?)<!--QuoteEBegin-->#"       , "[QUOTE=\\1]" , $txt );
			
			$txt = preg_replace( "#<!--QuoteEnd-->(.+?)<!--QuoteEEnd-->#"                    , '[/QUOTE]'        , $txt );
			
			$txt = preg_replace( "#<i>(.+?)</i>#is"  , "\[i\]\\1\[/i\]"  , $txt );
			$txt = preg_replace( "#<b>(.+?)</b>#is"  , "\[b\]\\1\[/b\]"  , $txt );
			$txt = preg_replace( "#<s>(.+?)</s>#is"  , "\[s\]\\1\[/s\]"  , $txt );
			$txt = preg_replace( "#<u>(.+?)</u>#is"  , "\[u\]\\1\[/u\]"  , $txt );
			
			$txt = preg_replace( "#(\n){0,}<ul>#" , "\\1\[LIST\]"  , $txt );
			$txt = preg_replace( "#(\n){0,}<ol type='(a|A|i|I|1)'>#" , "\\1\[LIST=\\2\]\n"  , $txt );
			$txt = preg_replace( "#(\n){0,}<li>#" , "\n\[*\]"     , $txt );
			$txt = preg_replace( "#(\n){0,}</ul>(\n){0,}#", "\n\[/LIST\]\\2" , $txt );
			$txt = preg_replace( "#(\n){0,}</ol>(\n){0,}#", "\n\[/LIST\]\\2" , $txt );
			
			$txt = preg_replace( "#<!--me&(.+?)-->(.+?)<!--e--me-->#e" , "\$this->unconvert_me('\\1', '\\2')", $txt );
			
			$txt = preg_replace( "#<span style=['\"]font-size:(.+?)pt;line-height:100%['\"]>(.+?)</span>#e" , "\$this->unconvert_size('\\1', '\\2')", $txt );
			
			while ( preg_match( "#<span style=['\"]color:(.+?)['\"]>(.+?)</span>#is", $txt ) )
			{
				$txt = preg_replace( "#<span style=['\"]color:(.+?)['\"]>(.+?)</span>#is"    , "\[color=\\1\]\\2\[/color\]", $txt );
			}
			
			$txt = preg_replace( "#<span style=['\"]font-family:(.+?)['\"]>(.+?)</span>#is", "\[font=\\1\]\\2\[/font\]", $txt );
			
			// Tidy up the end quote stuff
			
			$txt = preg_replace( "#(\[/QUOTE\])\s*?<br>\s*#si", "\\1\n", $txt );
			
			$txt = preg_replace( "#<!--EDIT\|.+?\|.+?-->#" , "" , $txt );
			
			$txt = str_replace( "</li>", "", $txt );
			
			$txt = str_replace( "&#153;", "(tm)", $txt );
		}

		if ($html == 1)
		{
			$txt = str_replace( "&#39;", "'", $txt);
		}
		
		$txt = preg_replace( "#<br>#", "\n", $txt );
		
		
		
		return trim(stripslashes($txt));
	}
	function find_url($string){
		if (SHOW_TAG_A==0) return $string;
	//"www."
	   $pattern_preg1 = '#(^|\s)(www|WWW)\.([^\s<>\.]+)\.([^\s\n<>]+)#sm';
	   $replace_preg1 = '\\1<a href="http://\\2.\\3.\\4" target="_blank" title="Nh&#7845;n v&#224;o &#273;&#226;y" style="color:blue">\\2.\\3.\\4</a>';
	
	//"http://"
	   $pattern_preg2 = '#(^|[^\"=\]]{1})(http|HTTP|ftp)(s|S)?://([^\s<>\.]+)\.([^\s<>]+)#sm';
	   $replace_preg2 = '\\1<a href="\\2\\3://\\4.\\5" target="_blank" title="Nh&#7845;n v&#224;o &#273;&#226;y" style="color:blue">\\2\\3://\\4.\\5</a>';
	  
	   $string = preg_replace($pattern_preg1, $replace_preg1, $string);
	   $string = preg_replace($pattern_preg2, $replace_preg2, $string);
	
	   return $string;
	}	
	//==========================================================================
	function show_error($report="")
	{
		?>
		<TABLE cellSpacing=1 cellPadding=4 width="100%" bgColor=#cccccc border=0>
		<TBODY>
			<tr>
				<td bgcolor="#FFFFFF">
				<font color="#FF0000"><strong><?=$report?></strong></font>
				</td>
			</tr>		
		</TBODY>
		</TABLE>
		<br>
		<?
	}
	//==========================================================================
	function drawbutton($type, $smile, $root=""){
		$html = "<td><BUTTON class='button' onmouseover='window.status=\"".$type."\"' onclick=\"javascript:smilie('".$type."')\">";
		$html.= "<IMG src=".DIR_EMOTICONS."/".$smile." border=0></BUTTON></td>";
		return $html;
	}
	//==========================================================================
	function choose_font()
	{
		$fonttype	= array("Arial", 
						"Arial Black",
						"Arial Narrow",
						"Book Antiqua",
						"Century Gothic",
						"Comic Sans MS",
						"Courier New",
						"Fixedsys",
						"Luxida Console",
						"Luxida Sans Unicode",
						"Microsoft Sans Serif",
						"System",
						"Times New Roman",
						"Trebuchet MS",
						"Verdana"
						);
		$font	.= "
		<select name='ffont' class='dropdown' onchange=\"alterfont(this.options[this.selectedIndex].value,'FONT')\" onmouseover=\"helptext('font')\">
		 <option value='0'>FONT...</option>";
		for($i=0; $i<15; $i++)
		{
			$font	.= "<option value='".$fonttype[$i]."'>".$fonttype[$i]."</option>";
		}
	   $font	.= "</select>";	
	   return $font;
	}
	//==========================================================================
	function font_size()
	{
		$html = "<select name='fsize' class='dropdown'  onchange=\"alterfont(this.options[this.selectedIndex].value,'SIZE')\" onmouseover=\"helptext('size')\">
		   <option value='0'>SIZE...</option>";
			$html	.= "<option value='8'>Nhỏ</option>";
			$html	.= "<option value='14'>Lớn</option>";
			$html	.= "<option value='21'>Rất lớn</option>";
		$html	.= "</select>";
		return $html;
	}
	//==========================================================================
	function font_color()
	{
		$html	= "
		<select name='fcolor' class='dropdown' onchange=\"alterfont(this.options[this.selectedIndex].value, 'COLOR')\" onmouseover=\"helptext('color')\">
		   <option value='0'>COLOR...</option>
		   <option value='blue' style='color:blue'>Blue</option>
		   <option value='red' style='color:red'>Red</option>
		   <option value='purple' style='color:purple'>Purple</option>
		   <option value='orange' style='color:orange'>Orange</option>
		   <option value='yellow' style='color:yellow'>Yellow</option>
		   <option value='gray' style='color:gray'>Gray</option>
		   <option value='green' style='color:green'>Green</option>
		   </select>";
		  return $html;
	}
	//==========================================================================
	function button($id="",$htext="",$bbstyle="",$val="", $style="")
	{
		$text	.= "<INPUT id=addcode".$id." class='button'
			onmouseover=\"helptext('".$htext."')\" 
			accessKey=".$bbstyle." style='".$style."'
			onclick=bbstyle(".$id.") 
			onmouseout=\"helptext('htext')\"
			type=button value=\" ".$val." \" 
			name=addcode".$id.">&nbsp;";
		return $text;	
	}
	//==========================================================================
	function icons($sl=10, $root="")
	{
		global $DIR;
		$html .= "<table width=100% border=0 cellSpacing=0 cellPadding=0><tr>";
		for($i=0; $i<$sl; $i++)
		{
			if($i==0) $check = "checked";
			else $check = "";
			if($i==10) $html .= "</tr><tr>";
			$html.= "<td><input name='icon' type='radio' value=$i $check>
					<img src='".$root.DIR_IMAGES."/icon".$i.".gif'></td>";
		}
		$html .= "</tr></table>";
		return $html;
	}
	//==========================================================================
	function nltobr($text)
	{
		$text	= ereg_replace("\n","<br>",$text);
		return $text;
	}	
	//==========================================================================
	function regex_parse_quotes($the_txt="") {
		
		if ($the_txt == "") return;
		
		$txt = $the_txt;
		
		// Too many embedded code/quote/html/sql tags can crash Opera and Moz
		
		/*if (preg_match( "/\[(quote|code|html|sql)\].+?\[(quote|code|html|sql)\].+?\[(quote|code|html|sql)\].+?\[(quote|code|html|sql)\].+?\[(quote|code|html|sql)\]/is", $txt) ) {
			$this->quote_error++;
			return $txt;
		}*/
		
		$this->quote_html = $this->wrap_style( array( 'STYLE' => 'QUOTE' ) );
		
		$txt = preg_replace( "#\[quote\]#ie"                        , "\$this->regex_simple_quote_tag()"    , $txt );
		$txt = preg_replace( "#\[quote=([^\]]+?),([^\]]+?)\]#ie"    , "\$this->regex_quote_tag('\\1', '\\2')"  , $txt );
		$txt = preg_replace( "#\[quote=([^\]]+?)\]#ie"              , "\$this->regex_quote_tag('\\1', '')"  , $txt );
		$txt = preg_replace( "#\[/quote\]#ie"                       , "\$this->regex_close_quote()"          , $txt );
		
		$txt = preg_replace( "/\n/", "<br>", $txt );
		
		if ( ($this->quote_open == $this->quote_closed) and ($this->quote_error == 0) )
		{
			$txt = preg_replace( "#(<!--QuoteEBegin-->.+?<!--QuoteEnd-->)#es", "\$this->regex_preserve_spacing('\\1')", trim($txt) );
			
			return $txt;
		}
		else
		{
			return $the_txt;
		}
		
	}
	//==========================================================================
	function regex_preserve_spacing($txt="")
	{
		$txt = preg_replace( "#\s{2}#", "&nbsp; ", trim($txt) );
		return $txt;
	}
	//==========================================================================
	function regex_simple_quote_tag() {
		$this->quote_open++;

		return "<!--QuoteBegin-->{$this->quote_html['START']}<!--QuoteEBegin-->";
		
	}
	/**************************************************/
	// regex_close_quote: closes a quote tag
	// 
	/**************************************************/	
	function regex_close_quote() {
	
		if ($this->quote_open == 0) {
			$this->quote_error++;
		 	return;
		 }
		 
		 $this->quote_closed++;
		 
		 return "<!--QuoteEnd-->{$this->quote_html['END']}<!--QuoteEEnd-->";
	}
	
	/**************************************************/
	// regex_quote_tag: Builds this quote tag HTML
	// [QUOTE=Matthew,14 February 2002]
	/**************************************************/
	
	function regex_quote_tag($name="", $date="") {
		global $ibforums;
		
		$name = str_replace( "+", "&#043;", $name );
		$name = str_replace( "-", "&#045;", $name );
		
		$default = "\[quote=$name,$date\]";
		
		$this->quote_open++;
	
		if ($date == "")
		{
			$html = $this->wrap_style( array( 'STYLE' => 'QUOTE', 'EXTRA' => "($name)" ) );
		}
		else
		{
			$html = $this->wrap_style( array( 'STYLE' => 'QUOTE', 'EXTRA' => "($name &#064; $date)" ) );
		}
		
		$extra = "-".$name.'+'.$date;
		
		return "<!--QuoteBegin".$extra."-->{$html['START']}<!--QuoteEBegin-->";
		
	}		

	//==========================================================================
	function colorphp($var,$start=1){ 
		$x=explode("<br />",highlight_string($var,true)); 
		for($i=0;$i<count($x);$i++){ 
		$v.="\n<font face='verdana' size='1' color='#000000'><strong>".$start.":</strong></font> ".$x[$i]."\n<br />"; 
		$start++; 
		} 
		$t='<table width="100%" cellpadding="2" cellspacing="0">'; 
		$t.="\n<tr valign='top'>"; 
		$t.="\n<td><span class=\"med\">PHP:</span></td>"; 
		$t.="\n<tr valign='top'>"; 
		$t.="\n<td><p class='code'>{$v}</p></td>"; 
		$t.="\n</tr>\n</table>"; 
		return $t; 
	} 

	//==========================================================================
	function unhtmlentities($string) 
	{
		// replace numeric entities
		$string = preg_replace('~&#x([0-9a-f]+);~ei', 'chr(hexdec("\\1"))', $string);
		$string = preg_replace('~&#([0-9]+);~e', 'chr(\\1)', $string);
		// replace literal entities
		$trans_tbl = get_html_translation_table(HTML_ENTITIES);
		$trans_tbl = array_flip($trans_tbl);
		return strtr($string, $trans_tbl);
	}
	
	function regex_code_tag($txt="") {
		
		$default = "\[code\]$txt\[/code\]";

		$txt = $this->unhtmlentities($txt);
		
		//echo $txt;
		/*$txt=preg_replace('/<\?(.*?)\?>/ise',"\$this->colorphp('<?\\1?>')",$txt);*/
		//$txt = "<pre>$txt</pre>";

		
		if ($txt == "") return;
		
		// Too many embedded code/quote/html/sql tags can crash Opera and Moz
		
		if (preg_match( "/\[(quote|code|html|sql)\].+?\[(quote|code|html|sql)\].+?\[(quote|code|html|sql)\].+?\[(quote|code|html|sql)\].+?\[(quote|code|html|sql)\].+?\[(quote|code|html|sql)\].+?\[(quote|code|html|sql)\]/i", $txt) ) {
			return $default;
		}
		
		// Take a stab at removing most of the common
		// smilie characters.
		
		//$txt = str_replace( "&" , "&amp;", $txt );
		
		$txt = preg_replace( "#&lt;#"   , "&#60;", $txt );
		$txt = preg_replace( "#&gt;#"   , "&#62;", $txt );
		$txt = preg_replace( "#&quot;#" , "&#34;", $txt );
		$txt = preg_replace( "#:#"      , "&#58;", $txt );
		$txt = preg_replace( "#\[#"     , "&#91;", $txt );
		$txt = preg_replace( "#\]#"     , "&#93;", $txt );
		$txt = preg_replace( "#\)#"     , "&#41;", $txt );
		$txt = preg_replace( "#\(#"     , "&#40;", $txt );
		$txt = preg_replace( "#\r#"     , "<br>", $txt );
		$txt = preg_replace( "#\n#"     , "<br>", $txt );
		$txt = preg_replace( "#\s{1};#" , "&#59;", $txt );
		
		// Ensure that spacing is preserved
		$txt = preg_replace( "#\s{2}#", " &nbsp;", $txt );
		
		$html = $this->wrap_style( array( 'STYLE' => 'CODE' ) );		
		
		return "<!--c1-->{$html['START']}<!--ec1-->$txt<!--c2-->{$html['END']}<!--ec2-->";
		
	}
	//==========================================================================
	function wrap_style( $in=array() ) {
		
		if (! isset($in['TYPE']) )  $in['TYPE']  = 'class';
		if (! isset($in['CSS']) )   $in['CSS']   = $this->in_sig == 1 ? 'signature' : 'postcolor';
		if (! isset($in['STYLE']) ) $in['STYLE'] = 'QUOTE';
		
		//-----------------------------
		// This returns two array elements:
		//  START: Contains the HTML code for the start wrapper
		//  END  : Contains the HTML code for the end wrapper
		//-----------------------------
		
		$possible_use = array( 'CODE'  => array( 'CODE',  'CODE' ),
							   'QUOTE' => array( 'QUOTE', 'QUOTE'  ),
							   'SQL'   => array( 'CODE' , 'SQL'),
							   'HTML'  => array( 'CODE' , 'HTML'),
							   'PHP'   => array( 'CODE' , 'PHP')
							 );
							 
		return array( 'START' => "</div><table border='0' align='center' width='95%' cellpadding='3' cellspacing='1'><tr><td><b>{$possible_use[$in[STYLE]][1]}</b> {$in[EXTRA]}</td></tr><tr><td id='{$possible_use[ $in[STYLE] ][0]}'>",
					  'END'   => "</td></tr></table><div {$in[TYPE]}='{$in[CSS]}'>"
					);
	}	
	//==========================================================================
	function smilies($text="")
	{
		$clsEmoticons = new Emoticons();
		$arrListEmoticons=$clsEmoticons->getAll();
		foreach($arrListEmoticons as $key => $val){
			$code = stripslashes($val['typed']);
			$image = stripslashes($val['image']);
			// Make safe for regex
			
			$code = preg_quote($code, "/");
			
			$text = " ".$text;
			
			$text = preg_replace( "!(?<=[^\w&;])$code(?=.\W|\W.|\W$)!ei", "\$this->convert_emoticon('$code', '$image')", $text );
		}
		return trim($text);
	}
	//==========================================================================
	function convert_emoticon($code="", $image="") {
		if (!$code or !$image) return;
		
		// Remove slashes added by preg_quote
		$code = stripslashes($code);
		
		return "<!--emo&".trim($code)."--><img src='".DIR_EMOTICONS."/"."$image' border='0' style='vertical-align:middle' alt='$image' /><!--endemo-->";
	}
	//==========================================================================
	function remove_smilies($text="")
	{
		global $db, $ltvn;
		$db->query("
			SELECT * 
			FROM ltvn_smilies
			");
		while($db->fetch_array($db->result))
		{
			$typed	= $db->record['code'];
			$img	= "<img src='".$ltvn->smilie.$db->record['img']."'></img>";
			$text 	= str_replace($img, $typed, $text);
		}
		return $text;
	}
	//==========================================================================
	function regex_font_attr($IN) {
		if (!is_array($IN)) return "";
		
		// Trim out stoopid 1337 stuff
		// [color=black;font-size:500pt;border:orange 50in solid;]hehe[/color]
		
		if ( preg_match( "/;/", $IN['1'] ) )
		{
			$attr = explode( ";", $IN['1'] );
			
			$IN['1'] = $attr[0];
		}
		
		$IN['1'] = preg_replace( "/[&\(\)\.\%]/", "", $IN['1'] );
		
		if ($IN['s'] == 'size')
		{
			$IN['1'] = $IN['1'] + 7;
			
			if ($IN['1'] > 30)
			{
				$IN['1'] = 30;
			}
			
			return "<span style='font-size:".$IN['1']."pt;line-height:100%'>".$IN['2']."</span>";
		}
		else if ($IN['s'] == 'col')
		{
			return "<span style='color:".$IN['1']."'>".$IN['2']."</span>";
		}
		else if ($IN['s'] == 'font')
		{
			return "<span style='font-family:".$IN['1']."'>".$IN['2']."</span>";
		}
	}
	//==========================================================================
	function handle_bbcode_php($code)
	{
		// remove empty codes
		if (trim($code) == '')
		{
			return '';
		}
	
		// get rid of leading newlines
		$code = preg_replace("#^(( )*<br[^>]*>\r\n)*#s", '', chop($code));
	
		if (!is_array($codefind))
		{
			$codefind = array(
				'<br>',		// <br> to nothing
				'<br />',	// <br /> to nothing
				'&gt;',		// &gt; to >
				'&lt;',		// &lt; to <
				'&amp;',	// &amp; to &
				'&quot;',	// &quot; to "
			);
			$codereplace = array(
				'',
				'',
				'>',
				'<',
				'&',
				'"',
			);
		}
	
		// remove htmlspecialchars'd bits
		$code = str_replace($codefind, $codereplace, $code);
	
		// do we have an opening <? tag?
		if (!preg_match('#^\s*<\?#si', $code))
		{
			// if not, replace leading newlines and stuff in a <?php tag and a closing tag at the end
			$code = "<?php BEGIN__VBULLETIN__CODE__SNIPPET $code \r\nEND__VBULLETIN__CODE__SNIPPET ?>";
			$addedtags = true;
		}
		else
		{
			$addedtags = false;
		}
	
		// highlight the string
		$oldlevel = error_reporting(0);
		if (PHP_VERSION  >= '4.2.0')
		{
			$buffer = highlight_string($code, true);
		}
		else
		{
			@ob_start();
			highlight_string($code);
			$buffer = @ob_get_contents();
			@ob_end_clean();
		}
		error_reporting($oldlevel);
	
		// if we added tags above, now get rid of them from the resulting string
		if ($addedtags)
		{
			$buffer = preg_replace(array(
				'#(<|&lt;)\?php( |&nbsp;)BEGIN__VBULLETIN__CODE__SNIPPET#siU',
				'#END__VBULLETIN__CODE__SNIPPET( |&nbsp;)\?(>|&gt;)#siU'
			), '', $buffer);
		}
	
		//$buffer = str_replace('[', '&#91;', $buffer);
	
		$code = &$buffer;
	
	//	eval('$html = "' . fetch_template('bbcode_php') . '";');
		return $code;
	}
	
}
?>