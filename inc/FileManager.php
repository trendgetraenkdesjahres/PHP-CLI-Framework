<?php

class FileManager
{
    private array $file_images;

    public function __construct()
    {
        $this->file_images = array();
    }

    public function add_file_image(FileImage $file_image)
    {
        array_push($this->file_images, $file_image);
    }

    private function burn_image(FileImage $file_image)
    {
        global $config;

        $path = $config['plugin']['location'].'/';
        $path .= $config['plugin']['prefix'].'_'.get_answer('plugin_acronym').'-Plugin/';

        // create new plugin_root
        if(is_dir($path) === false )
        {
            echo_s('create directory "'.$path.'"', 'no_eol');
            $mkdir_success = mkdir($path, 0777, true);
            $mkdir_success = $mkdir_success == true ? 'success' : 'nope';
            echo_s($mkdir_success);
        }

        $path .= $file_image->path == '' ? '' : $file_image->path.'/';
        if(is_dir($path) === false )
        {
            echo_s('create directory '.$path, 'no_eol');
            $mkdir_success = mkdir($path, 0777, true);
            $mkdir_success = $mkdir_success == true ? 'success' : 'nope';
            echo_s($mkdir_success);
        }

        echo_s('create file '.$file_image->filename,'no_eol');

        $file = fopen($path.$file_image->filename,'w');
        fwrite($file,$file_image->content);
        fclose($file);
        echo_s('success','basic');
    }

    protected function create_single(string $file_name)
    {
        if($file_name == '')
        {
            return false;
        }

        foreach($this->file_images as $file_image)
        {
            if($file_image->full_filename == $file_name)
            {
                $this->burn_image($file_image);
                return true;
            }
        }

        return false;
    }

    protected function create_any()
    {
        foreach($this->file_images as $file_image)
        {
            $this->burn_image($file_image);
        }
    }

    public function create(string $file_name = '')
    {
        if($file_name != '')
        {
            $this->create_single($file_name);
            return;
        }
        $this->create_any();
    }
}

/**
 * [create_files description]
 *
 * @param   string  $file_name  reference to a file already created, by filename (with path). leave empty if you want to create every file.
 *
 * @return  void 
 */

function create_files(string $file_name = '')
{
    global $file_manager;
    $file_manager->create($file_name);
}