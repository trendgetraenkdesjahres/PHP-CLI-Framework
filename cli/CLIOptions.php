<?php

class CLIOptions
{

    public array $options;

    private string $short_options_keys;
    private array $long_options_keys;



    public function __construct(array $option_keys)
    {
        $this->short_options_keys = '';
        $this->long_options_keys = array();
        $this->set_option_keys($option_keys);
        $this->get_options();
    }

    /**
     * puts cli options into $this->options array
     *
     * @return  void
     */
    private function get_options()
    {
        $this->options = getopt($this->short_options_keys, $this->long_options_keys);
    }

    /**
     * sets valid arguments for the command line options
     *
     * @param   array  $option_keys  array of valid keys. can be single chars or strings.
     *
     * @return  void
     */
    private function set_option_keys(array $option_keys)
    {
        foreach($option_keys as $option_key => $value)
        {
            // invalide keys are invalid
            if(strlen($option_key) === 0 || !is_string($option_key))
            {
                return;
            }

            // short options
            if(strlen($option_key) === 1 )
            {
                $this->short_options_keys .= $option_key;
                if($value == 'required')
                {
                    $this->short_options_keys .= ':';
                }

                if($value == 'optional')
                {
                    $this->short_options_keys .= '::';
                }

            }

            // long options
            if(strlen($option_key) > 1 )
            {
                if($value == 'required')
                {
                    $option_key .= ':';
                }

                if($value == 'optional')
                {
                    $option_key .= '::';
                }

                array_push($this->long_options_keys, $option_key);
            }
        }
    }

    /**
     * return the value of the key or tells you if it is.
     *
     * @param   string  $key  they key of the option
     *
     * @return  mixed        value of key, or bool if key is set without value
     */
    public function get_option(string $key)
    {
        if(is_string($this->options[$key]))
        {
            return $this->options[$key];
        }
        return key_exists($key, $this->options);
    }
}

init_cli_options();

function init_cli_options(){
    global $cli;
    global $config;
    if(isset($config['cli_flags'])) {
        $cli['options'] = new CLIOptions($config['cli_flags']);
    }
}

function get_option(string $key)
{
    global $cli;
    return $cli['options']->get_option($key);
}
