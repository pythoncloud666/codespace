<?php
require 'core.inc.php';
require 'connect.inc.php';
if(!loggedin()) {header('Location:index.php');}
?>
 <html>
 <head>
   
     <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Practice Arena</title>



</head>
<body>
  
 <?php
include 'navbar.php'
 ?>

  <style type="text/css">
  table a{color:blue;}
  .page{width:90%;margin:auto;}
  .posrec{padding-left:50px;}
  table{width:100%;}
  .linksz{font-size:200px;}
  </style>

<div class=page>
    <?php
require 'connect.inc.php';


$query="SELECT questions.qid,questions.qname FROM questions
WHERE (qid) NOT IN
( SELECT qid
  FROM keptin
) ;
";
?>
<?php
$result=mysql_query($query);
$num=mysql_num_rows($result);

if($result&&$num) 
	{  echo "<div class=mdl-grid>";
		echo "<div class=\"mdl-cell mdl-cell--8-col mdl-grid mycard\">
      <div class=\"mdl-cell mdl-cell-4-col \">
              <i class=\"material-icons linksz\" >description</i>
      </div>
       <div class=\"mdl-cell mdl-cell--8-col\">
          <h4><strong>Practice</strong></h4>
          <p>Practice through different difficulty levels.</p>
       </div><br>

    
    <table class=\"mdl-data-table mdl-js-data-table mdl-shadow--2dp\">
			  <thead>
    			<tr>
      				<th class=\"mdl-data-table__cell--non-numeric\">Name</th>
      				<th class=\"mdl-data-table__cell--non-numeric\">Code</th>
      				<th class=\"mdl-data-table__cell--non-numeric\">Successful Submissions</th>
              <th class=\"mdl-data-table__cell--non-numeric\">Accuracy</th>
    				</tr>
  			  </thead>
  			  <tbody>";
		for($i=0;$i<$num;$i++)
		{	$qid=mysql_result($result,$i,'qid');
			$qname=mysql_result($result,$i,'qname');
      $query1="SELECT count(*) from submissions where result='AC' AND qid='".$qid."'";
      $result1=mysql_query($query1);
      $succnum=mysql_result($result1,0,'count(*)');
      $query2="SELECT count(*) from submissions where qid='".$qid."'";
      $result2=mysql_query($query2);
      $totalnum=mysql_result($result2,0,'count(*)');
      if($totalnum==0) $acc=0; 
      else $acc=$succnum*100/$totalnum;


      $query3="SELECT * from submissions where result='AC' AND user_id='$id' AND qid='$qid'";
      $usucnum=mysql_num_rows(mysql_query($query3));

      $query4="SELECT * from submissions where user_id='$id' AND qid='$qid'";
      $unum=mysql_num_rows(mysql_query($query4));

      $class="none";
      if($usucnum>0) $class="green title=Solved";
      else if($usucnum==0 && $unum>0) $class="red title=Unsolved";
      


			echo "<tr>";
			echo "<td class=\"mdl-data-table__cell--non-numeric \"><a class=$class href=\"problem.php?q=".$qid."\">".$qname."</a></td>";
      echo "<td class=\"mdl-data-table__cell--non-numeric\"><a href=\"submit.php?q=".$qid."\">".$qid."</a></td>";
      echo "<td class=\"mdl-data-table__cell--non-numeric\">$succnum</td>";
			echo "<td class=\"mdl-data-table__cell--non-numeric\">$acc</td>";
      
      echo "</tr>";
		}
	echo "</tbody>
		</table></div>";
	}
?>

  <div class="mycard mdl-cell mdl-cell-4-col">
<h4>Judge Environment</h4>

<i class=material-icons>done</i><br>AC (Accepted)<br><br>
<i class=material-icons>highlight_off</i><br>WA (Wrong Answer)<br><br>
<i class=material-icons>error_outline</i><br>RE (Runtime Error)<br><br>
<i class=material-icons>alarm</i><br>TLE (Time Limit Exceeded)<br><br>
<i class=material-icons>warning</i><br>CE (Compilation Error)<br><br>
 </div>
</div>


</div>
  
</body>
 </html>
