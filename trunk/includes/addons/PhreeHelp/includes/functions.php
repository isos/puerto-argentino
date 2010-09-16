<?php 
// functions.php

function check_version() {
	global $db;
	// check to see that all tables are present
	install_db();
	// load version number from db
	$config = $db->Execute('select db_version from ' . DB_PREFIX . 'zh_config');
	$db_version = $config->fields['db_version'];
	$config_file = file(DOC_REL_PATH . '/' . VERSION_FILENAME);
	if (is_array($config_file)) {
		foreach ($config_file as $line) {
			if (substr(trim($line), 0, 7) == 'version') {
				$file_version = trim(substr($line, strpos($line,'=') + 1, strpos($line,';') - strpos($line,'=') - 1));
				break;
			}
		}
	} else {
		die(TEXT_NO_VERSION . VERSION_FILENAME . '<br />' . TEXT_CHECK_CONFIG);
	}
//echo 'db_version='.$db_version.' and file_version='.$file_version.'<br />';
	if ($db_version <> $file_version) {
		synchronize($file_version);
	}
	return;
}

function synchronize($file_version) {
	global $db;
	// Clean the databases
	$config = $db->Execute('delete from ' . DB_PREFIX . 'zh_search');
	$config = $db->Execute('delete from ' . DB_PREFIX . 'zh_index');
	$config = $db->Execute('delete from ' . DB_PREFIX . 'zh_glossary');
	// recursively read file and store in db
	$extensions = explode(',',VALID_EXTENSIONS);
	$file_list = directory_to_array(DOC_REL_PATH, $extensions);
	foreach ($file_list as $file_name) {
		$file_name = str_replace(DOC_REL_PATH, DOC_ROOT_URL, $file_name); // convert to url to read script generated filenames
		$tags = get_meta_tags($file_name);
// error check tags
		$doc_text = trim(strip_tags(file_get_contents($file_name)));
		// process out special characters
		$doc_text = str_replace(chr(10), ' ', $doc_text);
//		$doc_text = str_replace(chr(13), '', $doc_text);
		$sql = "insert into " . DB_PREFIX . "zh_search (doc_url, doc_pos, doc_title, doc_text)
			values ('" . $file_name . "', '" . $tags['doc_pos'] . "', '" . $tags['doc_title'] . "', '" . addslashes($doc_text) . "')";
		$row = $db->Execute($sql);
		// process index
		$x = 1;
		while (true) {
			if (isset($tags['doc_index_' . $x])) {
				$sql = "insert into " . DB_PREFIX . "zh_index (doc_url, doc_index) 
					values ('" . $file_name . "', '" . $tags['doc_index_' . $x] . "')";
				$row = $db->Execute($sql);
			} else {
				break;
			}
			$x++;
		}
		// process glossary
	}
	// Build glossary
// add glossary processing
	// update db version field to newly loaded version
	$success = $db->Execute("update " . DB_PREFIX . "zh_config set db_version = '" . $file_version . "'");
}

function directory_to_array($directory, $extension = "", $full_path = true) {
	$array_items = array();
	if ($handle = opendir($directory)) {
		while (false !== ($file = readdir($handle))) {
			if ($file != "." && $file != "..") {
				if (is_dir($directory. "/" . $file)) {
					$array_items = array_merge($array_items, directory_to_array($directory. "/" . $file, $extension, $full_path)); 
				} else {
					$file_ext = substr(strrchr($file, "."), 1);
					if(!$extension || in_array($file_ext, $extension)) {
						if($full_path) {
							$array_items[] = $directory . "/" . $file;
						} else {
							$array_items[] = $file;
						}
					}
				}
			}
		}
		closedir($handle);
	} else {
		die (TEXT_FAILED_OPEN_DIR . $directory);
	}
	return $array_items;
}

