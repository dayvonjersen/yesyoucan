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
function meme($lol) {
    sleep(1); file_put_contents('php://stderr', $lol);
}
meme("JUST DO IT\n");
echo "<style>",str_replace("\n"," ",preg_replace("/\s+/"," ",file_get_contents('markdown.css'))),"</style>\n",
    "# Everything Which is Possible in Alphabetical Order\n\n",
    "###### Information courtesy [github.com/Fyrd/caniuse](https://github.com/Fyrd/caniuse)\n\n",
    "## More detailed information available at [caniuse.com](http://caniuse.com)\n\n",
    "###### Icons courtesy [github.com/alrra/browser-logos](https://github.com/alrra/browser-logos)\n\n",
    "###### Markdown stylesheet courtesy [github.com/jasonm23/markdown-css-themes](http://jasonm23.github.io/markdown-css-themes)\n\n",
    "###### Markdown courtesy [daringfireball.net](http://daringfireball.net/projects/markdown/)\n\n",
    "---\n\n";

$d = dir('caniuse/features-json');
$why_is_there_no_sortdir = [];
chdir('caniuse/features-json');
meme("JUST DO IT\n");
while(($f = $d->read()) !== false) {
    if(is_dir($f)) {
        continue;
    }
    $memes = json_decode(file_get_contents($f));
    $why_is_there_no_sortdir[$memes->title] = $memes;
}
meme("DON'T LET YOUR DREAMS BE DREAMS\n");
uksort($why_is_there_no_sortdir, function($a,$b){
    return strcmp(strtolower(substr($a,0,1)),strtolower(substr($b,0,1)));
});
$browsers = ['firefox','chrome','opera','safari','ie','edge'];
$logo = [];
meme("YESTERDAY YOU SAID TOMORROW\n");
echo '<style>.',join(',.',$browsers),'{display:inline-block;height:16px;width:16px}';
foreach($browsers as $browser)
    echo ".$browser{background-image:url(data:image/png;base64,",base64_encode(file_get_contents("../../logos/$browser.png")),")}";
echo '</style>',"\n";
meme("SO JUST-\n"); sleep(1);
$dramatic_pause = floor(count($why_is_there_no_sortdir)/5); $i = 0;
$shia = ['DO IT', 'MAKE YOUR DREAMS COME TRUE', 'JUST-DO IT', 'YES YOU CAN', 'JUST DO IT'];
foreach($why_is_there_no_sortdir as $seriously => $wtf) {
    if(is_null($wtf))
        continue;
    echo $wtf->title,"\n===\n\n",
        ">",$wtf->description, "\n\n";
    $supported = false;
    if( isset($wtf->stats) && (is_object($wtf->stats) || is_array($wtf->stats)) ) {
        foreach($wtf->stats as $browser => $versions) {
            if( !(is_array($versions) || is_object($versions)) || !in_array($browser,$browsers) )
                continue;
            foreach($versions as $version => $supported) {
                if(strstr($supported,"y") || strstr($supported,"a")) {
                    $supported = true;
                    echo "<div aria-label='$browser' class='$browser'></div> $version ";
                    break;
                }
            }
        }
    }
    if( ++$i >= $dramatic_pause ) { meme(array_shift($shia)."\n"); $i=0; }
    echo !$supported ? "*No browser support*" : '',"\n\n",
        " - [",$wtf->spec,"](",$wtf->spec,")\n\n";
    if(is_array($wtf->links) || is_object($wtf->links)){
        foreach($wtf->links as $ayy)
            echo " - [",$ayy->title,"](",$ayy->url,")\n\n";
    }
    echo "\n---\n";
}
meme("If you are tired of starting over, stop giving up.\n");
