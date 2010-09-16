<?php

class Translator {
	/**
	 *Konstruktor
	 *param string $ps_index betolti az index.html filet (altalaban)
	 */
	public function __construct()
	{
	}

	function delete_directory($dirname)
	{
		if (is_dir($dirname))
			$dir_handle = opendir($dirname);
		if (!$dir_handle)
			return false;
		while($file = readdir($dir_handle))
		{
			if ($file != "." && $file != "..")
			{
				if (!is_dir($dirname."/".$file))
					unlink($dirname."/".$file);
				else
					$this->delete_directory($dirname.'/'.$file);
			}
	   }
		closedir($dir_handle);
		rmdir($dirname);
		return true;
	}
	function full_copy( $source, $target )
	{
		if ( is_dir( $source ) ) {
			@mkdir( $target );
			$d = dir( $source );
			while ( FALSE !== ( $entry = $d->read() ) )
			{
				if ( $entry == '.' || $entry == '..' )
				{
					continue;
				}
				$Entry = $source . '/' . $entry;
				if ( is_dir( $Entry ) )
				{
					$this->full_copy( $Entry, $target . '/' . $entry );
					continue;
				}
				copy( $Entry, $target . '/' . $entry );
			}
			$d->close();
		}
		else
		{
			copy( $source, $target );
		}
	}

	public function zebra()
	{
		static $i = 0;
		$i++;
		if($i%2 == 0)
			return 'even';
		else
			return 'odd';
	}

	//----------------------------------------------FROM NOW: PHREEBOOKS TRANSLATOR SPECIFIC FILES ------------------------------------------------------------
	//now used by functions: getReleasesAsTable and getReleasesAsSelect
	public function getReleases()
	{
		global $db;
		$sql = "SELECT * FROM " . TABLE_TRANSLATOR_RELEASES . " ORDER BY title DESC";
		$return = Array();
		$result = $db->Execute($sql);
		while(!$result->EOF)
		{
			$return[] = $result->fields;
			$result->MoveNext();
		}
		return $return;
	}

	//gets all files for a specific release
	//used by getFilesForReleaseAsTable
	public function getFilesForRelease($pi_release,$pi_module)
	{
		global $db;
		$sql = "SELECT f.*,m.title FROM " . TABLE_TRANSLATOR_FILES . " AS f
				JOIN ".TABLE_TRANSLATOR_MODULES." AS m ON f.module = m.id
				WHERE f.release_id = '".$pi_release."'";
		if($pi_module > 0)
			$sql .= " AND f.module = '".$pi_module."'";
		$sql .= " ORDER BY module,file";
		//exit;
		$return = Array();
		$file = $db->Execute($sql);
		while(!$file->EOF)
		{
			$return[] = $file->fields;
			$file->MoveNext();
		}
		return $return;
	}

