<?php

class CLIProgress
{
    public int $current;
    public int $max;
    public bool $percentage;
    public string $id;


    public function __construct(int $max, int $current = 0, bool $percentage = true)
    {
        get_bash('tput sc');
        $this->max = $max;
        $this->current = $current;
        $this->percentage = $percentage;
    }

    public function set_current(int $current, bool $display = true)
    {
        $this->current = $current;
        if($display)
        {
            $this->display();
        }
    }

    public function add_to_current(int $add_to_current = 1, bool $display = true)
    {
        $this->current += $add_to_current;
        if($display)
        {
            $this->display();
        }
    }

    public function display()
    {   
        $width = abs(get_bash('tput cols') * .7);
        $reset_lines = "\033[2A\r";

        $float = $this->current / $this->max;
        $progressbar = new CLIProgressBar;

        if($this->percentage)
        {
            $num_status = ($float*100).'%';
        }
        else
        {
            $num_status = $this->current.'/'.$this->max;
        }

        // upper line
        $upper_line = "\n";
        if (!preg_match('/^[0-9]+$/', $this->id)) {
            $upper_line .= $this->id;
          }

        $position = strlen($upper_line);
        for($position; $position < (intval($width - strlen($num_status) + 1) / 2); $position++)
        {
            $upper_line .= ' ';
        }
        $upper_line .= $num_status;

        for($position; $position <= $width; $position++)
        {
            $upper_line .= ' ';
        }
        
        $upper_line .= "\n";
        echo $reset_lines.$upper_line.$progressbar->get($float);
    }
}

class CLIProgressBar
{
    private string $before;
    private string $full;
    private string $indicator;
    private string $empty;
    private string $after;

    public function __construct(string $before = " │", string $full = '░', string $indicator = '█', string $empty = ' ', string $after = '│')
    {
        $this->indicator = $indicator;
        $this->before = $before;
        $this->full = $full;
        $this->empty = $empty;
        $this->after = $after;
    }

    public function get(float $current)
    {
        $width = abs(get_bash('tput cols') * .7);

        $indicator_len = strlen($this->indicator);

        $str = $this->before;
        $position = 0;

        for($position; $position <= (intval($width * $current) - $indicator_len ); $position++ )
        {
            $str .= $this->full;
        }
        $str .= $this->indicator;

        for($position; $position < $width - $indicator_len ; $position++ )
        {
            $str .= $this->empty;
        }
        $str .= $this->after;

        return $str;
    }
}

function init_progress(int $max, int|string $id = NULL)
{
    //create ID if there's no wish
    if($id === NULL)
    {
        for($i = 0; $i <= 5; $i++)
        {
            $id .= rand(0,9);
        }
    }
    
    echo "\n";

    //create progress entity
    global $cli;
    $cli['progress_'.$id] = new CLIProgress($max, 0);
    $cli['progress_'.$id]->id = $id;
    $cli['progress_'.$id]->display();
}

function update_progress(int $value = 1, string $id = 'latest',  bool $adding = true)
{
    global $cli;

    
    if($id = 'progress_latest')
    {
        $id  = get_latest_progress_id();
    }
    $id = 'progress_'.$id;
    
    if(!$adding)
    {
        $cli[$id]->set_current($value);
    }
    else
    {
        $cli[$id]->add_to_current($value);
    }

    $cli[$id]->display();
    return $cli[$id]->current;
}

function get_latest_progress_id()
{
    global $cli;
    $prefix = 'progress_';
    foreach($cli as $key => $progress_el)
    {
        if(is_int(strpos($key, $prefix)))
        {
            $id = $key;
        }
    }
    return substr($id,strlen($prefix),strlen($id));
}

function get_latest_progress()
{
    global $cli;
    return $cli['progress_'.get_latest_progress_id()];
}