function retrieve_toc() {
	global $db;
	$toc = $db->Execute('select doc_url, doc_pos, doc_title from ' . DB_PREFIX . 'zh_search order by doc_pos');
	$toc_array = array();
	while (!$toc->EOF) {
		$element = explode('.', $toc->fields['doc_pos']);
		switch (count($element)) { // currently handles five levels deep
			case '1':
				$toc_array[$element[0]]['doc_url'] = $toc->fields['doc_url'];
				$toc_array[$element[0]]['doc_title'] = $toc->fields['doc_title'];
				break;
			case '2':
				$toc_array[$element[0]]['children'][$element[1]]['doc_url'] = $toc->fields['doc_url'];
				$toc_array[$element[0]]['children'][$element[1]]['doc_title'] = $toc->fields['doc_title'];
				break;
			case '3':
				$toc_array[$element[0]]['children'][$element[1]]['children'][$element[2]]['doc_url'] = $toc->fields['doc_url'];
				$toc_array[$element[0]]['children'][$element[1]]['children'][$element[2]]['doc_title'] = $toc->fields['doc_title'];
				break;
			case '4':
				$toc_array[$element[0]]['children'][$element[1]]['children'][$element[2]]['children'][$element[3]]['doc_url'] = $toc->fields['doc_url'];
				$toc_array[$element[0]]['children'][$element[1]]['children'][$element[2]]['children'][$element[3]]['doc_title'] = $toc->fields['doc_title'];
				break;
			case '5':
				$toc_array[$element[0]]['children'][$element[1]]['children'][$element[2]]['children'][$element[3]]['children'][$element[4]]['doc_url'] = $toc->fields['doc_url'];
				$toc_array[$element[0]]['children'][$element[1]]['children'][$element[2]]['children'][$element[3]]['children'][$element[4]]['doc_title'] = $toc->fields['doc_title'];
				break;
			default: // no document position specified, ignore
		}
		$toc->MoveNext();
	}
//echo '<br />'; print_r($toc_array); echo '<br />';
	$toc_string =  build_href($toc_array, $ref = 'doc');
	return $toc_string;
}

function build_href($array_tree, $ref = '') {
	ksort($array_tree);
	$entry_string = '';
	foreach ($array_tree as $key=>$entry) {
		$new_ref = $ref . $key;
		$entry_string .= '<table border=0 cellpadding="1" cellspacing="1"><tr>' . chr(10);
		if (isset($entry['children'])) {
			$entry_string .= '<td><a id="zh_' . $new_ref . '" href="javascript:Toggle(\'' . $new_ref . '\');"><img src="css/' . DEFAULT_STYLE . '/images/folder.gif" width="16" height="16" hspace="0" vspace="0" border="0"></a></td>';
		} else {
			$entry_string .= '<td><img src="css/' . DEFAULT_STYLE . '/images/text.gif" width="16" height="16" hspace="0" vspace="0" border="0"></td>';
		}
		if (isset($entry['doc_title'])) {
			if (isset($entry['doc_url'])) {
				$entry_string .= '<td><a href="' . $entry['doc_url'] . '" target="mainFrame">' . $entry['doc_title'] . '</a></td>';
			} else {
				$entry_string .= '<td>' . $entry['doc_title'] . '</td>';
			}
		} else {
			$entry_string .= '<td>' . 'Untitled' . '</td>';
		}
		$entry_string .= chr(10) . '</tr></table>' . chr(10);

		if (isset($entry['children'])) {
			$entry_string .= '<div id="' . $new_ref . '" style="display:none; margin-left:1px;">' . chr(10) . chr(10);
			$entry_string .= build_href($entry['children'], $new_ref) . chr(10);
			$entry_string .= '</div>' . chr(10);
		}
	}
	return $entry_string;
}

function retrieve_index() {
	global $db;
	$index = $db->Execute('select doc_url, doc_index from ' . DB_PREFIX . 'zh_index order by doc_index');
	$index_array = array();
	while (!$index->EOF) {
		$element = explode('.', $index->fields['doc_index']);
		switch (count($element)) { // currently handles two levels deep
			case '1':
				$index_array[$element[0]]['doc_url'] = $index->fields['doc_url'];
				$index_array[$element[0]]['doc_title'] = $element[0];
				break;
			case '2':
				$index_array[$element[0]]['doc_title'] = $element[0];
				$index_array[$element[0]]['children'][$element[1]]['doc_url'] = $index->fields['doc_url'];
				$index_array[$element[0]]['children'][$element[1]]['doc_title'] = $element[1];
				break;
			default: // no index specified, ignore
		}
		$index->MoveNext();
	}
	$index_string =  build_href($index_array, $ref = 'idx');
	return $index_string;
}

