<?php
include "signIn.php";
function connectingIt(){
$servername = "mysql.cs.uky.edu";
$username = "iyse222";
$password = logIn();
// create coonecttion:
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
try {
  $conn = new PDO("mysql:host=$servername;dbname=iyse222", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  //echo "Connected successfully";
} catch(PDOException $e) {
  //echo "Connection failed: " . $e->getMessage();
}
return $conn; // to retun the coonn
}
?>
<?php
if(isset($_POST['buttonNames']) ) { // gave it the wrong name, should buttonames as below
 // call those function
 // and connect to the server:
 //$conn = connectingIt();
$bigMenu = bigMenu($_POST['buttonNames']); // passing in a value !
// goes back as response 
echo $bigMenu;
exit; // kills the php 
}
?>
<?php
      function bigMenu ($items) {
      // make it modular:
      // echo the header
      // remove echos echo "<h2> Details about $items </h2>";
      // example from dr. f's site
      // ie$sql = "SELECT price FROM menu WHERE category = ?;
      //$prepared = $pdo->prepare($sql);
      //$prepared->execute([$valueFromHTMLform]);
      // connect to the mysql from the above connection and the var $conn named it connectingIt
      $conn = connectingIt();
      // this is the prepare statement and coonect it to the ? marker to protect the site from attacks
      $stmt = $conn->prepare("select number from accesses where category = ?");
      $stmt->execute([$items]); // returns the row 
      // use the fetch to gather the data from the table
      $row =$stmt->fetch();
      // plus need to accumulate for it:
      $row= $row['number']; // comment: the class makes it red too
      // and tie the $row to the accumulation.

      // echo "<p class = 'lingual'>You have requested this information $row times</p>"; // row is the number from the DB
      // and update the accesses with the acculation with this:
      $sql = "update accesses set number = number + 1 where category = ?";
      // another prepared statement for the incrementation:
      $stmt = $conn->prepare($sql); // this adds it up.
      // this excutes the incrementation:
      $stmt->execute([$items]); // returns the row 
        $sql = "select item, description, price from menu where category = ?"; // needs to be moved
        $stmt = $conn->prepare($sql); // this adds it up. // prepare make the website safer
        $stmt->execute([$items]); // good - > check
        $myObj->category = $items;
        // pass row to tables
        $myObj->accesses = $row; 
        // another array: to store the array of the array
        $placeHolder = array();
        while($row = $stmt->fetch()) {
          // add the array here:
          $a=array("items"=>$row['item'], "descriptions"=>$row['description'], "prices"=>$row['price']);
          array_push($placeHolder, $a); // to add more to the array
         }
         $myObj->details =  $placeHolder;
         $myJSON = json_encode($myObj);
         return $myJSON; 
      }?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"
	integrity="sha384-vtXRMe3mGCbOeY7l30aIg8H9p3GdeSe4IFlP6G8JMa7o7lXvnz3GFKzPxzJdPfGK"
	crossorigin="anonymous"></script>
  <script
	src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"
	integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB"
	crossorigin="anonymous"></script>
  <script
	src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
	integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13"
	crossorigin="anonymous"></script>

     <!-- add the css back in the style section below: needs work, remove the js style.  -->
      <!-- change the font in the header:  -->
      <!-- use a locally downloaded font and its css ? is it right ?  not need ling, if had it downloaded
    	/* another locally downloaded font */-->

      <link rel="stylesheet"
	href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
	integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3"
	crossorigin="anonymous">
<style> 
@font-face {
    font-family: antique-heritage;
		src: url(antique-heritage-font/AntiqueHeritagePersonalUseRegular-9Y9Wy.otf);
	}
	h2 {
    font-family: antique-heritage;
		font-size: 10px;
	}
	.green {
		color: green;
		background-color: #f0fff0;
		border-radius: 15px;
		padding: 10px;
		border: 1px solid brown;
	}
    body {font-family: "Free Serif"; color:black;}
    .Atable { 
              border:1px solid black; 
              background-color: beige; 
              text-align: center;}
    .poisonous {border-top: 2px solid red; border-bottom: 2px solid red; 
                border-left: 2px solid  blue; border-right: 2px solid blue;}
    .inedible {border: 2px solid green;}
    .Multi {color:green;}
    .lingual {color:red;}
    .move {;}
    .hover {;}
  </style>
  <title>Munshn Lunshn</title>
</head>
<body Id = "body1">
<h1>Welcome to the High Times of Munshn Lunshn &#x2122;!</h1>
<p>All our clients are served right!<br><mark>See this website is under construction, as is our cafe.</mark></p>
<h2>See the menu</h2>
<p> Click on a word for details </p>
<!-- not the get way tho -->
<!-- <form method ="get"> -->
 <!-- ajax doesn't need a form 
in css it was:
<table class = 'Atable'>
  "offset-6 col-6"
  -->
  <div class="container-fluid">
	<div class="row">
		<div class="col-lg-5 col-md-7 col-sm-12">
  <table class="table table-striped table-bordered table-hover ">
  <thead class='table-dark'>
  <tr><th> Please </th><th> </th> <th> Order </th> <th> </th> <th> Something </th> <th>And go away!</th></tr>
    <tr>
<!-- the menu next and for -> maybe change the for pets ? each td need 3 funcs: // make all the other this the names of it ! -->
      <td 
      onmouseover="hover(this)" Id = "snacks" 
      onmouseout="mousemove(this)"
      onclick = "myClick('snacks')" 
      >snacks </td> <td>&#x1F34E;</td> 
      <td
      onmouseover="hover(this)" Id = "drinks" 
      onmouseout="mousemove(this)"
      onclick = "myClick('drinks')"
      > drinks </td> <td>&#x1F378;</td>
      <td
      onmouseover="hover(this)" Id = "mains" 
      onmouseout="mousemove(this)"
      onclick = "myClick('mains')"
      >mains </td> <td>&#x1F357;</td>
    </tr>
    <tr>
      <td
      onmouseover="hover(this)" Id = "deserts" 
      onmouseout="mousemove(this)"
      onclick = "myClick('deserts')"
      >deserts </td> <td>&#x1F382;</td>
      <td
      onmouseover="hover(this)" Id = "for_kids" 
      onmouseout="mousemove(this)"
      onclick = "myClick('for kids')"
      >for kids </td> <td>&#x1F37C;</td>
      <td
      onmouseover="hover(this)" Id = "for_pets" 
      onmouseout="mousemove(this)"
      onclick = "myClick('for pets')"
      >for pets </td> <td>&#x1F415;</td>
    </tr>
    <tr>
      <td
      onmouseover="hover(this)" Id = "TakeOut" 
      onmouseout="mousemove(this)"
      onclick = "myClick('TakeOut')"
      >take out </td> <td>&#x1F355;</td>
       <td
      onmouseover="hover(this)" Id = "inedible" 
      onmouseout="mousemove(this)"
      onclick = "myClick('inedible')" 
       class = 'inedible'>inedible </td> <td> &#x1F388;</td>
    <td
    onmouseover="hover(this)" Id = "poisonous" 
    onmouseout="mousemove(this)"
    onclick = "myClick('poisonous')" 
    class = 'poisonous'>poisonous</td> <td> &#x2620;</td>
    </tr>
  </table>
</div>
</div>
</div>
  <div id = "Inner"> </div>
<!-- tip ? button with bootstrap and javastrap  -->
  <!-- displays the total bill and tips from 15 - 20% * like his example: 
  * and make it to where the tip button is a little lower should unhide the inputbar-->
  <br/>
  <div class="offset-6 col-6">
  <button type="button" class="btn btn-success btn-sm" onclick = "ClickForBtn()" >Compute tip</button>
</div>
  <br/>
   <!-- next fill in the input field when the btn is click
  and after enter is hit or someone
  fix try the result from add adding the numbers:
  -->
  <div id = "Bill"> </div>
<!-- try to get rid of some and try the Jquery:
  <p>bill: </p>
  <p id = "totalBill" > </p>
-->
  <span class = 'collapse' id = 'inputStuff'> Please enter your total bill to see the tipping options below: <input \
  type='number' id='inputField' onkeyup='addTip();'/>
</span>
  <br>
  <span id='Tips'></span>
  <br/>
  <br/>
  <h2>We are hiring!</h2>
  <p>We are looking for employees who are</p>
<ol>
<li> Reliable </li>
<li> Prompt </li>
<li> Friendly
  <ul>
    <li> Able to deal with <i>obnoxious customers</i></li>
    <li> Able to deal with <i>critical managers</i></li>
    <li> Able to cater to <i>the chef's whims</i></li>
  </ul>
</li>
<li><span class = "Multi">Multi</span><span class = "lingual">lingual</span> </li>
<li> <b>Healthy</b> 
</li>
</ol>
<script>
    function hover(onSnacks){
      onSnacks.style.backgroundColor = 'green'; 
      onSnacks.style.color = 'white';
      };
    // or try the jquery way:
    //$(`#${onSnack}`).css({backgroundColor: 'beige', color: 'black'});
    function mousemove(onSnacks){
      onSnacks.style.backgroundColor = 'beige';
      onSnacks.style.color = 'black';
      }
    function SeeIt(){
      var SeeIt = document.getElementById('SeeIt');
      SeeIt.style.border = "solid black";
      SeeIt.style.backgroundColor = "beige";
      SeeIt.style.textAlign = "left";
      document.getElementById('redline').style.color = "red";
    }
    async function myClick(someItems) { 
  // keep this func
  // this is a str that must be added to it. // should change to fetch later ? change $.ajax
      $.post("http://cs.uky.edu/~iyse222/cs316/cafe-4.php", "buttonNames="+someItems).done(function(msg){ 
        // need to parse after post:
        var parsed // is the json obj
        parsed = JSON.parse(msg);
        console.log(parsed);
        let html = document.getElementById("Inner").innerHTML;
        //html = parse.category;
        if (document.getElementById('Inner') !=null){
            document.getElementById('Inner').innerHTML = "";
        }
        var header = document.createElement("h2");
        header.innerHTML = `<h2>Details about ${parsed.category}<\h2>`; // shares like details about snacks and mains. // but not working !? x-fix
        var access = document.createElement("p");
        access.innerHTML = `<p>You have requested this information ${parsed.accesses} times<\p>`;
        access.setAttribute("id", "redline");
        // populate table:
        var table = document.createElement("table");
        table.innerHTML = `<table>
                              <tr>
                                  <th>Item<\/th><th>Description<\/th><th>Price<\/th>
                              <\/tr>`
        // var name for .category:
        parsed.category; 
        parsed.accesses;
        if (parsed.details.length <= 0){
          document.getElementById('Inner').innerHTML = "";
        }
        else{
        for(var i = 0; i < parsed.details.length; i++){
          var info_inIt = `<tr>
                <td>${parsed.details[i].items}<\/td>
                <td>${parsed.details[i].descriptions}<\/td> 
                <td>${parsed.details[i].prices}<\/td>
          <\/tr>`
          table.innerHTML = table.innerHTML + info_inIt;
        }
        table.innerHTML = table.innerHTML + `<\/table>`
        table.setAttribute("id", "SeeIt");
        document.getElementById("Inner").append(header, access, table);
        SeeIt();
        }
      });// fill in what's inside it.  hide, until user clicks on it
		} // getDate // * tried to just use javascript, but messed it up and went back to using Jquery
      function ClickForBtn(){
        $('#inputStuff').collapse('show');
      }
        function addTip() {
          // replaced id totalBills with inputField
		      let firstTips =
			        parseFloat(document.querySelector('#inputField').value || 0) ;
		      let tips15 = (firstTips * .15);
          //let numTips15 = tips15.toFixed(2);
          let tips18 = firstTips * .18;
          let tips20 = firstTips * .20;
          let tips25 = firstTips * .25;
			        //parseFloat(document.querySelector('#second').value || 0);
  document.querySelector('#Tips').innerText =
	`with 15% tip: ${(firstTips+tips15).toFixed(2)}\nwith 18% tip: ${(firstTips+tips18).toFixed(2)}\nwith\
   20% tip: ${(firstTips+tips20).toFixed(2)}\nwith 25% tip: ${(firstTips+tips25).toFixed(2)}`;
	} // addthem  
document.querySelectorAll("td").forEach(function (elt) {
		new bootstrap.Tooltip(elt, {
			title: 'Please order something!'
		});
});     
</script>
</body>
</html>