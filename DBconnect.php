<?php
echo "<table style='border: solid 1px black;'>";
echo "<tr><th>Id</th><th>Name</th></tr>";

class TableRows extends RecursiveIteratorIterator {
   function __construct($it) {
       parent::__construct($it, self::LEAVES_ONLY);
   }

   function current() {
       return "<td style='width:150px;border:1px solid black;'>" . parent::current(). "</td>";
   }

   function beginChildren() {
       echo "<tr>";
   }

   function endChildren() {
       echo "</tr>" . "\n";
   }
}

$servername = "141.219.196.115";
$username = "tschaftware";
$password = "Dolphinsockpotatoadventure";
$dbname = "schaftchat";

try {
   $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
   $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   $stmt = $conn->prepare("SELECT uid, name FROM user");
   $stmt->execute();

   // set the resulting array to associative
   $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
   foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) {
       echo $v;
   }
   echo "\r\n";
   echo "<table style='border: solid 1px black;'>";
   echo "<tr><th>Sent From</th><th>Sent To</th><th>Image Location</th><th>Message Text</th><th>Time Sent</th></tr>";

   $stmt = $conn->prepare("SELECT sender, receiver, imgpath, message, timestamp FROM images");
   $stmt->execute();

   // set the resulting array to associative
   $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
   foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) {
       echo $v;
   }
}
catch(PDOException $e) {
   echo "Error: " . $e->getMessage();
}
$conn = null;
echo "</table>";
?>
