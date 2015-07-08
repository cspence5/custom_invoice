<?php
session_start();
$project_name = substr($_GET['pname'], 2);
$location     = $_SESSION['folder'] . "/" . rawurlencode($project_name);
$directory    = $location . "/logo.PNG";
include("picIndicator.php");
if (!isset($_SESSION['loginid'])) { //if login in session is not set
    echo '<script>alert("Your session has expired. Please Login");</script>';
    echo '<script>window.location = "index.html";</script>';
}


$SID = $_SESSION['loginid'];

$time = time();


include("invoicewarehouse.php");
include("breakmaker.php");

$breakX            = new breakmaker();
$_name             = $_GET['pname'];
$JobId             = $_GET['I'];
$TID               = $_GET['TID'];
$name2             = $_GET['tname'];
//echo $_name;
$invoiceWarehouse1 = new invoicewarehouse();
$invoiceWarehouse1->setUser($_SESSION['loginid'], $name2, $_name);
// echo  $invoiceWarehouse1 -> returnUser();

$customerData = $invoiceWarehouse1->get_info($_GET["I"], $_GET["TID"]);
$pname        = $_GET['pname'];
$pname        = str_replace("X", "", $pname);

?>



<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		 <meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Invoice</title>
		<link rel="stylesheet" href="invoice_style.css">
		<link rel="license" href="http://www.opensource.org/licenses/mit-license/">
		<script src="invoice_script.js"></script>
	</head>
	<body>
	   <div class="voice" media="print">
		<header>
			<h1>Invoice</h1>
			</br>
			<?php
if ($invoiceWarehouse1->is_logo($_GET["I"]) == true) {
    Print '<span><img alt="" src=' . $directory . '?t=' . $time . '><input type="file" accept="image/*"></span>';
    
    
    
} else {
    Print '<span><img alt="" src="logo.png"><input type="file" accept="image/*"></span>';
}



?>


</br>
</br>
</br>
</br>
</br>
</br>
</br>
<table class="metav" >


			
			

		<tr>
				  <th><span  contenteditable>Ticket Title: </span></th>
				  <td contenteditable="true" style="max-width: 150px; border:1px solid black; word-wrap: break-word; overflow: hidden; !important;"> <?php
echo $invoiceWarehouse1->ticketName;
?> </td>
				   
				  
				  
				</tr>
			



			<tr>
				 
					
					<th><span contenteditable>Ticket #:</span></th>
					<td><span contenteditable><?php
echo str_pad($invoiceWarehouse1->ticketNumber, 4, '0', STR_PAD_LEFT);
?> </span></td>
				</tr>
			
			
			
			<tr>
				
				<th> <span class="nowrap" contenteditable>Ticket Description: </span></th>
				  <td  style="word-wrap: break-word"> <span contenteditable> <?php
echo $invoiceWarehouse1->description;
?></span></td>
				  
			</tr>
			
			
			
			
			
			</table>
			
			<!-- <span><img alt="" src="logo.png"><input type="file" accept="image/*"></span> --> 
			<table class="meta">
							<tr>
				  <th><span contenteditable>Attention: </span></th>
				  <td><span contenteditable><?php
echo $customerData[0];
?></span></td>
				  
				  
				</tr>
				
					<tr>
					<th><span contenteditable>Date</span></th>
					<td><span contenteditable>	<?php
echo $invoiceWarehouse1->closedDate;
?></span></td>
				</tr>
				
				
				
				
				
				
			
				<tr>
					<th><span class="nowrap" contenteditable>Amount Due</span></th>
					<td><span id="prefix" contenteditable>$</span><span>600.00</span></td>
				</tr>
			</table>
		
	
		
		
		
		</header>
		
		
	<!--	<article>
			<h1>Recipient</h1> -->
			
	
			
		<!--	<address contenteditable>
				<address contenteditable>
				<p>Name</p>
				<p>Address</p>
				<p>Phone #</p>
			
			</address>
			
			
			</address> -->
		
		
	             	
			
				<table class="inventory material">
				<thead>
				      <div>   <caption style="text-align:left">Material</caption> </div>
					 
					<tr>   
						<th><span contenteditable>Item</span></th>
						<th><span contenteditable>Unit</span></th>
						<th><span contenteditable>Rate</span></th>
						<th><span contenteditable>Quantity</span></th>
						<th><span contenteditable>Cost</span></th>
						<th><span contenteditable>Tax(<span class="tRate"><?php

if ($customerData[4]) {
    
    echo $customerData[4];
}

else {
    
    echo "0";
}


?>
						
						
						
						</span>%)</span></th>
						
						
						
						
						
						<th><span class="TM" contenteditable>Total</span></th> </tr>
						
					</tr>
				</thead>
				<tbody>  <?php
