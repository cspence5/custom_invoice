<?php
//include("Job.php");
include("aggregator.php");

class invoicewarehouse
{
    // property declaration
    
    //public $joblists;
    public $user;
    public $namex;
    public $namey;
    public $nameq;
    public $totalMaterial;
    public $totalLabor;
    public $totalRental;
    public $ticketID;
    public $signature;
    public static $description;
    public static $closedDate;
    public static $openDate;
    public static $ticketName;
    public static $companyName;
    public static $ticketNumber;
    
    
    function __construct()
    {
        
        
        $this->user  = 0;
        $this->namex = "";
        
    }
    
    public function setUser($User, $Name, $Name2)
    {
        $this->user       = $User;
        $this->nameq      = $Name;
        $this->namex      = "X" . $Name;
        $this->namey      = $Name2;
        $this->ticketID   = 0;
        $this->closedDate = "rmpty";
        mysql_connect('x', 'x', 'x');
        mysql_select_db('x') or die('Database error...');
        
        
        
        $pr = mysql_real_escape_string($this->nameq);
        $us = mysql_real_escape_string($this->user);
        
        $result = mysql_query("SELECT * FROM Tickets WHERE CompanyName='" . $pr . "' and `id`='" . $us . "' and Status='Closed'") or die("SQL Statement Error");
        
        if (!$result) {
            print "<tr class=odd gradeX>";
            print "<td>Failed!</td>";
            
        }
        
        
        while ($row = mysql_fetch_array($result)) { // print "success!";
            
            
            
            
            $this->ticketName   = $row['CompanyName'];
            $this->ticketNumber = $row['Number'];
            $this->signature    = $row['Signature'];
            $this->description  = $row['Description'];
            $this->closedDate   = $row['DateClosed'];
            $this->openDate     = $row['DateStarted'];
            //$ticketID = $row['TicketID'];
            
            
        }
        
        
        
        
        $result2 = mysql_query("SELECT * FROM Company WHERE `id`='" . $us . "'") or die("SQL Statement Error");
        
        if ($row = mysql_fetch_array($result2)) {
            
            $this->companyName = $row['Name'];
            
            
        }
        
        
        
        
        
        
    }
    
