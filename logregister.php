<?php

    session_start();
    $source = $_SESSION["source"];
    $destination = $_SESSION["destination"];
    $association = $_SESSION["association"];
    $id = $_SESSION["id"];

    # Extracting sent URL and Title values
    $url = $_REQUEST['url'];
    $title = $_REQUEST['title'];
    echo "URL is : ".$url." Title is : ".$title;

    $conn = mysql_connect("localhost","root","") or die(mysql_error());

    mysql_select_db("TrackIt");

    # Inserting the Start Time 
    if (strcmp($title,$source)==0)
    {
       $st = mysql_query("SELECT StartTime from TaskInfo where ID='$id'");
       $row = mysql_fetch_row($st);
       $startTime = $row[0];

       if ($startTime == NULL)
       {
         $t = time();
         $sql = "UPDATE TaskInfo SET StartTime = '$t' WHERE ID = '$id'";  
         if (mysql_query($sql))
            echo "Time inserted";
         else
            echo "Time not possible";
       }  
    }

    #  Inserting the Finish Time
    if (strcmp($title,$destination)==0)
    {
       $ft = mysql_query("SELECT FinishTime from TaskInfo where ID='$id'");
       $row = mysql_fetch_row($ft);
       $finishTime = $row[0];
       
       if ($finishTime == NULL)
       {
         $t = time();
         $sql = "UPDATE TaskInfo SET FinishTime = '$t' WHERE ID = '$id'";  
         if (mysql_query($sql))
            echo "Finish Time inserted";
         else
            echo "Time not possible";
       }

       session_destroy();

       # Finding the total time
       $st = mysql_query("SELECT StartTime from TaskInfo where ID='$id'");
       $row = mysql_fetch_row($st);
       $start_time = $row[0];

       $ft = mysql_query("SELECT FinishTime from TaskInfo where ID='$id'");
       $row = mysql_fetch_row($ft);
       $finish_time = $row[0];

       echo $start_time.'\n';
       echo $finish_time.'\n';

       $time_taken = $finish_time - $start_time;
       echo $time_taken;
       $sql = "UPDATE TaskInfo SET TimeTaken = '$time_taken' WHERE ID = '$id'";  
       
       if (mysql_query($sql))
            echo "Finish Time inserted";
         else
            echo "Time not possible";
          
      $avg = "SELECT AVG(TimeTaken) FROM TaskInfo GROUP BY Association GROUP BY Source GROUP BY Destination";
      $arow = mysql_fetch_row($avg);
      $timet = $arow[0];
    }
    
    # To not log null and localhost/phpmyadmin URL

    $id = "user".$id;
    if ((strcmp($url,"null")==0) || (strcmp($url,"http://localhost/phpmyadmin/sql.php?server=1")==0))
    {
        echo " URL wont be logged";
    }
    else
    {
       $sql = "INSERT INTO $association (UserID,UrlTitle) VALUES ('$id','$title')";
       if ( mysql_query($sql))
       {
           echo " Table insertion successful";
       }
       else
        echo " Error creating Table"."</br>". mysql_error($conn);
    }
    mysql_close($conn);

?>