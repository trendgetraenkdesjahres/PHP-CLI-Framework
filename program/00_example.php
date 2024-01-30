<?php
foreach(file(CLI_FRAMEWORK_DIR . "/README.md") as $line ) {
    $line = trim($line);
    if (str_starts_with($line, "#")) {
            echo_s(trim($line, "#"),'box');
            continue;
        }
    echo_s($line);
}
