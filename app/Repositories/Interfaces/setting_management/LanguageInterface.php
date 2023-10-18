<?php 
namespace App\Repositories\Interfaces\setting_management;

interface LanguageInterface{
	
	public function save($request, $id = "");

	public function data($request, $id = "*", $field_name = "");

    public function delete($id);
    public function set_language($language);
    public function check_word_exists($language,$file,$word);
    public function translate_content($DB,$request);
    public function get_content_file_lang($words,$language='en',$with_translate=false);
}