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
           Register Of Subscribers  
         </td>
       </tr>
        <tr>
         <td>
          Start date: <?= $post['start']; ?>
          End date: <?= $post['end']; ?>
         </td>
       </tr>
       <tr>
         <td valign=middle>
           Date: <?= date('m/d/Y');?>
         </td>
       </tr>
     </table>

      <h3>Subscribers List</h3> 
       
      <table>
         <thead>
           <tr> 
             <th rowspan="2">Sr. No.</th>
             <th rowspan="2">Name and Full address according to Chit Agreement of the Subscriber</th>
             <th rowspan="2">Date of Signing the chit agreement</th> 
             <th rowspan="2">Date of receipt of the copy of the Chit Agreement by the Subscriber</th>
             <th colspan="2">Chit Subscriber</th>  
             <th rowspan="2">Name & Address of Assignee</th>  
             <th rowspan="2">Date of Assignment</th>  
             <th rowspan="2">Number of fraction of tickets</th>  
             <th rowspan="2">Amount</th>  
             <th rowspan="2">Date on which the Forman recognized the assignment</th>  
             <th rowspan="2">Reason for the removal Subscriber</th>  
             <th rowspan="2">Date of removal</th>  
             <th rowspan="2">Name and Address of the Subscriber</th>  
             <th rowspan="2">Date of substitution </th>  
             <th rowspan="2">Number fraction of tickets</th>  
             <th rowspan="2">Amount</th>  
             <th rowspan="2">Date of substitution</th>  
             <th rowspan="2">Remark</th>  
            </tr>
            <tr>
                <th>No. of Ticket</th>
                <th>Amount</th>
            </tr>
         </thead>
         <tbody>
            <?php  
            if(!empty($report)){
              $sr_no=1;
               foreach ($report as $key => $value) {?>
                   <tr>
                     <td><?= $sr_no; ?></td>
                     <td><?= !empty($value->name) ? $value->name : '--'; ?></td>
                     <td><?= !empty($value->date) ? $value->date : '--'; ?></td>
                     <td><?= !empty($value->date) ? $value->date : '--'; ?></td>
                     <td><?= !empty($value->mg['ticket_no']) ? $value->mg['ticket_no'] : '--'; ?></td> 
                     <td><?= !empty($value->g['chit_amount']) ? $value->g['chit_amount'] : '--'; ?></td>  
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td><?= !empty($value->trans_mg['removal_resaon']) ? $value->trans_mg['removal_resaon'] : '--'; ?></td> 
                     <td><?= !empty($value->date_of_removal) ? $value->date_of_removal : '--'; ?></td>
                     <td><?= !empty($value->trans_name) ? $value->trans_name : '--'; ?></td>
                     <td><?= !empty($value->trans_date) ? $value->trans_date : '--'; ?></td>
                     <td><?= !empty($value->trans_mg['ticket_no']) ? $value->trans_mg['ticket_no'] : '--'; ?></td>
                     <td><?= !empty($value->trans_g['chit_amount']) ? $value->trans_g['chit_amount'] : '--'; ?></td>
                     <td><?= !empty($value->date_of_removal) ? $value->date_of_removal : '--'; ?></td>
                     <td></td>
                   </tr> 
               <?php $sr_no = $sr_no +1;} 
            }else{ ?>
               <tr><td colspan="19"><center>Records not found!!!</center></td></tr>
            <?php }
            ?>
         </tbody>
      </table>
   </div>
</body>
</html> 
 