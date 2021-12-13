<?php

class CLIStyles{

    /**
     * general method to get formatted strings
     *
     * @param   string  $str    the text
     * @param   string  $style  the style
     *
     * @return  string formatted text
     */
    public function string_styled(string $str, string $style)
    {
        if(!method_exists('CLIStyles', 'string_in_'.$style))
        {
            return;
        }
        $to_eval = "return \$this->string_in_".$style."('".$str."');";
        return eval($to_eval);
    }

    protected function string_in_robot(string $str)
    {
        $output = "🤖 ".$str."\n"; 
        return $output;
    }

    protected function string_in_no_eol(string $str)
    {
        $column_width = 60;

        $output = "# ".$str; 
        $n_of_spaces = $column_width - strlen($output);
        for($i = $n_of_spaces ;  $i >= 0; $i-- )
        {
            $output .= ' '; 
        }
        return $output;
    }

    protected function string_in_basic(string $str)
    {
        $output = "  ".$str."\n"; 
        return $output;
    }

    protected function string_in_box(string $str)
    {
        $output = "";
        $str_in_array_by_lines = explode(PHP_EOL, $str);

        // find longest line
        $maxlen = 0;
        foreach($str_in_array_by_lines as $line)
        {
            if ($maxlen < strlen($line) )
            {
                $maxlen = strlen($line);
            }
        }
        

        // top
        $output .= '┌';
        for($i = 0; $i < $maxlen+2; $i++)
        {
            $output .= '─';
        }
        $output .= "┒\n";

        for($i = 0; $i < count($str_in_array_by_lines); $i++)
        {
            $output .= '│ ';
            $output .= $str_in_array_by_lines[$i];
            //fill out with spaces maybe
            if(strlen($str_in_array_by_lines[$i]) < $maxlen ){
                for($k = 0; $k < $maxlen-strlen($str_in_array_by_lines[$i]); $k++)
                {
                    $output .= ' ';
                }
            }
            $output .= " ┃\n";
        }

        $output .= '┕';
        for($i = 0; $i < $maxlen+2; $i++)
        {
            $output .= '━';
        }
        $output .= "┛\n";
        return $output;

    }

    
}

init_cli_styles();

function init_cli_styles(){
    global $cli;
    $cli['styles'] = new CLIStyles;
}

function echo_s($string, $style = 'basic')
{
    global $cli;
    echo $cli['styles']->string_styled($string, $style);
}

function get_s($string, $style = 'basic')
{
    global $cli;
    return $cli['styles']->string_styled($string, $style);
}