    public function returnUser()
    {
        
        return $this->user . $this->namex . $this->namey;
    }
    
    
    
    
    // method declaration
    public function printRent()
    {
        
        $userx      = $this->user;
        $ticketname = $this->namex;
        
        
        mysql_connect('x', 'x', 'x');
        mysql_select_db('cspencer_tianem_two0') or die('Database error...');
        
        
        
        $pr = mysql_real_escape_string($this->nameq);
        $us = mysql_real_escape_string($this->user);
        
        $result = mysql_query("SELECT * FROM Tickets WHERE CompanyName='" . $pr . "' and `id`='" . $us . "' and Status='Closed'") or die("SQL Statement Error");
        
        if (!$result) {
            print "<tr class=odd gradeX>";
            print "<td>Failed!</td>";
            //
        }
        
        
        while ($row = mysql_fetch_array($result)) { // print "success!";
            
            
            
            
            
            $i = 1;
            
            
            $ticketID = $row['TicketID'];
            //$this->signature = $row['Signature'];
            
        }
        
        
        $result2 = mysql_query("SELECT * FROM Rental WHERE Project='" . $this->namex . "' and `id`='" . $us . "' and TID='" . $ticketID . "'") or die("SQL Statement Error");
        
        //$Per=$row['Per'];
        
        
        if (!$result2) {
            
            echo "failed2";
        }
        
        while ($row = mysql_fetch_array($result2)) {
            //	print "success2!";
            
            $Name        = $row['Item'];
            $Quantity    = $row['Quantity'];
            $Rate        = $row['Rate'];
            $Days        = $row['Days'];
            $aggregator1 = new aggregator();
            $aggregator1->setUser($this->user, $this->namex);
            $rentRow         = $Quantity * $Rate * $Days;
            $totalf          = sprintf("%.2f", $rentRow);
            $rentTotal       = $aggregator1->rentalTotal();
            $this->totalRent = $this->totalRent + $totalf;
            
            
            
            
            
            
            
            
            
            print "<tr class='odd gradeX'>";
            
            
            print "<td class='text-left'>" . $Name . "</td>";
            //print "<td class='text-center'>" .$Rate. "</strong></td>";
            print "<td class='text-center'>" . $Days . "</td>";
            print "<td class='text-right'>" . $Quantity . "</td>";
            //print "<td class='text-center'>" .$totalf. "</td>";
            
            
            print "</tr>";
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
        }
        
    }
    
    
    public function printMaterials()
    {
        
        
        $userx      = $this->user;
        $ticketname = $this->namex;
        
        
        mysql_connect('x', 'x', 'x');
        mysql_select_db('x') or die('Database error...');
        
        $pr = mysql_real_escape_string($this->nameq);
        $us = mysql_real_escape_string($this->user);
        
        $result = mysql_query("SELECT * FROM Tickets WHERE CompanyName='" . $pr . "' and `id`='" . $us . "' and Status='Closed'") or die("SQL Statement Error");
        
        
        
        if (!$result) {
            print "<tr class=odd gradeX>";
            print "<td>Failed!</td>";
            
        }
        
        while ($row = mysql_fetch_array($result)) { // print "success!";
            
            
            
            
            
            $i = 1;
            
            
            $ticketID = $row['TicketID'];
            //echo $ticketID;
        }
        
        $result3 = mysql_query("SELECT * FROM Materials WHERE Job='" . $this->namex . "' and `id`='" . $us . "' and TID='" . $ticketID . "'") or die("SQL Statement Error");
        
        
        if (!$result3) {
            
            echo "failed2";
        }
        
        while ($row = mysql_fetch_array($result3)) {
            //print "success2!";
            
            $Name        = $row['Materials'];
            $Quantity    = $row['Quantity'];
            $Rate        = $row['UnitPrice'];
            $Unit        = $row['Description'];
            $aggregator1 = new aggregator();
            $aggregator1->setUser($this->user, $this->namex);
            
            $totalR = $Quantity * $Rate;
            
            $totalf              = sprintf("%.2f", $totalR);
            $materialTotal       = $aggregator1->materialTotal();
            $this->totalMaterial = $materialTotal;
            
            
            
            
            
            
            
            
            
            print "<tr class='odd gradeX'>";
            
            
            print "<td class='text-left'>" . $Name . "</td>";
            //print "<td class='text-left'>" .$Rate. "</strong></td>";
            print "<td class='text-center'>" . $Unit . "</strong></td>";
            print "<td class='text-right'>" . $Quantity . "</strong></td>";
            //print "<td class='text-right'>" .$totalf. "</td>";
            
            
            print "</tr>";
            
        }
        
    }
    
    
    