$invoiceWarehouse1->printMaterialsInvoiceGMI($TID, $JobId);
?>
			
					   <tr> <td class="nothing"></td><td class="nothing"></td><td class="nothing"></td><td class="nothing"></td><td class="nothing"></td> <td class="nothing"></td> 
					   <th><span class="MT" contenteditable>Material Total</span></th></tr> 
					 
					 <tr><td class="nothing"></td> <td class="nothing"></td> <td class="nothing"></td><td class="nothing"></td><td class="nothing"></td><td class="nothing"></td>  
					  <td><span data-prefix>$</span><span class='material_total'>600.00</span></td></tr>	
						
					
                     
				</tbody>
			</table>
			<!--<a class="add material">+</a> -->
			
			
			
			
			
			<table class="inventory labor">
		<thead>
                <div>   <caption style="text-align:left">Labor</caption> </div>
					<tr>    <td class="nothing"></td>
					     <th><span contenteditable>Position</span></th>
						<th><span contenteditable>Regular Rate</span></th>
						<th><span contenteditable>Regular Hours</span></th>
						<th><span contenteditable>Overtime Rate</span></th>
						<th><span contenteditable>Overtime Hours</span></th>
					    <th><span class="TL" contenteditable >Total</span></th>
				
					</tr>
				</thead>
				<tbody>
					<?php
$invoiceWarehouse1->printLaborInvoiceGMI($TID, $JobId, $SID);
?>
					
					
				
						
						  <tr> <td class="nothing"></td><td class="nothing"></td><td class="nothing"></td><td class="nothing"></td><td class="nothing"></td><td class="nothing"></td> 
					   <th><span class="MT" contenteditable>Labor Total</span></th></tr>
					 
					 <tr><td class="nothing"></td> <td class="nothing"></td> <td class="nothing"></td><td class="nothing"></td> <td class="nothing"></td><td class="nothing"></td> 
					  <td><span data-prefix>$</span><span class='labor_total' >600.00</span></td></tr>	
						
						
						
						
					</tr> 
				</tbody>
			</table>
	
	
			
			
			
			
			
			
			
				<table class="inventory rental">
				<thead>
				    <div>   <caption style="text-align:left">Rental </caption> </div>
					<tr>   <td class="nothing"><td class="nothing"></td></td>
					 <td class="nothing"></td>
						<th><span contenteditable>Item</span></th>
						<th><span contenteditable>Qty</span></th>
						<th><span contenteditable>Days</span></th>
						<th><span contenteditable>Rate</span></th>
						<th><span  class="TR" contenteditable>Total</span></th>
						
						
					</tr>
				</thead>
				<tbody>
				         <?php
$invoiceWarehouse1->printRentalInvoiceGMI($TID);
?>
								
						<tr> <td class="nothing"></td><td class="nothing"></td><td class="nothing"></td><td class="nothing"></td><td class="nothing"></td> <td class="nothing"></td> <td class="nothing"></td> 
					   <th><span class="MT" contenteditable>Rental Total</span></th></tr>
					 
					 <tr><td class="nothing"></td> <td class="nothing"></td> <td class="nothing"></td><td class="nothing"></td> <td class="nothing"></td> <td class="nothing"></td> <td class="nothing"></td> 
					  <td><span data-prefix>$</span><span class='rental_total'>600.00</span></td></tr>	
						
						
						
						
						
						
						
						
						
					</tr>
				</tbody>
			</table>
			<!-- <a class="add rental">+</a> -->
			
			
			
			
			
			
			
			
			
			
			
			
			
			<table class="balance">
				<tr>
					<th><span contenteditable>Total</span></th>
					<td><span data-prefix>$</span><span>600.00</span></td>
				</tr>
				<tr style="display:none;">
					<th><span contenteditable>Amount Paid</span></th>
					<td><span data-prefix>$</span><span contenteditable>0.00</span></td>
				</tr>
				<tr style="display:none;">
					<th><span contenteditable>Balance Due</span></th>
					<td><span data-prefix>$</span><span>600.00</span></td>
				</tr> 
			</table>
		</article>
		
		</br>
		</br>
		</br>
		</br>
		</br>
		</br>
		</br>
		</br>
		
		<aside>
			<h1><span contenteditable>Additional Notes</span></h1>
			<div contenteditable>
				<p></p>
			</div>
		</aside>
	   </div>



</br>
</br>
</br>
</br>
</br>



































































<header>
		
		<h1>Ticket</h1>
		
	</header>

	




