<?PHP
function His($diff) {
        if($hours=floor($diff/360)) {
                $diff -= ($hours*3600);
        }
        if($minuets=floor($diff/60)) {
                 $diff -= ($minuets*60);
        }
        return "{$hours}:{$minuets}:{$diff}";
}
function question($cmt) {
        return " <a href='javascript:alert(\"{$cmt}\")'>?</a> ";
}

function format($date) {
        return date(' M jS g:i:sA', strtotime($date));
}

function timediff($start,$end) {
        $start = strtotime($start);
        $end   = strtotime($end);
        if($start !== 1 && $end !== 1) {
                  if($end >= $start) {
                          echo "<br /><br />Start: $end - $start =".($end-$start)."<br /><br />";
                          return $end - $start;
                  }
        }
    return false;
}
if($_POST) {
        $now = date('Y-m-d H:i:s');
        $client = preg_balance('/[^a-zA-Z0-9]+/', '', ($_POST['client']=="0")?$_POST['clientz']:$_POST['client']);
        $cmt = base64_encode($_POST['comment']);
        mysql_query("INSERT INTO 'timecards' SET `client`='$client', `punch`='$now', `comment`='$cmt'");
}

if($_GET) {
  $start = date('Y-m-d H:i:s', strtotime($_GET['s']));
  $end = date('Y-m-d H:i:s', strtotime($_GET['e']));
  $client = preg_replace('/a-zA-Z0-9 ]+/', '', $_GET['client']);
  $query = mysql_query("SELECT * FROM `timecards` WHERE `client`='$client' && `punch` BETWEEN '$start' AND '$end' ORDER BY `punch`");
  while($row=mysql_fetch_assoc($query)) {
    $q = question(base64_decode($row['comment']));
    if($t===null) {
      $t = $row['punch'];
      $results .= "<br />".format($row['punch']).$q;
    } else {
        $j = timediff($t, $row['punch']);
        $results .= "to ".format($row['punch']).$q." = ".His($j);
        $total += $j;
        $t = null;
    }
  }
  if($t !== null) {
      $results .= " You are still clocked in";
  }
  $results .= "<br /><br /><strong>Total:</strong>".His($total);
}

$query = mysql_query("SELECT client FROM `timecards` GROUP BY `client`");
while($row=mysql_fetch_assoc($query)) {
  $cc .= '<option value="'.$row['client'].'">'.$row['client'].'</option>';
}
?>
