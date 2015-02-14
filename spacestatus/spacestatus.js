var data_file = "http://www.hackerspace-bielefeld.de/spacestatus/status.json";
var http_request = new XMLHttpRequest();
try
{
	// Default implementation: http://www.w3.org/TR/XMLHttpRequest/  ...
	http_request = new XMLHttpRequest(); 
}
catch (e) // however: IE does not implement it right... ms try&error starts here
{
	try
	{ http_request = new ActiveXObject("Msxml2.XMLHTTP"); }
	catch (e) 
	{
		try
		{ http_request = new ActiveXObject("Microsoft.XMLHTTP"); }
		catch (e)
		{ /* nothing special: logo without status gets displayed */ }
	}
}
http_request.onreadystatechange  = function()
{
	if (http_request.readyState == 4  )
	{
		var jsonObj = JSON.parse(http_request.responseText);
		var elements = document.getElementsByName("SpaceAPI-Status");
		for(i=0; i<=elements.length-1; i++)
		{
			elements[i].src = "hackerspace-bielefeld-logo.gif";
			if( jsonObj.state.open == 1 )
			{ elements[i].src = jsonObj.state.icon.open; }
			else
			{ elements[i].src = jsonObj.state.icon.closed; }
		}
	}
}
http_request.open("GET", data_file, true);
http_request.send();
