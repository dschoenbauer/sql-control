<?php

use Ctimt\SqlControl\Enum\OutputMessages;
use Ctimt\SqlControl\Enum\OutputTypes;

return [
    OutputTypes::DEFAULT_TYPE => [
        OutputMessages::HEADER => "<!doctype html>
<html lang='en'>
<head>
    <meta charset='utf-8'>
    <title>The HTML5 Herald</title>
    <link rel='stylesheet' href='css/styles.css?v=1.0'>
<link rel='stylesheet' href='//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css' integrity='sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u' crossorigin='anonymous'>
<link rel='stylesheet' href='//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css' integrity='sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp' crossorigin='anonymous'>
<script src='//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js' integrity='sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa' crossorigin='anonymous'></script>
</head>

<body>",
        OutputMessages::FOOTER => "</body></html>",
        OutputMessages::BR => "<br>",
        OutputMessages::DEBUG_SQL => "<div class='alert alert-info'><h3>Debug:</h3><pre class='well well-sm'>{sql}</pre></div>",
        OutputMessages::ERROR_SQL => "<div class='alert alert-danger' role='dialog'><h3>Error:</h3><span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span> <strong>{file}</strong>: {message}<pre class='well well-sm'>{sql}</pre></div>",
        OutputMessages::INFO_COMPLETE => "<div class='alert alert-info' role='dialog'>{file} - {status}</div>",
        OutputMessages::INFO => "<div class='alert alert-info' role='dialog'>{message}</div>",
        OutputMessages::STATUS_COMPLETE => "<div class='alert alert-success' role='dialog'><h3>{status}:</h3>{file}</div>",
        OutputMessages::STATUS_ERROR => "<div class='alert alert-danger' role='dialog'><h3>{status}:</h3>{file}</div>",
        OutputMessages::STATUS_SKIPPED => "<div class='alert alert-warn' role='dialog'><h3>{status}:</h3>{file}</div>",
    ],
    OutputTypes::CLI => [
        OutputMessages::HEADER => "",
        OutputMessages::FOOTER => "",
        OutputMessages::BR => "\n",
        OutputMessages::INFO => "",
        OutputMessages::DEBUG_SQL => "{sql}",
        OutputMessages::ERROR_SQL => "{message}\n\n{sql}",
        OutputMessages::INFO_COMPLETE => "{file}\t-\t{status}",
    ]
];
