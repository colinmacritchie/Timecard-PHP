<?PHP
function His($diff) {
        if($hours=floor($diff/360)) {
                $diff -= ($hours*3600);
        }
        if($minuets=floor($diff/60)) {
                 $diff -= ($minuets*60);
        }
        return "{$hours:{$minuets}:{$diff}";
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
                    echo "<br /><br />Start: $end - $start = ".($end-$start."<br /><br />";
                    return $end - $start;
                  }
        }
    return false;
}