</br>










 
 
 
 
 
 
 
 
 
 






















	
	
	
	








	
	





















	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
		
	
	
	
	
	
	
	
	
	
		
	
	
	



	
	


<div class="container ticket">
    <div class="row">
        <div class="col-xs-12">
    		<div class="invoice-title" align="left">
    			<!--<td> <div class="col-md-3 col-lg-3 " align="left"> <img alt="Logo" src="logod.jpg" width="120" height="90" > 
				</div></td> -->
				
			
	
    		</div>
    		<hr>
    		
	

			
	

			<div class="row"> 
			
    		
			 <?php


$location = $_SESSION['folder'] . "/";
$ticket   = $_GET['tname'];

$newLocation = $location . rawurlencode($ticket) . "/";








// $breakX->makeBreak(3); 
$newname = $_GET['pname'];

//substr_replace($newname, 'I', 0, 0);
$X = substr($newname, 1);


?>
				
				
				<div class="col-xs-6">
    				
					<date> 
			
					<strong> Ticket:</strong> <?php
echo $invoiceWarehouse1->ticketName;
?> 
					<br />
					<strong> Company:</strong> <?php
echo $invoiceWarehouse1->companyName;
?> 
					<br />
					<strong> Project:</strong> <?php
echo $X;
?> 
						<br />
						<Description>
    					<strong>Description of Work:</strong><br>
    					  <?php
echo $invoiceWarehouse1->description;
?>
						  <br>
						  
				  <strong contenteditable="true">Labor Code: </strong> 
						
    					
    				</Description>
					</date>
			
    			
				
				
				
				</div>
    			

	
	
		
		
		
		
		
		
		
			
 
    	
    			<div class="col-xs-6">
    				<address>
    					<div align="right"><strong>Ticket #:</strong><br>
						
						<?php
echo str_pad($invoiceWarehouse1->ticketNumber, 4, '0', STR_PAD_LEFT);
?> <br> </div>
						<div align="right"><strong>Start Date:</strong><br>
					     <?php
echo $invoiceWarehouse1->openDate;
?> <br> </div>
						<div align="right"><strong>Finish Date:</strong><br>
    					<?php
echo $invoiceWarehouse1->closedDate;
?> <br> </div>
    				</address>
					
					
					
			
    			</div>
    		
    	</div>
		</div>
    </div>
    </br>
	</br>
	</br>
    
    <div class="row">
    	<div class="col-md-12">
    		<div class="panel panel-default">
    			<div class="panel-heading">
    				<h3 class="panel-title"><strong>Labor</strong></h3>
    			</div>
    			</br>
    			<div class="panel-body">
    				<div class="table-responsive">
    				
    				
					
						<table class="inventory">
    						<thead>
                                <tr>
        							<th><strong>Name</strong></td>
        							<th class="text-center"><strong>Position</strong></th>
									<th class="text-center"><strong>Reg. Hours</strong></th>
        							<th class="text-center"><strong>OT</strong></th>
        							<th class="text-center"><strong>Prem</strong></th> 
								<!--	<td class="text-right"><strong>Totals</strong></td> -->
                                </tr>
    						</thead>
    						<tbody>
    						  <?php







$invoiceWarehouse1->printLabor();
?>
							
                                
    						</tbody>
    					</table>
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					</div>
    			</div>
    		</div>
    	</div>
    </div>

	
	
	
	
	 <div class="row">
    	<div class="col-md-12">
    		<div class="panel panel-default">
    			<div class="panel-heading">
    				<h3 class="panel-title"><strong>Materials</strong></h3>
    			</div>
    			</br>
    			<div class="panel-body">
    				<div class="table-responsive">
    				
    				
					
						
					
					
					
					
					
					
					<table class="table table-condensed">
    						<thead>
                                <tr>
        							<th><strong class='text-left'>Item</strong></th>
        						<!--	<th class="text-left"><strong>Price</strong></th> -->
        							  
									<th class="text-center"><strong>Unit</strong></th>
									<th class="text-right"><strong>Quantity</strong></th>
        						<!--	<td class="text-right"><strong>Totals</strong></td> -->
                                </tr>
    						</thead>
    						<tbody>
    						    <?php





$invoiceWarehouse1->printMaterials();


