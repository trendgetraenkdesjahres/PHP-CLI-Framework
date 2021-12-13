<?php

class FileImage
{
    public string $full_filename;
    public string $path;
    public string $suffix;
    public string $filename;
    public string $content;

    /**
     * __construct File
     *
     * @param   string  $full_filename  full file name, optional with suffix and path
     *
     */
    public function __construct(string $full_filename)
    {
        $this->full_filename = $full_filename;
        $this->path = $this->constructPath($full_filename);
        $this->filename = $this->constructFilename($full_filename);
        $this->suffix = $this->constructSuffix($full_filename);
        $this->constructFilename($full_filename);
        $this->content = '';
        $this->call_file_manager();
    }

    private function call_file_manager()
    {
        global $file_manager;
        if(!$file_manager)
        {
            $file_manager = new FileManager;
        }

        $file_manager->add_file_image($this);
    }

    private function constructPath($full_filename)
    {
        $splitted_name = explode('/',$full_filename);
        if($splitted_name == array($full_filename))
        {
            return '';
        }
        return str_replace('/'.$splitted_name[count($splitted_name)-1],'',$full_filename);
    }

    private function constructSuffix($full_filename)
    {
        $splitted_name = explode('.',$full_filename);
        //return empty string if $splitted_name is empty aka 'no suffix'.
        if($splitted_name == array($full_filename))
        {
            return '';
        }
        return $splitted_name[count($splitted_name)-1];
    }

    private function constructFilename($full_filename)
    {
        return str_replace($this->path == '' ? '' : $this->path.'/', '', $full_filename);
    }

    public function setContent(string $content)
    {
        $this->content = $content;
    }

    public function addContent(string $content)
    {
        $this->content .= "\n".$content;
    }
}