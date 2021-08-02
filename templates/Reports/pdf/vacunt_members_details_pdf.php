<?php 
use Cake\I18n\FrozenDate;
use Cake\Core\Configure;

$cakeDescription = 'Bnindia'; 
?>
<!DOCTYPE html>
<html>
<head>
 
<style>
@page {
   margin: 0px 5px 0px 5px !important;
   padding: 0px 5px 0px 5px !important;
}
</style>
<style>
body{
   font-size: 10px;
}
h3{
   text-align: center;
}
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
  margin-bottom: 10px;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 4px !important;
}

tr:nth-child(even) {
  background-color: #dddddd;
}

.tbl-header{
	margin-top: 10px;
}
</style>

</head>
<body>
   <div class="content">
      <table class="tbl-header">
       <tr>
         <td>
           <?=Configure::read('CHITNAME'); ?>
         </td>
       </tr>
       <tr>
         <td valign=middle>
           Branch Name: <?= isset($branch_name) ? $branch_name : '-' ?>
         </td>
       </tr>
       <tr>
         <td valign=middle>
           Date: <?= date('m/d/Y');?>
         </td>
       </tr>
     </table>

      <h3>Vaccant Member Report</h3> 
      <table>
         <thead>
           <tr> 
             <th>Group Code-Ticket No.</th>
             <th>Chit Value(Rs.)</th>
             <th>Duration(Months)</th> 
             <th>Monthly Subcription(Rs.)</th>
             <th>Ticket No.</th> 
             <th>Name of Subscriber</th>
             <th>No. of Installment Payable(Rs.)</th>
             <th>Total Amount Payable(Rs.)</th>
             <th>Total Dividend(Rs.)</th>
            </tr>
         </thead>
         <tbody>
            <?php  
            if(!empty($report)){
               foreach ($report as $key => $value) {?>
                   <tr>
                     <td><?= ($value->gr_code_ticket) ? $value->gr_code_ticket : '-'; ?></td>
                     <td><?= ($value->g['chit_amount']) ? $value->g['chit_amount'] : '-'; ?></td>
                     <td><?= ($value->g['no_of_months']) ? $value->g['no_of_months'] : '-'; ?></td>
                     <td><?= ($value->g['premium']) ? $value->g['premium'] : '-'; ?></td>
                     <td><?= ($value->ticket_no) ? $value->ticket_no : '-'; ?></td>
                     <td><?= ($value->member) ? ucwords($value->member) : '-'; ?></td>
                     <td><?= ($value->no_of_installments) ? $value->no_of_installments : '-'; ?></td>
                     <td><?= ($value->total_amt_payable) ? $value->total_amt_payable : '-'; ?></td>
                     <td><?= ($value->total_dividend) ? $value->total_dividend : '-'; ?></td>
                  </tr> 
               <?php }
            }else{ ?>
               <tr><td colspan="9"><center>Records not found!!!</center></td></tr>
            <?php }
            ?>
         </tbody>
      </table>
   </div>
</body>
</html> 

