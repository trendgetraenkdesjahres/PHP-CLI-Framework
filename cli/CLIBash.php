<?php

class CLIBashCommand
{
    public string $command;
    public array $full_output;
    public bool $echo;

    /**
     * [__construct description]
     *
     * @param   string  $command  the bash command
     * @param   bool    $echo     set to true if you want to see something
     *
     */
    public function __construct(string $command, bool $echo = false)
    {
        $this->command = $command;
        $this->full_output = array();
        $this->echo = $echo;
    }

    public function run(bool $return = true)
    {
        if($return)
        {
            return exec($this->command, $this->full_output);
        }
        exec($this->command, $this->full_output);
    }
}

function get_bash($command){
    $return = new CLIBashCommand($command);
    return $return->run();
}

function echo_bash($command, $style = 'basic'){
    $echo = "  >  ".$command."\n";
    $return = new CLIBashCommand($command);
    $echo .= "  >  ".$return->run()."\n";
    echo_s($echo, $style);
}
