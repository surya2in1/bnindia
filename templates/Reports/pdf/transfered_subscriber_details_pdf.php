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
              <?php $group_code = isset($groups_details) && ($groups_details!='all') ? $groups_details->group_code : '-';
                if($groups_details =='all'){
                    $group_code = 'All Groups';
                }
            ?>
           Group  Code: <?= $group_code;?>
         </td>
       </tr>
       <tr>
         <td valign=middle>
           Date: <?= date('m/d/Y');?>
         </td>
       </tr> 
     </table>

      <h3>Transfered Subscriber List</h3> 
      <table> 
         <thead>
            <tr> 
               <th>Sr. No.</th>
               <th>Group Code</th>
               <th>Ticket No.</th>
               <th>Old Subscriber Name</th>
               <th>Removed/Terminate Date</th>
               <th>Goverment Registration No</th> 
               <th>New Subscriber Name</th>
               <th>Address</th>
            </tr>
         </thead> 
         <tbody>
            <?php  
            if(!empty($report)){
               foreach ($report as $key => $value) {?>
                   <tr>
                    <td><?= $key+1; ?></td>
                    <td><?= ($value->g['group_code']) ? $value->g['group_code'] : '-'; ?></td>
                    <td><?= ($value->ticket_no) ? $value->ticket_no : '-'; ?></td>
                    <td><?= ($value->old_subscriber) ? ucwords($value->old_subscriber) : '-'; ?></td>
                    <td><?= ($value->terminate_date) ? $value->terminate_date : '-'; ?></td>
                    <td><?= ($value->g['gov_reg_no']) ? $value->g['gov_reg_no'] : '-'; ?></td>
                    <td><?= ($value->new_subscriber) ? ucwords($value->new_subscriber) : '-'; ?></td>
                    <td><?= ($value->address_new_member) ? $value->address_new_member : '-'; ?></td>\
                  </tr> 
               <?php }
            }else{ ?>
               <tr><td colspan="8"><center>Records not found!!!</center></td></tr>
            <?php }
            ?>
         </tbody>
      </table>
   </div>
</body>
</html> 

