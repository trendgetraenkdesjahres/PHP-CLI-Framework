# PHP CLI framework

framework to create command line tools

### how to use?
- add this repo as submodule to your project folder
- symlink `program/`, `config.ini` and `start.php` into your project folder
- add your code as .php-file into the "program" folder. the folder will be executed alphabetically.
- run start.php

### bash functions
to execute bash commands
- `get_bash(your_command)` -> returns last line of the commands response
- `echo_bash(your_command)` -> echoes last line of the commands response

### questions functions
to communicate via script execusion
- `ask(question, key _(optional)_, echo_style _(optional)_)` -> ask something and store it as 'key'
- `get_answer(key)` -> get answer of the question of the 'key'
- `get_last_answer()` -> get the last answer
- `set_answer(answer, key)` -> store answer as key (without asking)
- `get_question(key)` -> what do you have asked again?

### styles functions
- `get_s(text, style _(optional)_)` -> returns formatted text
- `echo_s(text, style _(optional)_)` -> echoes formatted text
styles:
- `basic` -> just plain
- `box` -> text inside a box
- `no_eol` -> no break line at the end of the line, good to simulate tables etc

### options functions
you can define execution flags (e.g. -v for verbose-mode) in the config.ini file in the `[cli_flags]`-section. if script gets executed with those, you can acces the option by
- `is(option_name)` -> returns true/false

## config
everything setup in the config.ini file is accessable through the `$config`-variable. > they key is the key

## structure

```
.
 |-config.ini       individual configurations --- create symlink to this file
 |-functions.php    if you don't know where to put stuff else
 |-start.php        execution file --- create symlink to this file
 |-cli/             folder for cli-specific code
 |-inc/             includes
 |-programm/        THE PLACE TO CODE YOUR SCRIPT (will be executed alphabetically)  --- create symlink to this folder
```
