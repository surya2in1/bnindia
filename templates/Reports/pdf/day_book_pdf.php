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
         <td>
           Day Book  
         </td>
       </tr>
        <tr>
         <td>
          Selected date: <?= $post['start']; ?> 
         </td>
       </tr>
       <tr>
         <td valign=middle>
           Date: <?= date('m/d/Y');?>
         </td>
       </tr>
     </table>

      <h3>DAY BOOK</h3>  
      <table>
         <thead>
           <tr> 
             <th rowspan="2">Date</th>
             <th rowspan="2">General Number</th>
             <th rowspan="2">On what account received or Paid</th>
             <th colspan="5">Receipts</th> 
             <th rowspan="2">Reference Receipt in the Receipt book</th>
             <th colspan="5">Expenditure</th>  
             <th rowspan="2">Balance</th>  
             <th rowspan="2">Reference to the page number of the voucher in the file of vouchers</th>  
             <th rowspan="2">Signature of foreman</th>  
             <th rowspan="2">Remarks</th>  
            </tr>
            <tr>
                <th>Receipts Subscriptions</th>
                <th>Interest</th>
                <th>Withdrawal</th>
                <th>Other</th>
                <th>Total</th>
                <th>Amount paid to subscriber</th>
                <th>Expenditure Foremans Commission</th>
                <th>Deposit in the bank</th>
                <th>Other Items</th>
                <th>Total Expenditure</th>
            </tr>
         </thead>
         <tbody>
            <?php  
            if(!empty($report)){
              $sr_no=1;
              $total =0 ;
              $total_expenditure =0;
               foreach ($report as $key => $value) {?>
                <?php
                $total = $total + (isset($value['receipt_total']) && ($value['receipt_total']>0) ? $value['receipt_total'] : 0 ); 
               $total_expenditure = $total_expenditure + (isset($value['pv_total']) && ($value['pv_total']>0) ? $value['pv_total'] : 0 );
                ?>
                   <tr>
                     <td><?= $post['start']; ?></td>
                     <td><?= $sr_no; ?></td>
                     <td><?= isset($value['receipt_name']) ?  $value['receipt_name'] :'--'; ?></td>
                     <td><?= isset($value['receipt_subcription']) ?  $value['receipt_subcription'] :'--'; ?></td>
                     <td><?= isset($value['receipt_interest']) ?  $value['receipt_interest'] :'--'; ?></td>
                     <td></td>
                     <td></td>
                     <td><?= isset($value['receipt_total']) ?  $value['receipt_total'] :'--'; ?></td>
                     <td><?= isset($value['receipt_no']) ?  $value['receipt_no'] :'--'; ?></td>
                     <td><?= isset($value['pv_total']) ?  $value['pv_total'] :'--'; ?></td>
                     <td><?= isset($value['expenditure_foremans_commission']) ?  $value['expenditure_foremans_commission'] :'--'; ?></td>
                     <td><?= isset($value['deposit_in_bank_amount']) ?  $value['deposit_in_bank_amount'] :'--'; ?></td>
                     <td></td>
                     <td><?= isset($value['pv_total']) ?  $value['pv_total'] :'--'; ?></td>
                     <td></td>
                     <td><?= isset($value['referece_no']) ?  $value['referece_no'] :'--'; ?></td>
                     <td></td>
                     <td><?= isset($value['remark']) ?  $value['remark'] :'--'; ?></td> 
                   </tr> 
               <?php $sr_no = $sr_no +1;}?>
               <?php  
               $balance = $total - $total_expenditure;
               ?>
                  <tr>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td><?= $total; ?></td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td><?= $total_expenditure; ?></td>
                     <td><?= $balance; ?></td>
                     <td></td>
                     <td></td>
                     <td></td> 
                   </tr> 
            <?php }else{ ?>
               <tr><td colspan="18"><center>Records not found!!!</center></td></tr>
            <?php }
            ?>
         </tbody>
      </table>
   </div>
</body>
</html> 
 