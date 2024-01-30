<?php

// get config
$config = parse_ini_file('config.ini', true, INI_SCANNER_TYPED);

// learn about constant filter.
require CLI_FRAMEWORK_DIR . '/inc/filters.php';

// learn how to receive options from cli and get them
require CLI_FRAMEWORK_DIR . '/cli/CLIOptions.php';

// learn how to print cool
require CLI_FRAMEWORK_DIR . '/cli/CLIStyles.php';

// learn how to ask things.
require CLI_FRAMEWORK_DIR . '/cli/CLIQuestions.php';

// learn to run Commands.
require CLI_FRAMEWORK_DIR . '/cli/CLIBash.php';

// learn about Files.
require CLI_FRAMEWORK_DIR . '/inc/FileImage.php';
require CLI_FRAMEWORK_DIR . '/inc/FileManager.php';

// learn about displaying Images.
require CLI_FRAMEWORK_DIR . '/cli/CLIDisplay.php';

// learn about displaying Progress.
require CLI_FRAMEWORK_DIR . '/cli/CLIProgress.php';
/*
* ------------------------------------------------------ *
*/

// go and try
require CLI_FRAMEWORK_DIR . '/cli/CLIProgram.php';