	//gets all translateble strings for file
	public function getStringsToTranslateForFile($pi_fileid,$ps_definedkey = '',$ps_original = '',$ps_translation = '',$pi_translated = 3)
	{
		global $db;
		if($pi_duplicates != 1)
		{
			$sql = "SELECT * FROM " . TABLE_TRANSLATOR_TRANSLATIONS . " WHERE file = '".$db->prepare_input($pi_fileid)."'";
			if(!empty($ps_definedkey))
				$sql .= " AND defined_key LIKE '%".$ps_definedkey."%'";
			if(!empty($ps_original))
				$sql .= " AND original LIKE '%".$ps_original."%'";
			if(!empty($ps_translation))
				$sql .= " AND translation LIKE '%".$ps_translation."%'";
			if($pi_translated < 2 && $pi_translated != '')
				$sql .= " AND translated = '".$pi_translated."'";
		}
		$return = Array();
		$translation = $db->Execute($sql);
		while(!$translation->EOF)
		{
			$return[] = $translation->fields;
			$translation->MoveNext();
		}
		return $return;
	}
	/**
	 *lists all zip all tar.gz file from directory defined by UPLOAD_DIR
	 *you can upload phreebooks.zip file here
	*/
	public function getInstallableReleases()
	{
		$return = Array();
		if(is_dir(UPLOAD_DIR))
		{
			$UPLOAD_DIR = opendir(UPLOAD_DIR);
			while($file = readdir($UPLOAD_DIR))
			{
				if($file != '.' && $file != '..' && (strstr($file,'.tar.gz') || strstr($file,'.zip')))
				{
					$return[] = $file;
				}
			}
		}
		else
			mkdir(UPLOAD_DIR);
		return $return;
	}
	/**
	 *extracts the phreebooks.zip or phreebooks.tar.gz file
	*/
	public function extractRelease($pi_filename)
	{
		global $messageStack;
		if(is_file(UPLOAD_DIR.$pi_filename))
		{
			if(!is_dir(INSTALL_TEMP_DIR))
				mkdir(INSTALL_TEMP_DIR);
			if(is_dir(INSTALL_TEMP_DIR.session_id()))
				$this->delete_directory(INSTALL_TEMP_DIR.session_id());
			mkdir(INSTALL_TEMP_DIR.session_id());
			//only zip or tar.gz is supported
			if(strstr($pi_filename,'.tar.gz'))
				exec('tar xvf '.UPLOAD_DIR.$pi_filename.' --directory='.INSTALL_TEMP_DIR.session_id());
			else
				exec('unzip -u '.UPLOAD_DIR.$pi_filename.' -d '.INSTALL_TEMP_DIR.session_id());
		}
		else
		{
			$messageStack->add('Hiba történt, a telepítendő fájl nem létezik!','error');
		}
	}
	public function getTempRoot($current = false)
	{
		global $messageStack;
		if($current)
			return DIR_FS_ADMIN;
		else
		{
			$path = INSTALL_TEMP_DIR.session_id();
			/*till now there was always a directory in the zip file
			 *Example:
			 * phreebooksR1.8.zip contains: phreebooksR1.8
			*/
			$dir = opendir($path);
			while($file = readdir($dir))
			{
				if(is_dir($path.'/'.$file) && $file != '.' && $file != '..')
				{
					$path .= '/'.$file.'/';
					break;
				}
			}
			if(!is_dir($path))
			{
				$messageStack->add('Could not find the extracted folder: '.$path, 'error');
				return false;
			}
			else
				return $path;
		}
	}
	public function addRelease($pa_data)
	{
		global $messageStack;
		global $db;
		if($pa_data['id'] == 'current_installation')
			$source_path = $this->getTempRoot(true);
		else
			$source_path = $this->getTempRoot(false);

		$sql = "INSERT INTO " . TABLE_TRANSLATOR_RELEASES . " (id,title,source_lang,destination_lang,description,translated_only,added) VALUES(
					'',
					'".$db->prepare_input($_SESSION['release_options']['title'])."',
					'".$db->prepare_input($_SESSION['release_options']['source_lang'])."',
					'".$db->prepare_input($_SESSION['release_options']['destination_lang'])."',
					'".$db->prepare_input($_SESSION['release_options']['description'])."',
					'".$db->prepare_input($_SESSION['release_options']['translated_only'])."',
					'".date('Y-m-d H:i:s')."'
					)";
		$db->Execute($sql);
		$release_id = $db->insert_ID();
		if(!$release_id > 0)
		{
			$messageStack->add('There was an error inserting the new Release into database<br>
							   The failing SQL was: '.$sql, 'error');
		}

		if(!is_dir(STORAGE_DIR))
			mkdir(STORAGE_DIR);
		@mkdir(STORAGE_DIR.$release_id);
		$this->replace_path = $source_path;

		//$this->searchLangDir($path,$release_id,$pa_data['source_lang']);
		foreach($_SESSION['translation_modules'] as $key => $value)
		{
			//check if module input box is checked
			if($pa_data[$key] != 1)
				continue;

			//$key == module name
			//$value[] == module data
			$_SESSION['translation_modules'][$key]['insertid'] = $this->addModule($release_id,$key,$value['module_path'],$pa_data['source_lang']);
			foreach($value['files'] as $v)
			{
				//echo $key.'_'.str_replace('.php','_php',$v['file_name']).': '.$pa_data[$key.'_'.str_replace('.php','_php',$v['file_name'])].'<br>';
				if($pa_data[$key.'_'.str_replace('.php','_php',$v['file_name'])] != 1)
					continue;
				//$v == file data
				//first copy the file if needed
				//create the containing dir if not exists
				$destination_path = STORAGE_DIR.$release_id.'/';
				$destination_path .= str_replace($source_path,'',$v['file_path']);
				if(!is_dir($destination_path))
					@mkdir($destination_path,0700,true);
				copy($v['file_path'].$v['file_name'],$destination_path.$v['file_name']);
				$this->addLangFile($v['file_name'],$v['file_path'],$release_id,$_SESSION['translation_modules'][$key]['insertid']);
			}
		}
	}
	public function addModule($pi_release,$ps_title,$ps_path,$ps_lang)
	{
		global $db;
		$sql = "INSERT INTO ".TABLE_TRANSLATOR_MODULES." VALUES(
					'',
					'".$pi_release."',
					'".$db->prepare_input($ps_title)."',
					'".$db->prepare_input(str_replace($this->replace_path,'',$ps_path))."'
				)";
		$db->Execute($sql);
		@mkdir(STORAGE_DIR.$pi_release.'/'.$ps_path.$ps_title.'/language/'.$ps_lang,0770,true);
		return $db->insert_ID();
	}
	/**
	 *the only thing it doesnt do is file copy
	*/
	public function addLangFile($ps_file,$ps_path,$pi_release,$pi_module)
	{
		global $db;
		$langfile = file_get_contents($ps_path.$ps_file);

		$path = str_replace(STORAGE_DIR.$pi_release."/",'',$ps_path);
		$sql = "INSERT INTO " . TABLE_TRANSLATOR_FILES . " (id,release_id,module,file,path) VALUES(
					'',
					'".$pi_release."',
					'".$pi_module."',
					'".$db->prepare_input($ps_file)."',
					'".$db->prepare_input(str_replace($this->replace_path,'',$path))."'
					)";
		$db->Execute($sql);
		$file_id = $db->insert_ID();
		preg_match_all("|define\('(.+)',[\s]*(.*)\);|imsU",$langfile,$langtemp);
		for($i = 0; $i < count($langtemp[1]); $i++)
		{
			$string = $db->prepare_input(trim($langtemp[2][$i],"' "));
			//echo $sql.'<br>';
			$sql = "INSERT INTO " . TABLE_TRANSLATOR_TRANSLATIONS . " (id,file,defined_key,original,translation,translated) VALUES(
						'',
						'".$file_id."',
						'".$db->prepare_input($langtemp[1][$i])."',
						'".$string."',
						'".$string."',
						'0'
					)";
			$db->Execute($sql);
			//echo $sql.'<br>';
		}
	}
	/**
	 *searches for language dir
	 *you can define by $ps_sourcelang what to search for
	 *default is 'language/en_us'
	 *the parent name of the language dir will be the module name
	 *save it to $_SESSION['translation_files']['modul_name']
	*/
	public function searchModules($ps_path,$ps_lang = 'en_us')
	{

		$dir = opendir($ps_path);
		while($file = readdir($dir))
		{
			if($file != '.' && $file != '..')
			{
				//dont search in translator working directories
				//because it will be an endless loop
				if( 	$ps_path.$file.'/' == STORAGE_DIR ||
					   $ps_path.$file.'/' == INSTALL_TEMP_DIR ||
					   $ps_path.$file.'/' == EXPORT_TEMP_DIR
					   //$ps_path.$file.'/' == INSTALL_DIR
				   )
					continue;
				//in this case it is a language dir
				if($file == 'language' && is_dir($ps_path.'language/'.$ps_lang))
				{
					$modules = explode('/',$ps_path);
					$module_name = $modules[count($modules)-2];
					$module_path = str_replace(array(DIR_FS_ADMIN,$module_name.'/'),'',$ps_path);
					//echo $ps_path.'<br>';
					//$files = Array();
					$_SESSION['translation_modules'][$module_name]['module_path'] = $module_path;
					$this->processLangDir($module_name,$ps_path.'language/'.$ps_lang.'/');
				}
				//else continue searching for language dirs
				else if(is_dir($ps_path.$file))
				{
					$this->searchModules($ps_path.$file.'/',$ps_lang);
				}
			}
		}
	}


	/**
	 *gets a language dir from installPhreebooksRelease
	 *it searches for dirs in language dir by calling itself recursively
	*/
	private function processLangDir($ps_module,$ps_path)
	{
		global $_SESSION;
		$dir = opendir($ps_path);
		while($file = readdir($dir))
		{
			if($file != '.' && $file != '..')
			{
				if(is_dir($ps_path.$file))
					$this->processLangDir($ps_module,$ps_path.$file.'/');
				else if(strstr($file,'.php') !== false)
					$_SESSION['translation_modules'][$ps_module]['files'][] = array('file_path' => $ps_path,'file_name' => $file);
			}
		}
	}

	public function getReleaseData($pi_release)
	{
		global $db;
		$sql = "SELECT * FROM " . TABLE_TRANSLATOR_RELEASES . " WHERE id = '".$db->prepare_input($pi_release)."'";
		$return = $db->Execute($sql);
		return $return->fields;
	}
	public function updateRelease($pa_data)
	{
		global $db;
		$sql = "UPDATE " . TABLE_TRANSLATOR_RELEASES . " SET
					title = '".$db->prepare_input($pa_data['title'])."',
					description = '".$db->prepare_input($pa_data['description'])."',
					translated_only = '".$db->prepare_input($pa_data['translated_only'])."',
					destination_lang = '".$db->prepare_input($pa_data['destination_lang'])."'
				WHERE id = '".$db->prepare_input($pa_data['id'])."'";
		$db->Execute($sql);
		if($pa_data['update_from'] != 0)
		{
			//need to know the source languages
			$sql = "SELECT source_lang FROM ".TABLE_TRANSLATOR_RELEASES."
					WHERE id = '".$pa_data['id']."'
					";
			$to_lang = $db->Execute($sql);
			$sql = "SELECT source_lang FROM ".TABLE_TRANSLATOR_RELEASES."
					WHERE id = '".$pa_data['update_from']."'
					";
			$from_lang = $db->Execute($sql);

			$sql = "SELECT defined_key,translation,f.file,path
					FROM " . TABLE_TRANSLATOR_TRANSLATIONS . " t
					JOIN " . TABLE_TRANSLATOR_FILES . " f
						ON f.id = t.file
							AND	f.release_id = '".$db->prepare_input($pa_data['update_from'])."'
					ORDER BY f.id
					";
			$from = $db->Execute($sql);
			while(!$from->EOF)
			{
				//translate only what is different
				$sql = "SELECT t.id,t.translation FROM ".TABLE_TRANSLATOR_TRANSLATIONS." t
						JOIN ".TABLE_TRANSLATOR_FILES." f
							ON f.id = t.file
								AND f.release_id = '".$db->prepare_input($pa_data['id'])."'
								AND f.path = '".str_replace('/'.$from_lang->fields['source_lang'].'/','/'.$to_lang->fields['source_lang'].'/',$from->fields['path'])."'
								AND t.defined_key = '".$db->prepare_input($from->fields['defined_key'])."'
								AND f.file = '".$db->prepare_input($from->fields['file'])."'
						";
				$to_translate = $db->Execute($sql);

				if($to_translate->RecordCount() == 1 && $to_translate->fields['id'] && $to_translate->fields['translation'] != $from->fields['translation'])
				{
					$sql = "UPDATE ".TABLE_TRANSLATOR_TRANSLATIONS." t
							SET translation = '".addslashes($from->fields['translation'])."',
								translated = '1'
							WHERE t.id = '".$to_translate->fields['id']."'
							";
					$db->Execute($sql);
				}
				$from->MoveNext();
			}
		}
	}
	public function updateTranslationStrings($pa_data)
	{
		global $db;
		foreach($pa_data as $key => $value)
		{
			if(strstr($key,'translation_'))
			{
				$id = str_replace('translation_','',$key);
				$sql = "UPDATE " . TABLE_TRANSLATOR_TRANSLATIONS . " SET
							translation = '".$value."',
							translated = '".$db->prepare_input($pa_data['translated_'.$id])."'
						WHERE id = '".$id."'
					";
				$db->Execute($sql);
			}
		}
	}
	public function getFilenameFromID($pi_fileid)
	{
		global $db;
		$sql = "SELECT file FROM " . TABLE_TRANSLATOR_FILES . " WHERE id = '".$db->prepare_input($pi_fileid)."'";
		$filename = $db->Execute($sql);
		return $filename->fields['file'];
	}
	public function Export($pa_data)
	{
		global $db;
		global $messageStack;
		if($pa_data['export_to'] == 'current_installation')
			$path = DIR_FS_ADMIN;
		else
		{
			$path = EXPORT_TEMP_DIR.session_id().'/';
			//clean the export dir
			if(is_dir($path))
				$this->delete_directory($path);
			$path .= $pa_data['id'].'/';
			//create the main dir
			mkdir($path,0770,true);
		}
		//need to determine original source lang
		$sql = "SELECT source_lang,destination_lang,translated_only FROM ".TABLE_TRANSLATOR_RELEASES." WHERE id = '".$db->prepare_input($pa_data['id'])."'";
		$release = $db->Execute($sql);
		//get files to export
		foreach($pa_data['files'] as $fid)
		{
			$fid = $db->prepare_input($fid);
			//select file data
			$sql = "SELECT file,path
					FROM ".TABLE_TRANSLATOR_FILES."
					WHERE id = '".$fid."'
					";
			$file = $db->Execute($sql);
			$src_file = STORAGE_DIR.$pa_data['id'].'/'.$file->fields['path'].$file->fields['file'];
			$dest_path = $path.str_replace('/'.$release->fields['source_lang'].'/','/'.$pa_data['language'].'/',$file->fields['path']);
			$dest_file = $dest_path.$file->fields['file'];
			//create necessary directories
			if(!is_dir($dest_path))
				@mkdir($dest_path,0700,true);
			if(is_file($src_file))
			{
				//load the original file
				$filedata = file_get_contents($src_file);
				//load the translated strings from database
				$sql = "SELECT defined_key,translation,original
						FROM ".TABLE_TRANSLATOR_TRANSLATIONS."
						WHERE file = '".$fid."'
						ORDER BY id DESC
						";
				if($release->fields['translated_only'])
					$sql .= " AND translated = '1'";
				$translations = $db->Execute($sql);
				while(!$translations->EOF)
				{
					//search for string
                    //preg_match_all("|define\('(.*)','(.*)'\);|imU",$langfile,$langtemp);
                    $replace = "define('".$translations->fields['defined_key']."','".$translations->fields['translation']."');";
					$original = preg_quote($translations->fields['original']);
					$translation = "define('".$translations->fields['defined_key']."','".$translations->fields['translation']."');";
					$filedata = preg_replace("|define\('".$translations->fields['defined_key']."',[\s]*\'".$original."\'\);|imU",$translation,$filedata,1,$success);
					if(!$success)
					{
						$translation = "define('".$translations->fields['defined_key']."',".$translations->fields['translation'].");";
						$filedata = preg_replace("|define\('".$translations->fields['defined_key']."',[\s]*\'".$original."\'\);|imU",$translation,$filedata,1);
					}
					//echo $original.'<br>';
				//$filedata = preg_replace("|define\('".$translations->fields['defined_key']."',[\s]*'.*'\);|imsU",$mire,$filedata);
//					var_dump($filedata);
	//			exit;

//ez jo
//$filedata = preg_replace("|define\('".$translations->fields['defined_key']."',[\s]*\'.*\'\);|imsU","define('".$translations->fields['defined_key']."','".$translations->fields['translation']."');",$filedata);
					$translations->MoveNext();
				}
				file_put_contents($dest_file,$filedata);
			}
			else
			{
				//TODO some error message
				continue;
			}
		}
		if($pa_data['export_to'] != 'current_installation')
		{
			exec('cd '.EXPORT_TEMP_DIR.session_id().'/; zip -r phreebooks_translation_'.$pa_data['language'].'.zip '.$pa_data['id']);
			rename(EXPORT_TEMP_DIR.session_id().'/phreebooks_translation_'.$pa_data['language'].'.zip',DIR_FS_MY_FILES.'phreebooks_translation_'.$pa_data['language'].'.zip');
			$this->delete_directory(EXPORT_TEMP_DIR.session_id());
			$messageStack->add_session('Phreebooks Release exported to : <b>"'.DIR_FS_MY_FILES . '"</b> on your server.','success');
		}
	}
	public function deleteRelease($pi_release)
	{
		global $db;
		//delete from all table
		//remove files and translations
		$sql = "DELETE ".TABLE_TRANSLATOR_FILES." AS f, ".TABLE_TRANSLATOR_TRANSLATIONS." AS t FROM t JOIN f
					WHERE t.file = f.id
				";
		$db->Execute($sql);
		$sql = "DELETE FROM ".TABLE_TRANSLATOR_MODULES."
				WHERE release_id = '".$db->prepare_input($pi_release)."'
				";
		$db->Execute($sql);
		$sql = "DELETE FROM ".TABLE_TRANSLATOR_RELEASES."
				WHERE id = '".$db->prepare_input($pi_release)."'
				";
		$db->Execute($sql);
		//delete from storage dir
		if(is_dir(STORAGE_DIR.$pi_release))
			$this->delete_directory(STORAGE_DIR.$pi_release);
	}
	public function deleteLangFile($pi_id)
	{
		global $db;
		//first select file path
		$sql = "SELECT release_id,file,path FROM ".TABLE_TRANSLATOR_FILES."
				WHERE id = '".$db->prepare_input($pi_id)."'
				";
		$file = $db->Execute($sql);
		if(is_file(STORAGE_DIR.$file->fields['release_id'].'/'.$file->fields['path'].$file->fields['file']))
			unlink(STORAGE_DIR.$file->fields['release_id'].'/'.$file->fields['path'].$file->fields['file']);
		//delete translations from database
		$sql = "DELETE
				FROM ".TABLE_TRANSLATOR_TRANSLATIONS."
				WHERE file = '".$db->prepare_input($pi_id)."'";
		$db->Execute($sql);
		//delete files
		$sql = "DELETE FROM ".TABLE_TRANSLATOR_FILES."
				WHERE id = '".$db->prepare_input($pi_id)."'";
		$db->Execute($sql);
	}
	public function deleteLangModule($pi_id)
	{
		global $db;
		//first select module path
		$sql = "SELECT release_id,title,path FROM ".TABLE_TRANSLATOR_MODULES."
				WHERE id = '".$db->prepare_input($pi_id)."'
				";
		$module = $db->Execute($sql);
		if(is_dir(STORAGE_DIR.$module->fields['release_id'].'/'.$module->fields['path'].$module->fields['title']))
			$this->delete_directory(STORAGE_DIR.$module->fields['release_id'].'/'.$module->fields['path'].$module->fields['title']);

		$sql = "DELETE t.*
				FROM ".TABLE_TRANSLATOR_TRANSLATIONS." t
				JOIN ".TABLE_TRANSLATOR_FILES." f
				ON t.file = f.id AND f.module = '".$db->prepare_input($pi_id)."'
				";
		$db->Execute($sql);

		//delete files
		$sql = "DELETE FROM ".TABLE_TRANSLATOR_FILES."
				WHERE module = '".$db->prepare_input($pi_id)."'";
		$db->Execute($sql);
		//delete module
		$sql = "DELETE FROM ".TABLE_TRANSLATOR_MODULES."
				WHERE id = '".$db->prepare_input($pi_id)."'";
		$db->Execute($sql);
	}
	public function getModuleNameForFile($pi_fileid)
	{
		global $db;
		$sql = "SELECT title
				FROM ".TABLE_TRANSLATOR_FILES." f
				JOIN ".TABLE_TRANSLATOR_MODULES." m
					ON m.id = f.module
						AND f.id = '".$db->prepare_input($pi_fileid)."'
				";
		$title = $db->Execute($sql);
		return $title->fields['title'];
	}
}
?>
