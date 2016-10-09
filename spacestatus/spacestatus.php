<?php
header('Cache-Control: no-cache');
header('Content-type: application/json');
header('Access-Control-Allow-Origin: *');

$isOpen = true;
if (isset($_POST['status'])) {
  $isOpen = (strcmp($_POST['status'], 'open') == 0);
}

$projects = [
    'https://github.com/HackerspaceBielefeld',
    'http://repos.schadco.de/',
];

$string = [
    'api' => '0.13',
    'space' => 'Hackerspace Bielefeld e.V.',
    'logo' => 'http://hackerspace-bielefeld.de/spacestatus/hackerspace-bielefeld-logo.gif',
    'url' => 'http://hackerspace-bielefeld.de',
    'location' => [
        'lat' => 52.038224,
        'lon' => 8.533056,
        'address' => 'Sudbrackstrasse 42, 33611 Bielefeld, Germany'
    ],
    'contact' => [
        'phone' => '+49-52-1337-322-42',
        'jabber' => 'hsb@chat.jabber.space.bi',
        'ml' => 'public@hackerspace-bielefeld.de',
        'twitter' => '@HackerspaceBI',
        'email' => 'info@hackerspace-bielefeld.de',
        'facebook' => 'https://www.facebook.com/HackerspaceBielefeld',
        'issue_mail' => 'admin@hackerspace-bielefeld.de'
    ],
    'state' => [
        "icon" =>
            [
                'open' => 'http://hackerspace-bielefeld.de/spacestatus/hackerspace-bielefeld-open.gif',
                'closed' => 'http://hackerspace-bielefeld.de/spacestatus/hackerspace-bielefeld-closed.gif'],
        'open' => $isOpen,
        'lastchange' => time(),
        'message' => "",
        'trigger_person' => "infobot"
    ],
    'icon' => [
        'open' => 'http://hackerspace-bielefeld.de/spacestatus/hackerspace-bielefeld-open.gif',
        'closed' => 'http://hackerspace-bielefeld.de/spacestatus/hackerspace-bielefeld-closed.gif'],
    'open' => $isOpen,
    'projects' => $projects,
    'issue_report_channels' => [
        'email'
    ],
];

$jsonOutput = json_encode($string, JSON_PRETTY_PRINT + JSON_UNESCAPED_SLASHES);

file_put_contents("status.json", $jsonOutput);

return $jsonOutput;