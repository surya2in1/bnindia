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
           Branch Name: <?= isset($group_details->ug['branch_name']) ? $group_details->ug['branch_name'] : '-' ?>
         </td>
       </tr>
        <tr>
         <td>
           Group Code: <?= isset($group_details->group_code) ? $group_details->group_code : '-' ?>
           &nbsp; &nbsp;
           Denomination: (<?= isset($group_details->premium) ? $group_details->premium : '-' ?> * <?= isset($group_details->total_number) ? $group_details->total_number : '-' ?>)
           &nbsp; &nbsp; 
           Chit Value: <?= isset($group_details->chit_amount) ? $group_details->chit_amount : '0.00' ?>
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

      <h3>Auction Report</h3> 
      <table>
         <thead>
           <tr> 
             <th>Auction No.</th>
             <th>Date</th>
             <th>Winner Subscriber Name</th> 
             <th>Ticket No.</th>
             <th>Priced Amount</th> 
             <th>Total Dividend</th>
             <th>Subscriber Dividend</th>
            </tr>
         </thead>
         <tbody>
            <?php  
            if(!empty($report)){
               foreach ($report as $key => $value) {?>
                   <tr> 
                     <td><?= ($value->auction_no) ? $value->auction_no : '-'; ?></td>
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
                     <td><?= ($value->member) ? ucwords($value->member) : '-'; ?></td>
                     <td><?= ($value->ticket_no) ? $value->ticket_no : '-'; ?></td> 
                     <td><?= ($value->priced_amount) ? $value->priced_amount : '-'; ?></td> 
                     <td><?= ($value->total_subscriber_dividend) ? $value->total_subscriber_dividend : '-'; ?></td> 
                     <td><?= ($value->subscriber_dividend) ? $value->subscriber_dividend : '-'; ?></td> 
                  </tr> 
               <?php }
            }else{ ?>
               <tr><td colspan="7"><center>Records not found!!!</center></td></tr>
            <?php }
            ?>
         </tbody>
      </table>
   </div>
</body>
</html> 

<?php //echo $this->Html->link(__('Download PDF'), ['action' => 'pdf', $report->id ]) ?>
