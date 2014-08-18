










<?php
print "<?xml version=\"1.0\"?>\n";
  print "<?mso-application progid=\"Excel.Sheet\"?>\n";

?>
<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet"
 xmlns:o="urn:schemas-microsoft-com:office:office"
 xmlns:x="urn:schemas-microsoft-com:office:excel"
 xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet"
 xmlns:html="http://www.w3.org/TR/REC-html40">
 <DocumentProperties xmlns="urn:schemas-microsoft-com:office:office">
  <Author>vietth</Author>
  <LastAuthor>vietth</LastAuthor>
  <Created>2009-07-07T02:34:07Z</Created>
  <Version>12.00</Version>
 </DocumentProperties>
 <ExcelWorkbook xmlns="urn:schemas-microsoft-com:office:excel">
  <WindowHeight>8445</WindowHeight>
  <WindowWidth>15255</WindowWidth>
  <WindowTopX>120</WindowTopX>
  <WindowTopY>60</WindowTopY>
  <ProtectStructure>False</ProtectStructure>
  <ProtectWindows>False</ProtectWindows>
 </ExcelWorkbook>
 <Styles>
  <Style ss:ID="Default" ss:Name="Normal">
   <Alignment ss:Vertical="Bottom"/>
   <Borders/>
   <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="11" ss:Color="#000000"/>
   <Interior/>
   <NumberFormat/>
   <Protection/>
  </Style>
 </Styles>
 <Worksheet ss:Name="Sheet1">
 
 
 
 <?php // $Id: user.php,v 1.75.2.12 2008/12/01 19:20:16 skodak Exp $

// Display user activity reports for a course

    require_once("../config.php");
    require_once("lib.php");

    $id      = required_param('id',PARAM_INT);       // course id    
    $mode    = optional_param('mode', "outline", PARAM_ALPHA);
    $page    = optional_param('page', 0, PARAM_INT);
    $perpage = optional_param('perpage', 100, PARAM_INT);

    if (! $course = get_record("course", "id", $id)) {
        error("Course id is incorrect.");
    }

    $context = get_context_instance(CONTEXT_COURSE, $course->id);
/*
    if (! $user = get_record("user", "id", $user)) {
        error("User ID is incorrect");
    }

    $coursecontext   = get_context_instance(CONTEXT_COURSE, $course->id);
    $personalcontext = get_context_instance(CONTEXT_USER, $user->id);

    require_login();
    if (has_capability('moodle/user:viewuseractivitiesreport', $personalcontext) and !has_capability('moodle/course:view', $coursecontext)) {
        // do not require parents to be enrolled in courses ;-)
        course_setup($course);
    } else {
        require_login($course);
    }
*/


