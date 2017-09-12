<?php 
 if( $_SERVER["REQUEST_METHOD"] == "POST" )
    {
        session_start();
        $conn = mysql_connect("localhost","root","") or die(mysql_error());

        $association = mysql_real_escape_string($_POST["association"]);
        $source = mysql_real_escape_string($_POST["source"]);
        $destination = mysql_real_escape_string($_POST["destination"]);

        mysql_select_db("TrackIt") or die("Cannot connect to Database");

        $id = mysql_query("SELECT Value from Flag where Title='Value'");
        $row = mysql_fetch_row($id);
        $id = $row[0];

        $_SESSION["source"] = $source;
        $_SESSION["destination"] = $destination;
        $_SESSION["association"] = $association;
        $_SESSION["id"] = $id; 

        mysql_query("INSERT INTO TaskInfo( ID, Association, Source, Destination) VALUES ('$id', '$association', '$source', '$destination')");
        mysql_query("UPDATE Flag SET Value=Value + 1 WHERE Title = 'Value'");  

    }     
?>