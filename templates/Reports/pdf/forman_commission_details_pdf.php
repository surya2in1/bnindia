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
           Date Range: <?= $post_data['start'];?> - <?= $post_data['end'];?>
         </td>
       </tr>
       <tr>
         <td valign=middle>
           Date: <?= date('m/d/Y');?>
         </td>
       </tr>
     </table>

      <h3>Forman Commission/GST Received Report</h3> 
      <table>
         <thead>
           <tr> 
             <th>Date</th>
             <th>Group Code</th>
             <th>Auction Date</th> 
             <th>Auction No.</th>
             <th>Name of Subscriber</th>
             <th>Chit Amount</th>
             <th>Forman Commission</th>
             <th>Received GST</th>
             <th>Prized Amount Paid</th>
             <th>Cheque Details</th>
            </tr>
         </thead>
         <tbody>
            <?php  
            if(!empty($report)){
               foreach ($report as $key => $value) {?>
                   <tr>
                    <td>
                        <?php 
                          if($value->date){
                            $FrozenDateObj = new FrozenDate($value->date); 
                                echo $FrozenDateObj->i18nFormat('MM/dd/yyyy'); 
                          }else{
                            echo '-';
                          }
                        ?>
                     </td>
                     <td><?= ($value->g['group_code']) ? $value->g['group_code'] : '-'; ?></td>
                     <td>
                        <?php 
                          if($value->auction_date){
                            $FrozenDateObj = new FrozenDate($value->auction_date); 
                                echo $FrozenDateObj->i18nFormat('MM/dd/yyyy'); 
                          }else{
                            echo '-';
                          }
                        ?>
                     </td>
                     <td><?= ($value->a['auction_no']) ? $value->a['auction_no'] : '-'; ?></td>
                     <td><?= ($value->member) ? ucwords($value->member) : '-'; ?></td>
                     <td><?= ($value->g['chit_amount']) ? $value->g['chit_amount'] : '-'; ?></td>
                     <td><?= ($value->foreman_commission) ? $value->foreman_commission : '-'; ?></td>
                     <td><?= ($value->gst) ? $value->gst : '-'; ?></td>
                     <td><?= ($value->a['priced_amount']) ? $value->a['priced_amount'] : '-'; ?></td>
                     <td><?= ($value->cheque_dd_no) ? $value->cheque_dd_no : '-'; ?></td>
                  </tr> 
               <?php }
            }else{ ?>
               <tr><td colspan="10"><center>Records not found!!!</center></td></tr>
            <?php }
            ?>
         </tbody>
      </table>
   </div>
</body>
</html> 

