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

      <h3>Group List</h3> 
      <table>
         <thead>
           <tr> 
             <th>Sr. No.</th>
             <th>Group Code</th>
             <th>Goverment Registration No.</th>
             <th>Group Type</th>
             <th>Collection Date</th> 
             <th>Total No. Of Subscriber</th>
             <th>Chit Amount</th> 
             <th>No. Of Month/Term</th>
             <th>Deposit Date</th>
             <th>Maturity Date</th>
             <th>Status</th>
            </tr>
         </thead>
         <tbody>
            <?php  
            $sr_no =1;
            if(!empty($report)){
               foreach ($report as $key => $value) {?>
                   <tr>
                     <td><?= $sr_no; ?></td>
                     <td><?= ($value->group_code) ? $value->group_code : '-'; ?></td>
                     <td><?= ($value->gov_reg_no) ? $value->gov_reg_no : '-'; ?></td>
                     <td><?= ($value->group_type) ? ucwords($value->group_type) : '-'; ?></td>
                     <td><?= ($value->date) ? ucwords($value->date) : '-'; ?></td>
                     <td><?= ($value->total_number) ? $value->total_number : '-'; ?></td>
                     <td><?= ($value->chit_amount) ? $value->chit_amount : '-'; ?></td>
                     <td><?= ($value->no_of_months) ? $value->no_of_months : '-'; ?></td>
                     <td> 
                        <?php 
                          if($value->bank_deposite_date){
                            $FrozenDateObj = new FrozenDate($value->bank_deposite_date); 
                                echo $FrozenDateObj->i18nFormat('MM/dd/yyyy'); 
                          }else{
                            echo '-';
                          }
                        ?>
                     </td>
                     <td> 
                        <?php 
                          if($value->deposite_maturity_date){
                            $FrozenDateObj = new FrozenDate($value->deposite_maturity_date); 
                                echo $FrozenDateObj->i18nFormat('MM/dd/yyyy'); 
                          }else{
                            echo '-';
                          }
                        ?>
                     </td>
                     <td><?= ($value->group_status) ? $value->group_status : '-'; ?></td>
                  </tr> 
               <?php $sr_no++;}
            }else{ ?>
               <tr><td colspan="10"><center>Records not found!!!</center></td></tr>
            <?php }
            ?>
         </tbody>
      </table>
   </div>
</body>
</html>
