<!DOCTYPE html>
 
<html lang="en">
<head>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
 <title>Pagination</title>
 <link href="http://localhost/greeking-solutions/assets/lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
 <style type="text/css" media="screen">
 #container {
  width: 600px;
  margin: auto;
 font-family: helvetica, arial;
 }
 
 table {
  width: 600px;
  margin-bottom: 10px;
 }
 
 td {
  border-right: 1px solid #aaaaaa;
  padding: 1em;
 }
 
 td:last-child {
  border-right: none;
 }
 
 th {
  text-align: left;
  padding-left: 1em;
  background: #cac9c9;
 border-bottom: 1px solid white;
 border-right: 1px solid #aaaaaa;
 }
 
 #pagination a, #pagination strong {
  background: #e3e3e3;
  padding: 4px 7px;
  text-decoration: none;
 border: 1px solid #cac9c9;
 color: #292929;
 font-size: 13px;
 }
 
 #pagination strong, #pagination a:hover {
  font-weight: normal;
  background: #cac9c9;
 }  
 </style>
</head>
<body>
     <div id="container">
  <h1>Pagination</h1>
   
  <?php echo $mytable; ?>
  </div>
      
<!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js" type="text/javascript" charset="utf-8"></script>  -->
 
<script type="text/javascript" charset="utf-8">
 $('tr:odd').css('background', '#e3e3e3');
</script>
</body>
</html>