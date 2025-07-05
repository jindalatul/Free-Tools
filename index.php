<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body {
  margin: 0;
  font-family: Arial, Helvetica, sans-serif;
}

.topnav {
  overflow: hidden;
  background-color: #333;
}

.topnav a {
  float: left;
  color: #f2f2f2;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
  font-size: 17px;
}

.topnav a:hover {
  background-color: #ddd;
  color: black;
}

.topnav a.active {
  background-color: #04AA6D;
  color: white;
}
</style>
</head>
<body>
<?php 
  ini_set("display_errors",'Off');
   $page=$_REQUEST["page"]; 
?>
<div class="topnav">
  <a <?php if($page=="email-roi") echo ' class="active"'; ?> href="?page=email-roi">Email ROI Calculator</a>
  <a <?php if($page=="guest-post-roi") echo ' class="active"'; ?> href="?page=guest-post-roi">Guest Posting ROI Calculator</a>
  <a <?php if($page=="podcast-roi") echo ' class="active"'; ?>  href="?page=podcast-roi">Podcast ROI Calculator</a>
  <a <?php if($page=="story-reach-estimates") echo ' class="active"'; ?> href="?page=story-reach-estimates">Estimate Social Media Story Reach</a>
</div>

<div style="padding-left:16px">
  
<?php
  if($page=="email-roi")
    {
        require_once("email-roi.php");
        die();
    }
    elseif($page=="guest-post-roi")
    {
        require_once("guest-post-roi.php");
        die();
    }
    elseif($page=="podcast-roi")
    {
        require_once("podcast-roi.php");
        die();
    }
    elseif($page=="story-reach-estimates")
    {
        require_once("story-reach-estimates.php");
        die();
    }
    else
    {
        echo"<h2>Checkout our Free Tools</h2>";
    }
  ?>
</div>

</body>
</html>
