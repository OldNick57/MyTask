
<div class="main">
       <!-- Profile -->
        <section class="signup">
            <div class="container">
                <div class="signup-content">
                    <div class="signup-form">
                        <h2 class="form-title">Profile</h2>
                                                    <div class="form-group">
                           <h4>Hello,&nbsp; <?php echo $_SESSION['username'] ?><h4><br />
                           <?php
error_reporting(E_ERROR | E_PARSE | E_NOTICE);

                           if($_SESSION['username'] == 'admin') {

print('Explore:&nbsp;&nbsp;<a href="members">Members</a>&nbsp;&nbsp;&nbsp;<a href="sessions">Sessions</a>&nbsp;&nbsp;&nbsp;<a href="failed">Failed</a>');
echo "<h4>Failed logons</h4>\n";

    include_once('../model/Baza.php');
    $db = new Baza;
    $arr = $db->fail();

  print "<TABLE class='allorders'>\n";
  print "<TR>\n";
  print "<TH>Time</TH><TH>IP address</TH>\n";
  print "</TR>\n";

   	foreach($arr as $failed) {
	print "<TR class='zebra'>\n";
	print "<TD>". $failed['created'] ."</TD>\n";
	print "<TD>". $failed['ip'] ."</TD>\n";
    print "</TR>\n";
  	}

  print "</TABLE>\n";

 }

?>
                            </div>
                            <div class="form-group">
                        <a href="logout" class="signup-image-link">Logout</a>
                    </div>
                </div>
            </div>
        </section>

    </div>