    public function printLabor()
    {
        
        
        
        
        
        $userx      = $this->user;
        $ticketname = $this->namex;
        
        
        mysql_connect('localhost', 'cspencer_Q', 'dragon27');
        mysql_select_db('cspencer_tianem_two0') or die('Database error...');
        
        
        
        $pr = mysql_real_escape_string($this->nameq);
        $us = mysql_real_escape_string($this->user);
        
        $result = mysql_query("SELECT * FROM Tickets WHERE CompanyName='" . $pr . "' and `id`='" . $us . "' and Status='Closed'") or die("SQL Statement Error");
        
        
        
        if (!$result) {
            print "<tr class=odd gradeX>";
            print "<td>Failed!</td>";
            
        }
        
        
        while ($row = mysql_fetch_array($result)) { // print "success!";
            
            
            
            
            
            $i = 1;
            
            
            $ticketID = $row['TicketID'];
            //echo $ticketID;
        }
        
        
        
        
        $result4 = mysql_query("SELECT * FROM Labor WHERE Job='" .$pr . "' and `id`='" . $us . "' and TID='" . $ticketID . "'") or die("SQL Statement Error");
        
        
        
        
        if (!$result4) {
            
            //echo "failed2";
        }
        
        while ($row = mysql_fetch_array($result4)) {
            //print "success4!";
            
            $Name        = $row['Name'];
            $Quantity    = $row['RHours'];
            $Quantity2   = $row['Ohours'];
            $Quantity3   = $row['Phours'];
            $Rate        = $row['Rate'];
            $Position    = $row['Position'];
            $aggregator1 = new aggregator();
            $aggregator1->setUser($this->user, $this->namex);
            $qTotal = $Quantity + $Quantity2 + $Quantity3;
            $qTotal = $qTotal * $Rate;
            $totalf = sprintf("%.2f", $qTotal);
            
            
            $laborTotal       = $aggregator1->laborTotal();
            $this->totalLabor = $laborTotal;
            
            
            
            
            
            
            
            
            
            
            
            
            
            print "<tr class=odd gradeX>";
            
            
            print "<td>" . $Name . "</td>";
            print "<td class='text-center'>" . $Position . "</strong></td>";
            print "<td class='text-center'>" . $Quantity . "</strong></td>";
            print "<td class='text-center'>" . $Quantity2 . "</strong></td>";
            print "<td class='text-center'>" . $Quantity3 . "</strong></td>";
            //print "<td class='text-right'>" .$totalf. "</td>";
            
            
            print "</tr>";
            
        }
        
        
    }
    
    
    
    
    
    
    public function printTotal()
    {
        
        $total  = $this->totalLabor + $this->totalMaterial + $this->totalRent;
        $totalf = sprintf("%.2f", $total);
        print "<td>" . $this->totalLabor . "</td>";
        print "<td class='text-center'>" . $this->totalMaterial . "</strong></td>";
        print "<td class='text-center'>" . $this->totalRent . "</strong></td>";
        print "<td class='text-right'>" . $totalf . "</strong></td>";
        
        
        print "</tr>";
        
        
        
        
        
        
        
        
    }
    
    public function printSignature()
    {
        
        echo " <p>Work Authorized By:" . $this->signature . "</p>";
        
        
        
        
        
        
        
        
        
    }
    
    
    