$hocvien = mysql_query("SELECT DISTINCT u.id, u.username, u.firstname, u.lastname,  r.hidden, ctx.id AS ctxid, ctx.path AS ctxpath, ctx.depth AS ctxdepth, ctx.contextlevel AS ctxlevel
FROM mdl_user u
LEFT OUTER JOIN mdl_context ctx ON ( u.id = ctx.instanceid
AND ctx.contextlevel ='.CONTEXT_USER.' ) 
JOIN mdl_role_assignments r ON u.id = r.userid
LEFT OUTER JOIN mdl_user_lastaccess ul ON ( r.userid = ul.userid
AND ul.courseid =$course->id ) 
WHERE (

r.contextid =$context->id
OR r.contextid
IN ( 14, 10, 1 ) 

)
AND u.deleted =0
AND (

ul.courseid =$course->id
OR ul.courseid IS NULL 

)
AND u.username != 'guest'
AND r.roleid NOT 
IN ( 1, 2, 3, 4, 6, 8, 11 ) 
ORDER BY id ASC , r.hidden DESC 

");

$i=0;
							  echo "<table border=1>";
//---------------------------bat dau quai------------------------------------------
while($row = mysql_fetch_array($hocvien))
  {
	echo "<tr valign='top'>";
    if (! $user = get_record("user", "id", $row['id'] )) {
        error("User ID is incorrect");
    }

    if ($user->deleted) {

        print_header();
        print_heading(get_string('userdeleted'));
        print_footer();
        die;
    }

    $currenttab = $mode;
    $showroles = 1;


    switch ($mode) {
        case "grade":
            if (empty($CFG->grade_profilereport) or !file_exists($CFG->dirroot.'/grade/report/'.$CFG->grade_profilereport.'/lib.php')) {
                $CFG->grade_profilereport = 'user';
            }
            require_once $CFG->libdir.'/gradelib.php';
            require_once $CFG->dirroot.'/grade/lib.php';
            require_once $CFG->dirroot.'/grade/report/'.$CFG->grade_profilereport.'/lib.php';

            $functionname = 'grade_report_'.$CFG->grade_profilereport.'_profilereport';
            if (function_exists($functionname)) {
                $functionname($course, $user);
            }
            break;

        case "todaylogs" :
            echo '<div class="graph">';
            print_log_graph($course, $user->id, "userday.png");
            echo '</div>';
            print_log($course, $user->id, usergetmidnight(time()), "l.time DESC", $page, $perpage,
                      "user.php?id=$course->id&amp;user=$user->id&amp;mode=$mode");
            break;

        case "alllogs" :
            echo '<div class="graph">';
            print_log_graph($course, $user->id, "usercourse.png");
            echo '</div>';
            print_log($course, $user->id, 0, "l.time DESC", $page, $perpage,
                      "user.php?id=$course->id&amp;user=$user->id&amp;mode=$mode");
            break;
        case 'stats':

            if (empty($CFG->enablestats)) {
                error("Stats is not enabled.");
            }

            require_once($CFG->dirroot.'/lib/statslib.php');

            $statsstatus = stats_check_uptodate($course->id);
            if ($statsstatus !== NULL) {
                notify ($statsstatus);
            }

            $earliestday = get_field_sql('SELECT timeend FROM '.$CFG->prefix.'stats_user_daily ORDER BY timeend');
            $earliestweek = get_field_sql('SELECT timeend FROM '.$CFG->prefix.'stats_user_weekly ORDER BY timeend');
            $earliestmonth = get_field_sql('SELECT timeend FROM '.$CFG->prefix.'stats_user_monthly ORDER BY timeend');

            if (empty($earliestday)) $earliestday = time();
            if (empty($earliestweek)) $earliestweek = time();
            if (empty($earliestmonth)) $earliestmonth = time();

            $now = stats_get_base_daily();
            $lastweekend = stats_get_base_weekly();
            $lastmonthend = stats_get_base_monthly();

            $timeoptions = stats_get_time_options($now,$lastweekend,$lastmonthend,$earliestday,$earliestweek,$earliestmonth);

            if (empty($timeoptions)) {
                print_error('nostatstodisplay', '', $CFG->wwwroot.'/course/user.php?id='.$course->id.'&user='.$user->id.'&mode=outline');
            }

            // use the earliest.
            $time = array_pop(array_keys($timeoptions));

            $param = stats_get_parameters($time,STATS_REPORT_USER_VIEW,$course->id,STATS_MODE_DETAILED);

            $param->table = 'user_'.$param->table;

            $sql = 'SELECT timeend,'.$param->fields.' FROM '.$CFG->prefix.'stats_'.$param->table.' WHERE '
            .(($course->id == SITEID) ? '' : ' courseid = '.$course->id.' AND ')
                .' userid = '.$user->id
                .' AND timeend >= '.$param->timeafter
                .$param->extras
                .' ORDER BY timeend DESC';
            $stats = get_records_sql($sql);

            if (empty($stats)) {
                print_error('nostatstodisplay', '', $CFG->wwwroot.'/course/user.php?id='.$course->id.'&user='.$user->id.'&mode=outline');
            }

            // MDL-10818, do not display broken graph when user has no permission to view graph
            if ($myreports or has_capability('coursereport/stats:view', $coursecontext)) {
                echo '<center><img src="'.$CFG->wwwroot.'/course/report/stats/graph.php?mode='.STATS_MODE_DETAILED.'&course='.$course->id.'&time='.$time.'&report='.STATS_REPORT_USER_VIEW.'&userid='.$user->id.'" alt="'.get_string('statisticsgraph').'" /></center>';
            }

            // What the heck is this about?   -- MD
            $stats = stats_fix_zeros($stats,$param->timeafter,$param->table,(!empty($param->line2)),(!empty($param->line3)));

            $table = new object();
            $table->align = array('left','center','center','center');
            $param->table = str_replace('user_','',$param->table);
            switch ($param->table) {
                case 'daily'  : $period = get_string('day'); break;
                case 'weekly' : $period = get_string('week'); break;
                case 'monthly': $period = get_string('month', 'form'); break;
                default : $period = '';
            }
            $table->head = array(get_string('periodending','moodle',$period),$param->line1,$param->line2,$param->line3);
            foreach ($stats as $stat) {
                if (!empty($stat->zerofixed)) {  // Don't know why this is necessary, see stats_fix_zeros above - MD
                    continue;
                }
                $a = array(userdate($stat->timeend,get_string('strftimedate'),$CFG->timezone),$stat->line1);
                $a[] = $stat->line2;
                $a[] = $stat->line3;
                $table->data[] = $a;
            }
            print_table($table);
            break;

        case "outline" :
        case "complete" :
            get_all_mods($course->id, $mods, $modnames, $modnamesplural, $modnamesused);
            $sections = get_all_sections($course->id);

			$var++;
//Hien thong tin hoc vien			
			echo "<td>".$var."</td>";
          	echo "<td>" . $row['lastname'] . " " . $row['firstname'] ."</td>";
           
                            echo '<h2>';
							
//------------------------------hien chu de	--------------------------------------						
							
                      /*   switch ($course->format) {
                                case "weeks": print_string("week"); break;
                                case "topics": print_string("topic"); break;
                                default: print_string("section"); break;
                            }
                            echo " $i</h2>";*/
//ơ---------------------------------------------------------------------------		   
		   
		   
		   
		    for ($i=0; $i<=$course->numsections; $i++) {

                if (isset($sections[$i])) {   // should always be true

                    $section = $sections[$i];
                    $showsection = (has_capability('moodle/course:viewhiddensections', $coursecontext) or $section->visible or !$course->hiddensections);

                    if ($showsection) { // prevent hidden sections in user activity. Thanks to Geoff Wilbert!

                        if ($section->sequence) {

                           echo '<td>';
						/*    
                            echo '<h2>';
							
//hien chu de							
							
                            switch ($course->format) {
                                case "weeks": print_string("week"); break;
                                case "topics": print_string("topic"); break;
                                default: print_string("section"); break;
                            }
                            echo " $i</h2>";*/

                            echo '<div class="content">';

                            if ($mode == "outline") {
                                echo "<table cellpadding=\"4\" cellspacing=\"0\">";
                            }

                            $sectionmods = explode(",", $section->sequence);
                            foreach ($sectionmods as $sectionmod) {
                                if (empty($mods[$sectionmod])) {
                                    continue;
                                }
                                $mod = $mods[$sectionmod];

                                if (empty($mod->visible)) {
                                    continue;
                                }

                                $instance = get_record("$mod->modname", "id", "$mod->instance");
                                $libfile = "$CFG->dirroot/mod/$mod->modname/lib.php";

                                if (file_exists($libfile)) {
                                    require_once($libfile);

                                    switch ($mode) {
                                        case "outline":
                                            $user_outline = $mod->modname."_user_outline";
                                            if (function_exists($user_outline)) {
                                                $output = $user_outline($course, $user, $mod, $instance);
                                                print_outline_row($mod, $instance, $output);
                                            }
                                            break;
                                        case "complete":
                                            $user_complete = $mod->modname."_user_complete";
                                            if (function_exists($user_complete)) {
                                                $image = "<img src=\"../mod/$mod->modname/icon.gif\" ".
                                                         "class=\"icon\" alt=\"$mod->modfullname\" />";
                                                echo "<h4>$image $mod->modfullname: ".
                                                     "<a href=\"$CFG->wwwroot/mod/$mod->modname/view.php?id=$mod->id\">".
                                                     format_string($instance->name,true)."</a></h4>";

                                                ob_start();

                                                echo "<ul>";
                                                $user_complete($course, $user, $mod, $instance);
                                                echo "</ul>";

                                                $output = ob_get_contents();
                                                ob_end_clean();

                                                if (str_replace(' ', '', $output) != '<ul></ul>') {
                                                    echo $output;
                                                }
                                            }
                                            break;
                                        }
                                    }
                                }

                            if ($mode == "outline") {
                                echo "</table>";
                            }
                            echo '</div>';  // content
                            echo '</td>';  // section
                        }
                    }
                }
            }

            break;
        default:
            // can not be reached ;-)
    }
	echo "</tr>";

}
			echo "</table>";

    print_footer($course);


function print_outline_row($mod, $instance, $result) {
    global $CFG;

    $image = "<img src=\"$CFG->modpixpath/$mod->modname/icon.gif\" class=\"icon\" alt=\"$mod->modfullname\" />";

    echo "<tr>";
   // echo "<td valign=\"top\">$image</td>";
  
    echo "<td valign=\"top\" style=\"width:300\">";
    echo "   <a title=\"$mod->modfullname\"";
 // org  echo "   href=\"../mod/$mod->modname/view.php?id=$mod->id\">".format_string($instance->name,true)."</a></td>";
   echo "\"../mod/$mod->modname/view.php?id=$mod->id\">".format_string($instance->name,true)."</a></td>";
    echo "<td>&nbsp;&nbsp;&nbsp;</td>";
    echo "<td valign=\"top\">";
    if (isset($result->info)) {
        echo "$result->info";
    } else {
        echo "<p style=\"text-align:center\">-</p>";
    }
    echo "</td>";
    
	//---------------hien thoi gian -------------------
	
	/*echo "<td>&nbsp;&nbsp;&nbsp;</td>";
    if (!empty($result->time)) {
        $timeago = format_time(time() - $result->time);
        echo "<td valign=\"top\" style=\"white-space: nowrap\">".userdate($result->time)." ($timeago)</td>";
    }*/
	//------------------------------------------------
    echo "</tr>";
}

?>
  <Table ss:ExpandedColumnCount="6" <?php echo"ss:ExpandedRowCount=\"$row\""; ?> x:FullColumns="1"
   x:FullRows="1" ss:DefaultRowHeight="15">
   <Row ss:AutoFitHeight="0">
    <Cell><Data ss:Type="String">stt</Data></Cell>
    <Cell><Data ss:Type="String">hocvien</Data></Cell>
    <Cell><Data ss:Type="String">chude1</Data></Cell>
    <Cell><Data ss:Type="String">chude2</Data></Cell>
    <Cell><Data ss:Type="String">chude3</Data></Cell>
    <Cell><Data ss:Type="String">chude4</Data></Cell>
   </Row>
   <Row ss:AutoFitHeight="0">
    <Cell><Data ss:Type="Number">1</Data></Cell>
    <Cell><Data ss:Type="String">hieupd</Data></Cell>
    <Cell><Data ss:Type="String">uongbia</Data></Cell>
    <Cell><Data ss:Type="String">uongruou</Data></Cell>
    <Cell><Data ss:Type="String">xemphim</Data></Cell>
    <Cell><Data ss:Type="String">ngu</Data></Cell>
   </Row>
   <Row ss:AutoFitHeight="0">
    <Cell><Data ss:Type="Number">2</Data></Cell>
    <Cell><Data ss:Type="String">thanhnt</Data></Cell>
    <Cell><Data ss:Type="String">bayca1</Data></Cell>
    <Cell><Data ss:Type="String">bayca2</Data></Cell>
    <Cell><Data ss:Type="String">bayca3</Data></Cell>
    <Cell><Data ss:Type="String">bayca4</Data></Cell>
   </Row>
   <Row ss:AutoFitHeight="0">
    <Cell><Data ss:Type="Number">2</Data></Cell>
    <Cell><Data ss:Type="String">thanhnt</Data></Cell>
    <Cell><Data ss:Type="String">bayca1</Data></Cell>
    <Cell><Data ss:Type="String">bayca2</Data></Cell>
    <Cell><Data ss:Type="String">bayca3</Data></Cell>
    <Cell><Data ss:Type="String">bayca4</Data></Cell>
   </Row>
  </Table>
  <WorksheetOptions xmlns="urn:schemas-microsoft-com:office:excel">
   <PageSetup>
    <Header x:Margin="0.3"/>
    <Footer x:Margin="0.3"/>
    <PageMargins x:Bottom="0.75" x:Left="0.7" x:Right="0.7" x:Top="0.75"/>
   </PageSetup>
   <Unsynced/>
   <Selected/>
   <Panes>
    <Pane>
     <Number>3</Number>
     <ActiveRow>3</ActiveRow>
     <RangeSelection>R4C1:R4C6</RangeSelection>
    </Pane>
   </Panes>
   <ProtectObjects>False</ProtectObjects>
   <ProtectScenarios>False</ProtectScenarios>
  </WorksheetOptions>
 </Worksheet>
 <Worksheet ss:Name="Sheet2">
  <Table ss:ExpandedColumnCount="1" ss:ExpandedRowCount="1" x:FullColumns="1"
   x:FullRows="1" ss:DefaultRowHeight="15">
   <Row ss:AutoFitHeight="0"/>
  </Table>
  <WorksheetOptions xmlns="urn:schemas-microsoft-com:office:excel">
   <PageSetup>
    <Header x:Margin="0.3"/>
    <Footer x:Margin="0.3"/>
    <PageMargins x:Bottom="0.75" x:Left="0.7" x:Right="0.7" x:Top="0.75"/>
   </PageSetup>
   <Unsynced/>
   <ProtectObjects>False</ProtectObjects>
   <ProtectScenarios>False</ProtectScenarios>
  </WorksheetOptions>
 </Worksheet>
 <Worksheet ss:Name="Sheet3">
  <Table ss:ExpandedColumnCount="1" ss:ExpandedRowCount="1" x:FullColumns="1"
   x:FullRows="1" ss:DefaultRowHeight="15">
   <Row ss:AutoFitHeight="0"/>
  </Table>
  <WorksheetOptions xmlns="urn:schemas-microsoft-com:office:excel">
   <PageSetup>
    <Header x:Margin="0.3"/>
    <Footer x:Margin="0.3"/>
    <PageMargins x:Bottom="0.75" x:Left="0.7" x:Right="0.7" x:Top="0.75"/>
   </PageSetup>
   <Unsynced/>
   <ProtectObjects>False</ProtectObjects>
   <ProtectScenarios>False</ProtectScenarios>
  </WorksheetOptions>
 </Worksheet>
</Workbook>
