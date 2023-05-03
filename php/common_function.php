<?php
function h($str)
{
    return htmlspecialchars($str);
}

function writeErrorLog($file, $fnc, $line, $msg)
{
    $logMsg = sprintf('[%s]', date('Y-m-d H:i:s'));
    $logMsg .= sprintf('[%-24s]', $file);
    $logMsg .= sprintf('[%s]', $fnc);
    $logMsg .= sprintf('[%d]', $line);
    $logMsg .= ' '. $msg. "\n";

    $logFileNm = date('Ymd'). '_'. 'eba_study_club.log';
    $logFilePath = '../log/'. $logFileNm;
    if (!file_exists($logFilePath)){
        touch($logFilePath);
    }

    error_log($logMsg, 3, $logFilePath);
}