    public function printMaterialsInvoice($TID)
    {
        
        
        $counter = 0;
        
        
        mysql_connect('x', 'x', 'x');
        mysql_select_db('x') or die('Database error...');
        
        $id = mysql_real_escape_string($TID);
        
        
        
        
        $r = "Select * from Materials where Materials.TID=$id";
        
        $result = mysql_query($r) or die("SQL Statement Error");
        
        
        
        
        
        
        
        if (!$result) {
            print "<tr class=odd gradeX>";
            print "<td>Failed!</td>";
            return;
            
        }
        
        while ($row = mysql_fetch_array($result)) { // print "success!";
            
          
            
            $Name      = $row['Materials'];
            $get_price = "SELECT unit_price FROM `predefined_materials` where `item` like '%" . $Name . "%'";
         
            $Quantity  = $row['Quantity'];
            $Price     = $row['UnitPrice'];
            if ($Price == 0) {
                
                $get   = mysql_fetch_assoc(mysql_query($get_price));
                $Price = $get['unit_price'];
                if (!$Price) {
                    $Price = 0;
                    
                    
                }
                
            }
            
            
            
            
            
            
            $Total = $row['Total'];
            $Unit  = $row['Description'];
            $Cost  = '0';
            $Tax   = '0';
            $Total = 100;
            echo '<script> window.materialCounter =' . $counter . '</script>';
            
            Print "<tr><td><span id='find' class='originalM" . $counter . "'><nobr>" . $Name . "</span></nobr></td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td><span id='find' class='original'>" . " " . $Quantity . "</span></td>
<td><span id='find' class='original'>" . " " . $Unit . "</span></td>
<td><span id='find' class='original'>" . " " . $Price . "</span></td>
<td><span id='find' class='original C" . $counter . "'>" . " " . $Cost . "</span></td>
<td><span id='find' class='original tAmount" . $counter . "'>" . " " . $Tax . "</span></td>
 <td>&nbsp;</td>
<td span id='costM' class='noncomputeM" . $counter . "'>" . $Total . "</td></tr>";
            
            
            
            
            $counter = $counter + 1;
            
            
            
            
        }
        
        
    }
    
    
    
    
    public function printLaborInvoice($TID, $JobId, $SID)
    {
        
        
        
        
        
        mysql_connect('x', 'x', 'x');
        mysql_select_db('x') or die('Database error...');
        
        $id = mysql_real_escape_string($TID);
        
        
        $r = "SELECT * FROM `Labor` l 
LEFT JOIN `predifined_labor` pl
on l.Name = pl.employee_name
where `TID` =$id and pl.JobId =$JobId";
        
        $counter = 0;
        
        
        
        $result = mysql_query($r) or die("SQL Statement Error");
        
        
        
        if (!$result) {
            print "<tr class=odd gradeX>";
            print "<td>Failed!</td>";
            return;
            
        }
        
        while ($row = mysql_fetch_array($result)) { // print "success!";
            
            
            
            if ($SID == 68) {
                
                $Position = $row['Position'];
                $rHours   = $row['RHours'];
                $oHours   = $row['Ohours'];
                //$phours = $row['Phours'];
                $Name     = $row['Name'];
                $Rate     = $row['Rate'];
                $LaborId  = $row['LaborId'];
                $rRate    = $row['regular_rate'];
                $oRate    = $row['overtime_rate'];
                //$pRate = $row['premium_rate'];
                //$bRate = $row['burden_rate'];
                
                $Cost = 100;
                
                
                
                
                
                
                
                
                
            } else {
                $Position = $row['Position'];
                $rHours   = $row['RHours'];
                $oHours   = $row['Ohours'];
                $phours   = $row['Phours'];
                $Name     = $row['Name'];
                $Rate     = $row['Rate'];
                $LaborId  = $row['LaborId'];
                $rRate    = $row['regular_rate'];
                $oRate    = $row['overtime_rate'];
                $pRate    = $row['premium_rate'];
                $bRate    = $row['burden_rate'];
                
                $Cost = 100;
                
                
            }
            
            
            if (!$rRate) {
                
                $rRate = 0.0;
                
            }
            
            
            if (!$oRate) {
                
                $oRate = 0.0;
                
            }
            
            if (!$pRate) {
                
                $pRate = 0.0;
                
            }
            
            if (!$bRate) {
                
                $bRate = 0.0;
                
            }
            
            
            
            echo '<script> window.laborCounter =' . $counter . '</script>';
            
            if ($SID == 68) {
                
                Print "<tr id='level'><td><span id='find' class='original" . $counter . "'>" . $Position . "</span></td>
 <td>&nbsp;</td>
 
<td><span id='find' class='original'>" . " " . $rRate . "</span></td>
<td><span id='find' class='original'>" . " " . $rHours . "</span></td>
<td><span id='find' class='original'>" . " " . $oRate . "</span></td>
<td><span id='find' class='original'>" . " " . $oHours . "</span></td>
<td style='visibility:collapse;'><span id='find' class='original'>" . " " . $pRate . "</span></td>
<td style='visibility:collapse;'><span id='find' class='original'>" . " " . $phours . "</span></td>
<td style='visibility:collapse;'> <span id='find' class='original'>" . " " . $bRate . "</span><span>%</span></td>
 
<td><span id='cost' class='noncompute" . $counter . "'>" . " " . $Cost . "</span></td> 

</tr>";
                
                
                
                
                
                
            } else {
                
                Print "<tr id='level'><td><span id='find' class='original" . $counter . "'>" . $Position . "</span></td>
<td><span id='find' class='original'>" . " " . $rRate . "</span></td>
<td><span id='find' class='original'>" . " " . $rHours . "</span></td>
<td><span id='find' class='original'>" . " " . $oRate . "</span></td>
<td><span id='find' class='original'>" . " " . $oHours . "</span></td>
<td><span id='find' class='original'>" . " " . $pRate . "</span></td>
<td><span id='find' class='original'>" . " " . $phours . "</span></td>
<td> <span id='find' class='original'>" . " " . $bRate . "</span><span>%</span></td>
 
<td><span id='cost' class='noncompute" . $counter . "'>" . " " . $Cost . "</span></td>
</tr>";
                
            }
            
            
            /******
            Print "<tr><td><span id='find' class='original'>".$Position."</span>
            </td><td>&nbsp;</td><td>&nbsp;</td>
            <td><span id='find' class='original'>".$rRate."</span></td>
            <td><span id='find' class='original'>".$rHours."</span></td>
            <td><span id='find' class='original'>".$oRate."</span></td>
            <td><span id='find' class='original'>".$oHours."</span></td>
            <td><span id='find' class='original'>".$pRate."</span></td>
            <td><span id='find' class='original'>".$pHours."</span></td>
            <td><span id='find' class='original'>".$bRate."</span></td>
            <td><span id='cost' class='cost_original'>".$Cost."</span></td></tr>";
            *********/
            
            
            
            
            $counter = $counter + 1;
            
            
            
            
            
        }
        
        
    }
    
    
    
