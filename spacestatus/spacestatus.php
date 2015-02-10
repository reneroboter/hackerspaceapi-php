<?php
  # this script gets called by cron every 5 minutes.
  # Das script ruft den spacestatus direkt vom Hackerspaceserver ab.
  # Wenn der aber nicht erreichbar ist kommt es zu einem timeout.
  # Trotzdem sollte die spaceapi aber von außen erreichbar sein.
  # Deshalb wird sozusagen das letzte Ergebnis dadurch gecached.
  #
  # vielleicht hinzufügen: http://hackerspace-bielefeld.de/feed/mp3

  $isopen = false;
  if(isset($_POST['status']))
  {
     $isopen = (strcmp($_POST['status'], 'open') == 0);
  }

  $apiversion = '0.13';
  
  $projects = array(
    'https://github.com/HackerspaceBielefeld',
    'http://repos.schadco.de/',
  );
  
#  switch(file_get_contents('./statusimg/status.txt')){
  
  $context = stream_context_create(array('http'=>
    array(
        'timeout' => 5, // 5 Seconds (nobody wants to wait longer)
    )
  )); 
  
  # switch(file_get_contents('http://wordpress.hackerspace-bielefeld.de/statusimg/status.txt', false, $context)){
  #   case 'open': 
  #     $isopen = true; 
  #   break;
  #   case 'closed': 
  #     $isopen = false; 
  #   break;
  #   default: 
  #     $isopen = null;
  # }


  $s = array();
  
  $s['api']      = '0.13';
  $s['space']    = 'Hackerspace Bielefeld e.V.';
  $s['logo']     = 'http://hackerspace-bielefeld.de/spacestatus/hackerspace-bielefeld-logo.gif';
  $s['url']      = 'http://hackerspace-bielefeld.de';
  $s['location'] = array(
    'lat' => 52.038224,
    'lon' => 8.533056,
    'address' => 'Sudbrackstrasse 42, 33611 Bielefeld, Germany'
  );
  $s['contact'] = array(
    'phone' => '+49-52-1337-322-42',
    'jabber' => 'hsb@chat.jabber.space.bi',
    'ml' => 'public@hackerspace-bielefeld.de',
    'twitter' => '@HackerspaceBI',
    'email' => 'info@hackerspace-bielefeld.de',
    'facebook' => 'https://www.facebook.com/HackerspaceBielefeld',
    'issue_mail' => 'admin@hackerspace-bielefeld.de'
  );
  $s['state'] = array("icon" => array('open' => 'http://hackerspace-bielefeld.de/spacestatus/hackerspace-bielefeld-open.gif', 'closed' => 'http://hackerspace-bielefeld.de/spacestatus/hackerspace-bielefeld-closed.gif'), 'open' => $isopen, lastchange => time(), message => "", trigger_person => "infobot");
  $s['icon'] = array('open' => 'http://hackerspace-bielefeld.de/spacestatus/hackerspace-bielefeld-open.gif', 'closed' => 'http://hackerspace-bielefeld.de/spacestatus/hackerspace-bielefeld-closed.gif'); # V0.12
  $s['open'] = $isopen; # V 0.12
  $s['projects'] = $projects;
  $s['issue_report_channels'] = array('email');


  header('Cache-Control: no-cache');
  header('Content-type: application/json');
  header('Access-Control-Allow-Origin: *');
  
  echo json_encode($s, JSON_PRETTY_PRINT + JSON_UNESCAPED_SLASHES);
  $myfile = fopen("status.json", "w") or die("Unable to open file!");
  fwrite($myfile, json_encode($s, JSON_PRETTY_PRINT + JSON_UNESCAPED_SLASHES));
  fclose($myfile);
?>
