<?php

class CLIProgram
{
    private array $programm_items;

    public function __construct()
    {
        $this->programm_items = array_diff( scandir('program'), array('..', '.') );
    }

    public function start()
    {
        foreach($this->programm_items as $program_item)
        {
            include 'program/'.$program_item;
        }
    }
}

init_cli_program();

function init_cli_program(){
    global $cli;
    $cli['program'] = new CLIProgram;
}

function start_program()
{
    global $cli;
    $cli['program']->start();
}
