<?PHP
require_once("./include/fg_membersite.php");

$fgmembersite = new FGMembersite();

//Provide your site name here
$fgmembersite->SetWebsiteName('doc.ic.ac.uk');

//Provide the email address where you want to get notifications
//$fgmembersite->SetAdminEmail('thomasccp.922@gmail.com');
$fgmembersite->SetAdminEmail('thomasccp@msn.com','e.hung12@imperial.ac.uk','w.luk@imperial.ac.uk','bpc@doc.ic.ac.uk');

//For better security. Get a random string from this link: http://tinyurl.com/randstr
// and put it here
$fgmembersite->SetRandomKey('ZGa2yErNo8ri1KL');

?>