    public function printRentalInvoice($TID)
    {
        
        $counter = 0;
        
        
        
        mysql_connect('x', 'x', 'x');
        mysql_select_db('cspencer_tianem_two0') or die('Database error...');
        
        $id = mysql_real_escape_string($TID);
        
        
        $r = "SELECT * FROM Rental where Rental.TID=$id";
        
        
        
        
        
        
        
        $result = mysql_query($r) or die("SQL Statement Error");
        
        
        
        if (!$result) {
            print "<tr class=odd gradeX>";
            print "<td>Failed!</td>";
            return;
            
        }
        
        while ($row = mysql_fetch_array($result)) { // print "success!";
            
            
            $Item     = $row['Item'];
            $Quantity = $row['Quantity'];
            $Days     = $row['Days'];
            $Rate     = $row['Rate'];
            $Name     = $row['Name'];
            $Rate     = $row['Rate'];
            
            $Cost = 0;
            
            echo '<script> window.rentalCounter =' . $counter . '</script>';
            
            Print "<tr><td><span id='find' class='originalR" . $counter . "'>" . " " . $Item . "</span></td>
 <td>&nbsp;</td><td>&nbsp;</td>
 <td>&nbsp;</td><td>&nbsp;</td>
 <td><span id='find' class='original'>" . " " . $Quantity . "</span></td>
 <td><span id='find' class='original'>" . " " . $Days . "</span></td>
 <td><span id='find' class='original'>" . " " . $Rate . "</span></td>
   <td>&nbsp;</td>
 <td><span class='noncomputeR" . $counter . "'>" . $Cost . "</span></td></tr>";
            
            
            
            
            $counter = $counter + 1;
            
            
            
            
            
            
            
            
            
            
        }
        
        
    }
    
    
    
    
    public function get_info($ID, $TID)
    {
        
        $counter  = 0;
        $infoData = array();
      
        
        
        mysql_connect('x', 'x', 'x');
        mysql_select_db('cspencer_tianem_two0') or die('Database error...');
        
        $id = mysql_real_escape_string($ID);
        
        
        $r = "SELECT customer_name  from customer_information where PID=$id";
        
        
        
        
        $tid = mysql_real_escape_string($TID);
        
        $s = "Select Description, Number from Tickets where TicketID=$tid";
        
        
        $result = mysql_query($s) or die("SQL Statement Errordfsdfasdfsd");
        
        while ($row = mysql_fetch_array($result)) {
            
            
            $Description = $row['Description'];
            $Number      = $row['Number'];
            
            
        }
        
        
        $result1 = mysql_query($r) or die("SQL Statement Errordfsdfasdfsd");
        
        while ($row = mysql_fetch_array($result1)) {
            
            $customerName = $row['customer_name'];
            
            if (!$customerName) {
                $customerName = "Please enter recipient name here";
            }
            
            array_push($infoData, $customerName, date("m/d/y"), $Number, $Description);
            
            
        }
        
        
        
        
        
        
        
        
        return $infoData;
    }
    
    
    
    
    
    
    
    
    public function is_logo($PID)
    {
        
        
           
        
        
        mysql_connect('x', 'x', 'x');
        mysql_select_db('x') or die('Database error...');
        
        $id = mysql_real_escape_string($PID);
        
        
        $r = "SELECT logo from customer_information where PID=$id";
        
        
        $result = mysql_query($r) or die("SQL Statement Errordfsdfasdfsd");
        
        
        while ($row = mysql_fetch_array($result)) {
            
            
            $logo = $row['logo'];
            
            
            
        }
        
        if ($logo == 'Y') {
            return true;
        } else {
            return false;
            
        }
        
        
        
        
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}











































?>