function search_results($search_field) {
	global $db;
	if (!$search_field) return '';
	$sql = "select doc_url, doc_title, 
		MATCH (doc_title, doc_text) AGAINST ('" . $search_field . "') as score 
		from " . DB_PREFIX . "zh_search
		where MATCH (doc_title, doc_text) AGAINST ('" . $search_field . "')";
	$results = $db->Execute($sql);
	if ($results->RecordCount() == 0) return TEXT_NO_RESULTS;
	$search_array = array();
	$index = 0;
	while (!$results->EOF) {
		$score = number_format($index->fields['score'], 2);
		$search_array[$index]['doc_url'] = $results->fields['doc_url'];
		$search_array[$index]['doc_title'] = $results->fields['doc_title'];
		$index++;
		$results->MoveNext();
	}
	$search_string =  build_href($search_array, $ref = '');
	return $search_string;
}

function install_db() {
	global $db;
	// check for the tables needed and create if not there.
	$result = $db->Execute('SHOW TABLES FROM ' . DB_DATABASE);
	$tables = array();
	while (!$result->EOF) {
		$tables[] = array_pop($result->fields);
		$result->MoveNext();
	}
	
	// check for config table
	if (!in_array(DB_PREFIX . 'zh_config', $tables)) { // need to add the config table
		$sql = "CREATE TABLE " . DB_PREFIX . "zh_config (
			id int(10) unsigned NOT NULL auto_increment,
			db_version varchar(15) collate utf8_unicode_ci default NULL,
			PRIMARY KEY (id)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT = 'Configuration parameters for PhreeHelp'";
		$result = $db->Execute($sql);
		if (!$result) die ($db->show_error());
		// fill the table with default information
		$sql = "INSERT INTO " . DB_PREFIX . "zh_config (db_version) VALUES (0.00)";
		$result = $db->Execute($sql);
	}
	
	// check for search table
	if (!in_array(DB_PREFIX . 'zh_search', $tables)) { // need to add the sort and search table
		$sql = "CREATE TABLE " . DB_PREFIX . "zh_search (
			id int(10) unsigned NOT NULL auto_increment,
			doc_url varchar(255) collate utf8_unicode_ci default NULL,
			doc_pos varchar(16) collate utf8_unicode_ci default NULL,
			doc_title varchar(255) collate utf8_unicode_ci default NULL,
			doc_text text collate utf8_unicode_ci,
			PRIMARY KEY (id),
			FULLTEXT KEY doc_title (doc_title, doc_text)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT = 'Sort and search data for PhreeHelp'";
		$result = $db->Execute($sql);
		if (!$result) die ($db->show_error());
	}
	
	// check for index table
	if (!in_array(DB_PREFIX . 'zh_index', $tables)) { // need to add the sort and search table
		$sql = "CREATE TABLE " . DB_PREFIX . "zh_index (
			id int(10) unsigned NOT NULL auto_increment,
			doc_url varchar(255) collate utf8_unicode_ci default NULL,
			doc_index varchar(255) collate utf8_unicode_ci default NULL,
			PRIMARY KEY (id)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT = 'Index database for PhreeHelp'";
		$result = $db->Execute($sql);
		if (!$result) die ($db->show_error());
	}
	
	// check for glossary table
	if (!in_array(DB_PREFIX . 'zh_glossary', $tables)) { // need to add the sort and search table
		$sql = "CREATE TABLE " . DB_PREFIX . "zh_glossary (
			id int(10) unsigned NOT NULL auto_increment,
			doc_glossary varchar(64) collate utf8_unicode_ci default NULL,
			doc_definition text collate utf8_unicode_ci,
			PRIMARY KEY (id)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT = 'Glossary database for PhreeHelp'";
		$result = $db->Execute($sql);
		if (!$result) die ($db->show_error());
	}
} // end install_db

?>