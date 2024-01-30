<?php
foreach(file("README.md") as $line ) {
    $line = trim($line);
    if (str_starts_with($line, "#")) {
            echo_s(trim($line, "#"),'box');
            continue;
        }
    echo_s($line);
}
