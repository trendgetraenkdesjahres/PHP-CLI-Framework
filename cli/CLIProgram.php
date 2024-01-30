<?php

class CLIProgram
{
    private array $programm_items;

    public function __construct()
    {
        $current_dir = getcwd();
        if (!file_exists("program")) {
            $this->programm_items = glob(CLI_FRAMEWORK_DIR . '/program/*.php');
            trigger_error("'$current_dir/program' folder not found.", E_USER_WARNING);
        }
        $this->programm_items = glob('program/*.php');
    }

    public function start()
    {

        foreach ($this->programm_items as $program_item) {
            include $program_item;
        }
    }
}

init_cli_program();

function init_cli_program()
{
    global $cli;
    $cli['program'] = new CLIProgram;
}

function start_program()
{
    global $cli;
    $cli['program']->start();
}
