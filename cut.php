<?php 

function getExtension($str) {

         $i = strrpos($str,".");
         if (!$i) { return ""; } 
         $l = strlen($str) - $i;
         $ext = substr($str,$i+1,$l);
         return $ext;
 }

 define ("MAX_SIZE","3000");

 $errors=0;
 
 if($_SERVER["REQUEST_METHOD"] == "POST")
 {
        $image =$_FILES["new_image"]["name"];
 $uploadedfile = $_FILES['new_image']['tmp_name'];

  if ($image) 
  {
  $filename = stripslashes($_FILES['new_image']['name']);
        $extension = getExtension($filename);
  $extension = strtolower($extension);
 if (($extension != "jpg") && ($extension != "jpeg") 
&& ($extension != "png") && ($extension != "gif")) 
  {
echo ' Unknown Image extension ';
$errors=1;
  }
 else
{
   $size=filesize($_FILES['new_image']['tmp_name']);
 
if ($size > MAX_SIZE*2024)
{
 echo "You have exceeded the size limit";
 $errors=1;
}
 
if($extension=="jpg" || $extension=="jpeg" )
{
$uploadedfile = $_FILES['new_image']['tmp_name'];
$src = imagecreatefromjpeg($uploadedfile);
}
else if($extension=="png")
{
$uploadedfile = $_FILES['new_image']['tmp_name'];
$src = imagecreatefrompng($uploadedfile);
}
else 
{
$src = imagecreatefromgif($uploadedfile);
}
 
list($width,$height)=getimagesize($uploadedfile);

$newwidth=960;
$newheight=550;
$tmp=imagecreatetruecolor($newwidth,$newheight);



imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,
 $width,$height);


$filename = "images/". $_FILES['new_image']['name'];
//$filename1 = "images/small". $_FILES['new_image']['name'];

imagejpeg($tmp,$filename,100);
//imagejpeg($tmp1,$filename1,100);

imagedestroy($src);
imagedestroy($tmp);
//imagedestroy($tmp1);
}
}
}
//If no errors registred, print the success message

 if(isset($_POST['Submit']) && !$errors) 
 {
   // mysql_query("update SQL statement ");
  echo "Image Uploaded Successfully!";

 }
 ?>