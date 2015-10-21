<?php
if(!defined('STDIN'))
    die('run from command line');
if(!file_exists('caniuse/features-json')) {
    file_put_contents('php://stderr', "git submodule init && git submodule update\n");
    exit(1);
}
if(isset($argv[1]) && $argv[1] == '--test') {
    echo "php -f dontletyourdreamsbedreams.php | ./Markdown.pl > yesterdayyousaidtomorrow.html\n";
    exit(0);
}

$d = dir('caniuse/features-json');
$why_is_there_no_sortdir = [];
chdir('caniuse/features-json');
while(($f = $d->read()) !== false) {
    if(is_dir($f)) {
        continue;
    }
    $memes = json_decode(file_get_contents($f));
    $why_is_there_no_sortdir[$memes->title] = $memes;
}
ksort($why_is_there_no_sortdir);
foreach($why_is_there_no_sortdir as $seriously => $wtf) {
    echo $wtf->title,"\n===\n\n",
        $wtf->description, "\n\n",
        "[",$wtf->spec,"](",$wtf->spec,")\n\n";
    foreach($wtf->links as $ayy)
        echo "[",$ayy->title,"](",$ayy->url,")\n";
    echo "\n";
}
