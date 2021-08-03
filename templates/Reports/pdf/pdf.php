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
         <td rowspan=4 width="50%">
           <?= Configure::read('CHITINFO'); ?>
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
       <tr>
         <td valign=middle>
           Branch Name: <?= isset($branch_name) ? $branch_name : '-' ?>
         </td>
       </tr>
     </table>
		<h3>Receipt Statement</h3> 
		<table>
			<thead>
			  <tr>
			    <th>Receipt No.</th>
			    <th>Date</th>
			    <th>Group Code</th>
			    <th>Member</th>
			    <th>Subscriber Ticket No.</th>
			    <th>Instalment No.</th>
			    <th>Instalment Month</th>
			    <th>Due date of payment</th>
			    <th>Subscription Rs.</th>
			    <th>Late Fee</th>
			    <th>Total Amount</th>
			    <th>Received By</th> 
			    <th>Remark</th>  
			  </tr>
			</thead>
		  	<tbody>
		  		<?php  
		  		if(!empty($report)){
		  			foreach ($report as $key => $value) {?>
		  				<tr>
		  					<td><?= ($value->receipt_no) ? $value->receipt_no : '-'; ?></td>
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
		  					<td><?= ($value->member) ? $value->member : '-'; ?></td>
		  					<td><?= ($value->subscriber_ticket_no) ? $value->subscriber_ticket_no : '-'; ?></td>
		  					<td><?= ($value->instalment_no) ? $value->instalment_no : '-'; ?></td>
		  					<td><?= ($value->instalment_month) ? $value->instalment_month : '-'; ?></td>
		  					<td>
		  						<?php 
		  							if($value->due_date){
				  						$FrozenDateObj = new FrozenDate($value->due_date); 
				          				echo $FrozenDateObj->i18nFormat('MM/dd/yyyy'); 
		  							}else{
		  								echo '-';
		  							}
		  						?>
		  					</td>
		  					<td><?= ($value->subscription_amount) ? $value->subscription_amount : '-'; ?></td>
		  					<td><?= ($value->late_fee) ? $value->late_fee : '-'; ?></td>
		  					<td><?= ($value->total_amount) ? $value->total_amount : '-'; ?></td>
		  					<td><?= ($value->receivedby) ? $value->receivedby : '-'; ?></td>
		  					<td><?= ($value->remark) ? $value->remark : '-'; ?></td>
		  				</tr>	
		  			<?php }
		  		}else{ ?>
		  			<tr><td colspan="13"><center>Records not found!!!</center></td></tr>
		  		<?php }
				?>
		  	</tbody>
		</table>
	</div>
</body>
</html> 

<?php //echo $this->Html->link(__('Download PDF'), ['action' => 'pdf', $report->id ]) ?>