?>
							
                                
    						</tbody>
    					</table>
					
					
					
					
					
					
					
					
					
					
					
					</div>
    			</div>
    		</div>
    	</div>
    </div>
	
	
	</br>
	</br>
	</br>
	
	 <div class="row">
    	<div class="col-md-12">
    		<div class="panel panel-default">
    			<div class="panel-heading">
    				<h3 class="panel-title"><strong>Equipment</strong></h3>
    			</div>
    			</br>
    			<div class="panel-body">
    				<div class="table-responsive">
    				
    				
					
						
					
					
					
					
					
					
					<table class="table table-condensed">
    						<thead>
                                <tr>
        							<th><strong class="text-left">Item</strong></th>
        						<!--	<td class="text-left"><strong>Price</strong></td> -->
        							  
									<th class="text-center"><strong>Days</strong></th>
									<th class="text-right"><strong>Quantity</strong></th>
        						<!--	<td class="text-right"><strong>Totals</strong></td> -->
                                </tr>
    						</thead>
    						<tbody>
    						    <?php



$invoiceWarehouse1->printRent();




?>
							
                                
    						</tbody>
    					</table>
					
					
					
					
					
					
					
					
					
					
					
					
    			</div>
    		</div>
    	</div>
    </div>
	
	</br>
	</br>
	</br>
	</br>
	
	<div class="signature" style="white-space:nowrap;" align="right"> 		<?php
$invoiceWarehouse1->printSignature();
?>	</div>							
	</br>
	<p style="float: right;"><?php
echo $invoiceWarehouse1->closedDate;
?> </p>			
	
	<br> <br> <br> 
	
	<aside>
			<h1><span contenteditable>Additional Notes</span></h1>
			<div contenteditable>
				<p></p>
			</div>
		</aside>
	       
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	

	
	
		
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	

	
	 <div class="row before" align="center">
    	
    		<?php


$indicator = new picIndicator();
$test      = $indicator->defaultOrNo($TID, 1);
$test2     = $indicator->defaultOrNo($TID, 2);
$test3     = $indicator->defaultOrNo($TID, 3);
$test4     = $indicator->defaultOrNo($TID, 4);
$test5     = $indicator->defaultOrNo($TID, 5);
$test6     = $indicator->defaultOrNo($TID, 6);

?>	
		
</br>
</br>
</br>		
		
		
    				<?php
if ($test == 1 || $test2 == 1 || $test3 == 1) {
    
    echo "</br><header><h1>Before Pictures</h1></header> </br>";
    
    
    
}

?>
    			 
								
			
	<?php
if ($test == 1) {
    echo "<div>  <td align='center'>	  <img type='image' src=" . $newLocation . "1.PNG?t=" . $time . " height='60%'  ></img></a> </td> </tr> </div>
				</br> </br>";
}
?>
		
		</br>
		<?php
if ($test2 == 1) {
    echo "<tr><td align='center'>  <img type='image' src=" . $newLocation . "2.PNG?t=" . $time . "  height='60%'   ></img></a> </td> </tr>
                    </br>";
}
?>			    
					
					</br>
			<?php
if ($test3 == 1) {
    echo "<tr> <td align='center'>  <img type='image' src=" . $newLocation . "3.PNG?t=" . $time . "   height='60%'  ></img></a> </td> </br>";
}
?> </tr>
				    </br>
				
				
				
				
				
				
			
									
							
							   
							
                                
    					
					
					
					
					
					
					
					
					
					
					
				
    			</div>
    		</div>
    
	
	
	
	
	
	
	
	
	
	
	
	<div class="row before" align="center">
    	
    				
					
<?php
if ($test4 == 1 || $test5 == 1 || $test6 == 1) {
    
    echo "<header><h1>After Pictures</h1></header></br>";
    
    
    
}














?>							
				
	<?php
if ($test4 == 1) {
    echo "<td align='center'>	  <img type='image' src=" . $newLocation . "4.PNG?t=" . $time . "   height='60%' ></img></a> </td> </tr> 
				</br>";
}
?>
		
		</br>
		<?php
if ($test5 == 1) {
    echo "<tr><td align='center'>  <img type='image' src=" . $newLocation . "5.PNG?t=" . $time . "   height='60%'  ></img></a> </td> </tr>
                    </br>";
}
?>			    
					
			</br>		
			<?php
if ($test6 == 1) {
    echo "<tr> <td align='center'>  <img type='image' src=" . $newLocation . "6.PNG?t=" . $time . "  height='60%'  ></img></a> </td> </tr>
				    </br>
				
				
				
				
				 
									
							
							   
							
                                
    				
					
					
					
					
					
					
					
					
					
					
					</div>
    			</div>
    		</div>
    	</div>
    </div>";
}
?>
	
	
	</body>
</html>

    				
    				
					

							
				
							
						
							
							
							
							
							
							
							
							
							
							
							
							
							
							
							
							
							
							
						
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
		
	
	
	
	
	
	
	
	
	
	
