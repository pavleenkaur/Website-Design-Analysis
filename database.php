<?php
    $conn = mysql_connect("localhost","root","") or die(mysql_error());
    $sql = "CREATE DATABASE IF NOT EXISTS TrackIt";
    if(mysql_query($sql , $conn)){
        echo "Success" ."</br>";
    }
    else{
        echo "Error" ."</br>". mysql_error($conn);
    }

    mysql_select_db("TrackIt" , $conn);

    # Main table
    $sql1 = "CREATE TABLE IF NOT EXISTS TaskInfo( 
        ID int NOT NULL AUTO_INCREMENT Primary Key,
        Association varchar(20) NOT NULL, 
        Source varchar(40) NOT NULL,
        Destination varchar(40) NOT NULL,
        StartTime bigint,
        FinishTime bigint,
        TimeTaken bigint )";

    if ( mysql_query($sql1,$conn))
        echo "Main Table created Succesfully" ."</br>";
    else
        echo "Error creating main table"."</br>". mysql_error($conn);

    # Association vise tables
    $sql2 = "CREATE TABLE IF NOT EXISTS StudentAssoc( UserID varchar(10) NOT NULL, UrlTitle varchar(200) NOT NULL)";

    if ( mysql_query($sql2,$conn))
        echo "Student Table created Succesfully"."</br>";
    else
        echo "Error creating student table"."</br>". mysql_error($conn);


    $sql3 = "CREATE TABLE IF NOT EXISTS FacultyAssoc(UserID varchar(10) NOT NULL, UrlTitle varchar(200) NOT NULL)";

    if ( mysql_query($sql3,$conn))
        echo "Faculty Table created Succesfully"."</br>";
    else
        echo "Error creating faculty table"."</br>". mysql_error($conn);

    $sql4 = "CREATE TABLE IF NOT EXISTS ParentAssoc(UserID varchar(10) NOT NULL, UrlTitle varchar(200) NOT NULL)";

    if ( mysql_query($sql4,$conn))
        echo "Parent Table created Succesfully"."</br>";
    else
        echo "Error creating Parent table"."</br>". mysql_error($conn);


    $sql5 = "CREATE TABLE IF NOT EXISTS NotStudentAssoc(UserID varchar(10) NOT NULL, UrlTitle varchar(200) NOT NULL)";

    if ( mysql_query($sql5,$conn))
        echo "NonStudent Table created Succesfully"."</br>";
    else
        echo "Error creating NonStudent table"."</br>". mysql_error($conn);


    $sql6 = "CREATE TABLE IF NOT EXISTS OtherAssoc(UserID varchar(10) NOT NULL, UrlTitle varchar(200) NOT NULL)";

    if ( mysql_query($sql6,$conn))
        echo "Other Table created Succesfully"."</br>";
    else
        echo "Error creating random table"."</br>". mysql_error($conn);

    $sql7 = "CREATE TABLE IF NOT EXISTS Flag(
    Title varchar(30) NOT NULL,
    Value int NOT NULL)";

    if ( mysql_query($sql7,$conn))
        echo "Flag Table created Succesfully"."</br>";
    else
        echo "Error creating random table"."</br>". mysql_error($conn);

    $v = 1;
    $sql8 = "INSERT into Flag (Title,Value) values ('Value','$v')";
    if ( mysql_query($sql8,$conn))
        echo "Value inserted Succesfully"."</br>";
    else
        echo "Error creating random table"."</br>". mysql_error($conn);
    
    mysql_close($conn);
?>