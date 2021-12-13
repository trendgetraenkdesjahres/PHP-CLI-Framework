<?php

class CLIQuestions
{ 
    public array $questions;

    /**
     * quesioioiotnaeiire
     */
    public function __construct()
    {
        $this->questions = array();
    }

    /**
     * ask somebody something
     *
     * @param   string  $question  your questions
     * @param   string  $key       how to remember that?
     * @param   string  $style     the LOOK
     *
     * @return  [type]             [return description]
     */
    public function ask(string $question, string $key = 'oblivion', string $style = 'basic')
    {
        echo "\n";
        echo_s($question, $style);
        
        // if array key is already set, it has to get moved to the end of the array
        if(isset($this->questions[$key]))
        {
            unset($this->questions[$key]);
        }

        $this->questions[$key]['q'] = $question;
        $this->questions[$key]['a'] = readline('> ');

        return $this->questions[$key]['a'];
    }

    public function get_question(string $key)
    {
        return $this->questions[$key]['q'];
    }

    public function get_answer(string $key)
    {
        return $this->questions[$key]['a'];
    }

    public function get_last_answer()
    {
        return end($this->questions)['a'];
    }

    public function set_answer($answer, string $key)
    {
        $this->questions[$key]['a'] = $answer;
    }
}

init_cli_questions();

function init_cli_questions(){
    global $cli;
    $cli['questions'] = new CLIQuestions;
}

function ask(string $question, string $key = 'oblivion', string $style = 'basic')
{
    global $cli;
    $cli['questions']->ask($question, $key, $style);
}

function get_answer(string $key)
{
    global $cli;
    return $cli['questions']->get_answer($key);
}

function get_last_answer()
{
    global $cli;
    return $cli['questions']->get_last_answer();
}

function set_answer($answer, string $key)
{
    global $cli;
    $cli['questions']->set_answer($answer, $key);
}

function get_question(string $key)
{
    global $cli;
    return $cli['questions']->get_question($key);
}
