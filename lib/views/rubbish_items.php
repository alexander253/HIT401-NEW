<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  min-width: 100px;
  max-width: 100px;
  text-align: left;
  padding: 8px;
}


tr:nth-child(even) {
  background-color: white;
}


</style>


<table>
<tr style="background-color: orange;">
  <th style="color: white;">Commingled</th>
</tr>


<?php
 //Print the list of products
 if(!empty($list)){
   foreach($list As $product){
     $id = htmlspecialchars($product['id'],ENT_QUOTES, 'UTF-8');
     $type = htmlspecialchars($product['type'],ENT_QUOTES, 'UTF-8');
     $desc = htmlspecialchars($product['description'],ENT_QUOTES, 'UTF-8');

   if($type == "Commingled"){
     echo "

       <tr>
         <td>{$desc}</td>
      </tr>

     ";
 }
}
}
?>

<tr style="background-color: green;">
  <th style="color: white;">Recycle</th>
</tr>


<?php
if(!empty($list)){
  foreach($list As $product){
    $id = htmlspecialchars($product['id'],ENT_QUOTES, 'UTF-8');
    $type = htmlspecialchars($product['type'],ENT_QUOTES, 'UTF-8');
    $desc = htmlspecialchars($product['description'],ENT_QUOTES, 'UTF-8');

  if($type == "Recycle"){
    echo "
      <tr>
        <td>{$desc}</td>
      </tr>
    ";
}
}
}
?>

<tr style="background-color: red;">
  <th style="color: white;">General</th>
</tr>

<?php
if(!empty($list)){
  foreach($list As $product){
    $id = htmlspecialchars($product['id'],ENT_QUOTES, 'UTF-8');
    $type = htmlspecialchars($product['type'],ENT_QUOTES, 'UTF-8');
    $desc = htmlspecialchars($product['description'],ENT_QUOTES, 'UTF-8');

  if($type == "General Waste"){
    echo "
      <tr>
        <td>{$desc}</td>
      </tr>
    ";
}
}
}
?>

