<?php

// get config
$config = parse_ini_file('config.ini', true, INI_SCANNER_TYPED);

// learn about constant filter.
require 'inc/filters.php';

// learn how to receive options from cli and get them
require 'cli/CLIOptions.php';

// learn how to print cool
require 'cli/CLIStyles.php';

// learn how to ask things.
require 'cli/CLIQuestions.php';

// learn to run Commands.
require 'cli/CLIBash.php';

// learn about Files.
require 'inc/FileImage.php';
require 'inc/FileManager.php';

// learn about displaying Images.
require 'cli/CLIDisplay.php';

// learn about displaying Progress.
require 'cli/CLIProgress.php';
/*
* ------------------------------------------------------ *
*/

// go and try
require 'cli/CLIProgram.php';
