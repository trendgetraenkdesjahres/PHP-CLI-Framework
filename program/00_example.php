<?php
echo_s('example','box');

display(CLI_FRAMEWORK_DIR . '/image.png');

function progress_bar_example(){
    $progress_iterations = 100;
    init_progress($progress_iterations,__FUNCTION__);
    for($i = 0; $i < $progress_iterations; $i++)
    {
        $wait = rand(0,10)/10;
        sleep($wait);
        update_progress();
    }
}

progress_bar_example();
