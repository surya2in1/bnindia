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
   font-size: 11px;
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
          Start date: <?= $post['start']; ?> 
         </td>
       </tr>
       <tr>
         <td>
           End date: <?= $post['end']; ?> 
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
             <th colspan="4">Expenditure</th>  
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
                <th>Total Expenditure</th>
            </tr>
         </thead>
         <tbody>
            <?php  
            if(!empty($report)){
              $sr_no=1;
              $total =0 ;
              $total_expenditure =0;

              $total_receipt = 0;
              $total_interest = 0;
              $total_withdrawal = 0;

              $total_paid_to_subscriber = 0;
              $total_forman=0;
              $total_deposite_in_the_bank = 0;

               foreach ($report as $key => $value) {?>
                <?php  
                $total_receipt = $total_receipt + (isset($value['receipt_subcription']) && ($value['receipt_subcription']>0) ? $value['receipt_subcription'] : 0 );
                $total_interest = $total_interest + (isset($value['receipt_interest']) && ($value['receipt_interest']>0) ? $value['receipt_interest'] : 0 );
                $total_withdrawal = 0;

                $total_paid_to_subscriber =$total_paid_to_subscriber + (isset($value['pv_total']) && ($value['pv_total']>0) ? $value['pv_total'] : 0 );
                $total_forman=$total_forman + (isset($value['expenditure_foremans_commission']) && ($value['expenditure_foremans_commission']>0) ? $value['expenditure_foremans_commission'] : 0 );
                $total_deposite_in_the_bank = $total_deposite_in_the_bank + (isset($value['deposit_in_bank_amount']) && ($value['deposit_in_bank_amount']>0) ? $value['deposit_in_bank_amount'] : 0 );
 
                $receipt_total = (isset($value['receipt_subcription']) && ($value['receipt_subcription']>0) ?  $value['receipt_subcription'] : 0)
                +(isset($value['receipt_interest']) && ($value['receipt_interest']>0)  ?  $value['receipt_interest'] : 0) 
                  +(isset($value['other']) && ($value['other']>0)  ?  $value['other'] : 0);

                $pv_total = (isset($value['pv_total']) && ($value['pv_total']>0) ?  $value['pv_total'] : 0)
                +(isset($value['expenditure_foremans_commission']) && ($value['expenditure_foremans_commission']>0)  ?  $value['expenditure_foremans_commission'] : 0)
                 +(isset($value['deposit_in_bank_amount']) && ($value['deposit_in_bank_amount']>0)  ?  $value['deposit_in_bank_amount'] : 0) ;

                $total_expenditure = $total_expenditure + $pv_total;

                $total = $total + $receipt_total; 
              ?>
                <?php
                   if(isset($value['date_wise_total']) && $value['date_wise_total'] ==1){ ?>
                    <tr>
                         <td></td>
                         <td></td>
                         <td></td>
                         <td></td>
                         <td></td>
                         <td></td>
                         <td></td>
                         <td><b><?= isset($value['subscription']) && ($value['subscription']>0) ?  $value['subscription'] : 0; ?><b></td>
                         <td></td>
                         <td></td>
                         <td></td>
                         <td></td> 
                         <td><b><?= isset($value['pv_totals']) && ($value['pv_totals']>0) ?  $value['pv_totals'] : 0; ?><b></td>
                         <td></td>
                         <td></td>
                         <td></td>
                         <td></td> 
                       </tr> 
                  <?php }
                    else{ ?>
                       <tr>
                         <td><?= isset($value['receipt_date']) ?  $value['receipt_date'] :'';  ?></td>
                         <td><?= $sr_no; ?></td>
                         <td><?= isset($value['receipt_name']) ?  $value['receipt_name'] :'--'; ?></td>
                         <td><?= isset($value['receipt_subcription']) ?  $value['receipt_subcription'] :'--'; ?></td>
                         <td><?= isset($value['receipt_interest']) ?  $value['receipt_interest'] :'--'; ?></td>
                         <td></td>
                         <td><?= isset($value['other']) ?  $value['other'] :'--'; ?></td>
                         <td><?= $receipt_total; ?></td>
                         <td><?= isset($value['receipt_no']) ?  $value['receipt_no'] :'--'; ?></td>
                         <td><?= isset($value['pv_total']) ?  $value['pv_total'] :'--'; ?></td>
                         <td><?= isset($value['expenditure_foremans_commission']) ?  $value['expenditure_foremans_commission'] :'--'; ?></td>
                         <td><?= isset($value['deposit_in_bank_amount']) ?  $value['deposit_in_bank_amount'] :'--'; ?></td> 
                         <td><?= $pv_total; ?></td>
                         <td></td>
                         <td><?= isset($value['referece_no']) ?  $value['referece_no'] :'--'; ?></td>
                         <td></td>
                         <td><?= isset($value['remark']) ?  $value['remark'] :'--'; ?></td> 
                       </tr> 
               <?php $sr_no = $sr_no +1; ?>
                  <?php }
                ?> 

              <?php } ?>
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
                     <td><b><?= $total; ?><b></td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td> 
                     <td><b><?= $total_expenditure; ?><b></td>
                     <td><b><?= $balance; ?><b></td>
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

      <h3>Totals:</h3>
      <table class="tbl-header">
       <tr>
         <td>
           Receipts Subscriptions: <?=$total_receipt; ?>
         </td>
       </tr>
       <tr>
         <td valign=middle>
           Interest: <?=$total_interest; ?>
         </td>
       </tr>
       <tr>
         <td>
           Withdrawal: <?=$total_withdrawal; ?>
         </td>
       </tr>
        <tr>
         <td>
         Total: <?=$total; ?>
         </td>
       </tr>
       <tr>
         <td>
          Amount paid to subscriber: <?=$total_paid_to_subscriber; ?>
         </td>
       </tr>
       <tr>
         <td valign=middle>
          Expenditure Foremans Commission: <?=$total_forman; ?>
         </td>
       </tr>
       <tr>
         <td>
          Deposit in the bank: <?=$total_deposite_in_the_bank; ?>
         </td>
       </tr>
       <tr>
         <td valign=middle>
          Total Expenditure: <?=$total_expenditure; ?>
         </td>
       </tr>
       <tr>
         <td valign=middle>
          Balance: <?=$balance; ?>
         </td>
       </tr>
     </table>

   </div>
</body>
</html> 
 