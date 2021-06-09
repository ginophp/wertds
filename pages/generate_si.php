<?php
session_start();
require('../class/config.php');
require('../library/pagination.php');
// error_reporting(0);

$so = $mysqli->query("select dealer.*,so.*,so.transaction_date so_date,so.id so_id,
ifnull(concat(dd.first_name,' ',dd.middle_name,' ',dd.last_name),'n/a') Mother_BOMA
 from so 
inner join dealer on so.dealer = dealer.id
left  join dealer dd on dd.id = dealer.Mother_ID
where so.id = {$_GET['id']}");
$so_details = $mysqli->query("select * from so_details where SI = {$_GET['id']}");
$header = $so->fetch_object();


$MTD = $mysqli->query("select (sum(total_price) - sum(dealer_discount)) + sum(cpi) total_price  from so where dealer = '{$header->dealer}' 
and month(date(transaction_date)) = ".date("m")." and year(date(transaction_date)) = ".date("Y")." and status = 'confirmed'")->fetch_object();
$YTD = $mysqli->query("select (sum(total_price) - sum(dealer_discount)) + sum(cpi)  total_price from so 
where dealer = '{$header->dealer}' and year(date(transaction_date)) = ".date("Y")." and status = 'confirmed'")->fetch_object();

$qty =0;

?>
<!DOCTYPE html>

<html>

<head>

  <meta charset="utf-8">

  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <title>WERT PHILIPPINES</title>

  <!-- Tell the browser to be responsive to screen width -->

  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <!-- Bootstrap 3.3.7 -->

  <link rel="stylesheet" href="../components/bootstrap/dist/css/bootstrap.min.css">

  <!-- Font Awesome -->

  <link rel="stylesheet" href="../components/font-awesome/css/font-awesome.min.css">

  <!-- Ionicons -->

  <link rel="stylesheet" href="../components/Ionicons/css/ionicons.min.css">

  <!-- Theme style -->

  <link rel="stylesheet" href="..//dist/css/AdminLTE.min.css">

  

  <!-- Google Font -->

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

  

  <link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">

  
</head>
 
<body onLoad="window.print();">
<div >
  <!-- Main content -->
  <section class="invoice">
    <!-- title row -->
     
 	  <!-- title row -->
	  <div class = "divHeader">
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
            <i class="fa fa-globe"></i> WertGlobalBrand
            <small class="pull-right">Date: <?=date("m/d/Y");?></small>
          </h2>
        </div>
        <!-- /.col -->
      </div>
      <!-- info row -->
      <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
          From
          <address>
             <strong> WertGlobalBrand</strong><br>
            Unit 1 & 2 La maja rica blg<br>
            Business center Mcarthur highway <br>
			 Brgy Ligtasan, Tarlac City.
            Phone: <br>
            Email: 
           </address>
        </div>
        <!-- /.col -->
	
        <div class="col-sm-4 invoice-col">
          To
          <address>
            <strong><?=$header->first_name;?> <?=$header->last_name;?></strong><br>
			 <?=$header->primary_address;?> ,<br>
			 <strong><?=$header->level;?> </strong><br>
		</address>
		Account Number : 
		<address>
            <strong><?=$header->dealer;?> </strong><br>
           
         </address>   
		 Mother ID :
		<address>
            <strong><?=$header->Mother_BOMA;?> </strong><br>
           
         </address>   
            Mobile: <?=$header->mobile_number;?><br>
            Email: <?=$header->email_address;?>          
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          <b>Delivery Receipt #<?=$header->so_id;?></b><br>
          <br>
          <b>DR ID:</b> <?=$header->so_id;?><br>
          <b>Date:</b> <?=date("m/d/Y",strtotime($header->so_date)); ?><br>
          <b>Available Credit Limit:</b> <?=number_format($header->ending_credit_limit,2); ?><br>
          <b>Status:</b> <?=$header->status;?><br>
		  <b>Delivery Date:</b> <?=date("m/d/Y",strtotime($header->delivery_date)); ?><br>
		  <b>Due Date:</b> <?=date("m/d/Y",strtotime($header->due_date)); ?><br>
          <!--<b>Account:</b> 968-34567-->
        </div>
        <!-- /.col -->
      </div>
	  </div>
      <!-- /.row -->
      <!-- Table row -->
      <div class="row dynamic_details">
        <div class="col-xs-12 table-responsive">
          <table class="table table-striped">
            <thead>
            <tr>
              
              <th>Product</th>
              <th>Description</th>
              <!-- th>HSN/SAC</th -->
              <th>Unit Price</th>
              <th>Qty</th>
              <th>Subtotal</th>
            </tr>
            </thead>
            <tbody>
			<?php 
				
				while($r = $so_details->fetch_object()): 
				$so_details_promo_q = $mysqli->query("SELECT product.* FROM promo 
				INNER JOIN promo_details ON promo.`id` = promo_details.`promo`
				INNER JOIN product ON product.`code` = promo_details.`product`
				WHERE promo.promo_code = '{$r->promo_code}' AND promo.promo_condition = 'SET'"); 
				
				
			
				if($r->promo_code == ''){
					$r->promo_code = $r->product;
				}
				
				$so_details_promo_qq = $mysqli->query("SELECT product.code,product.description, promob1t1.qty ,
					product2.code free_item_code ,product2.description free_item_description,promob1t1.`qty_free`
					FROM promob1t1 
					INNER JOIN product ON promob1t1.product = product.`code`
					INNER JOIN product product2 ON promob1t1.`product_free` = product2.code
						WHERE promob1t1.promo_code = '{$r->promo_code}'"); 
				
				
			?>
            <tr>
              <td><?=$r->product;?></td>
              <td><?=$r->product_description;?></td>
			  <td><?=number_format($r->unit_price,2);?></td>
            
			
              
			<?php
				if($so_details_promo_q->num_rows):
				
			?>
			 <td> - </td>
			   <tr />
			<?php
				while($so_details_promo_r = $so_details_promo_q->fetch_object()):
				
			  ?>
			  
					  <tr>
						 <td><?=$so_details_promo_r->code;?></td>
						 <td><?=$so_details_promo_r->description;?></td>
						 <td></td>
						 <td><?=$r->qty;?></td>
					  </tr>
              <?php 
				$qty = $qty + $r->qty;
				endwhile; ?>	
						 <td colspan = 4></td>
						 <td><?=number_format($r->sub_total,2);?></td>
				</tr>
			 
				
				
				
				<?php 
				
				
				
				elseif($so_details_promo_qq->num_rows > 0):?>
				
				<?php while($so_details_promo_r = $so_details_promo_qq->fetch_object()):
				$qty = $qty + ($so_details_promo_r->qty * $r->qty) +  ($so_details_promo_r->qty_free * $r->qty);
				
				// echo  $so_details_promo_r->qty_free." * ".$r->qty;
				// die('x');
			  ?>
			  <td> - </td>
			   <tr />
					  <tr>
						 <td><?=$so_details_promo_r->code;?></td>
						 <td><?=$so_details_promo_r->description;?></td>
						 <td></td>
						 <td><?=($so_details_promo_r->qty * $r->qty);?></td>
					  </tr>
					  <tr>
						 <td><?=$so_details_promo_r->free_item_code;?></td>
						 <td><?=$so_details_promo_r->free_item_description;?></td>
						 <td>FREE</td>
						 <td><?=($so_details_promo_r->qty_free * $r->qty);?></td>
					  </tr>
              <?php 
				// echo $qty."<br/>";
				// $qty +=$r->qty;
				endwhile; ?>
				<tr>
						 <td colspan = 4></td>
						 <td><?=number_format($r->sub_total,2);?></td>
				</tr>
				
				
				
				 <?php 
				else:
				$qty += $r->qty;
				if($r->sub_total==''){
					$r->sub_total=0;
				}
				?>
					  <td><?=$r->qty;?></td>
					  
					<td><?=number_format($r->sub_total,2);?></td>
				</tr>
				<?php endif;?>
			  
            <?php endwhile;?>
			<tr>
			<td></td>
			<td></td>
			<td></td>
			<td><?=$qty;?></td>
			<td></td>
			</tr>
           
            </tbody>
          </table>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      
      
      <div class="row">
       
        <!-- /.col -->
        <div class="col-xs-6">
          <p class="lead">Due Dates:</p>
          <div class="table-responsive">
            <table class="table">
              <tr>
                <th>Order IDs</th>
                <th>Amount</th>
                <th>Due Date</th>
              </tr>
              
			  <?php
			  $si = $mysqli->query("select * from so where outstanding_balance > 0 and id != {$_GET['id']} 
			  and dealer = {$header->dealer}
			  and status = 'confirmed' limit 5"); 
			  
			  $parameter_last_due=date("Y-m-d");
			  $parameter_id=0;
				if($si->num_rows > 0):
				while($si_d = $si->fetch_object()):
			  ?>
			  <tr>
                <td><i class="fa fa-fw fa"></i><?=$si_d->id;?></td>
                <td><i class="fa fa-fw fa"></i>PHP <?=number_format($si_d->outstanding_balance,2);?></td>
                <td><i class="fa fa-fw fa"></i><?=date("m/d/Y",strtotime($si_d->due_date));?></td>
              </tr>
              <?php
				$parameter_last_due = $si_d->due_date;
				$parameter_id = $si_d->id;
				endwhile;
				endif;
			  ?>
			  <?php
			   $next_sum_due_date = $mysqli->query("SELECT IFNULL(CONCAT('DUE ON ".date('m/d/Y',strtotime($parameter_last_due))." ONWARDS    ',FORMAT(SUM(outstanding_balance),2)),'')
							next_sum_due_date
							FROM so WHERE outstanding_balance > 0 AND
							dealer = {$header->dealer} AND id != {$parameter_id} AND 
							due_date > '{$parameter_last_due}'")->fetch_object()->next_sum_due_date; 
			  
			  ?>
			  <tr align =  "center" >
                <td colspan = '100'><h4><?=$next_sum_due_date;?></h4></td>
                
              </tr>
            </table>
          </div>
        </div>
		
		 <p class="lead"><!--Amount Due 16/01/2020--></p>
          <div class="table-responsive">
            <table class="table">
              <tr>
                <th style="width:50%">Subtotal:</th>
                <td><i class="fa fa-fw fa"></i>PHP <?=number_format($header->total_price ,2);?></td>
              </tr>
              <tr>
                <th style="width:50%">CPI:</th>
                <td><i class="fa fa-fw fa"></i>PHP <?=number_format($header->cpi ,2);?></td>
              </tr>
             
              <tr>
                <th>Dealer Discount:</th>
                <td><i class="fa fa-fw fa"></i>PHP  <?=number_format(($header->dealer_discount) ,2);?></td>
              </tr>
			  
              <tr>
                <th>Total DGS:</th>
                <td><i class="fa fa-fw fa"></i>PHP  <?=number_format(($header->total_price - $header->dealer_discount) ,2);?></td>
              </tr>
              <tr>
                <th>Additional  Discount:</th>
                <td><i class="fa fa-fw fa"></i>PHP  <?=number_format(($header->additional_discount) ,2);?></td>
              </tr>
			  <tr>
                <th>Total Invoice amount:</th>
				<?php 
					$net_amount = $header->total_price - ($header->dealer_discount + $header->additional_discount);
				?>
                <td><i class="fa fa-fw fa"></i>PHP  <?=number_format($net_amount,2);?></td>
              </tr>
			   <tr>
                <th style="width:50%">VAT:</th>
                <td><i class="fa fa-fw fa"></i>PHP <?=number_format($header->vat,2);?></td>
              </tr>
			  <tr>
                <th>MTD DGS SALES:</th>
               <td><i class="fa fa-fw fa"></i>PHP  <?=number_format($MTD->total_price,2);?></td>
              </tr>
			  <tr>
                <th>YTD DGS SALES:</th>
               <td><i class="fa fa-fw fa"></i>PHP  <?=number_format($YTD->total_price,2);?></td>
              </tr>
            </table>
          </div>
		  
		   <!-- /.col -->
        <div class="col-xs-12 divFooter">
          <div class="table-responsive">
            <table class="table">
              <tr>
                <th>Received By:</th>
               <td><i class="fa fa-fw fa"></i><?=$header->first_name;?> <?=$header->last_name;?></td>
			    <th>Process by:</th>
               <td><i class="fa fa-fw fa"></i>username : <?=$_SESSION['username'];?></td>
			   <th>Check by:</th>
               <td><i class="fa fa-fw fa"></i></td>
              </tr>
            </table>
          </div>
        </div>
		  
		  
        </div>
		
        <!-- /.col -->
      </div>
      <!-- /.row -->
      
       
      <div class="row">
      <!-- div class="col-md-12 col-xs-12">
      All subject to jaipur jurisdiction
      </div -->
      </div>
      <br />
     
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->
</body>
 
</html>
<style>
@media print {
    html, body {
        display: block; 
        font-family: "Calibri";
        margin: 0;
		
    }
	
	/*
	  div.divFooter {
		position: fixed;
		bottom: 0;
	  }
	*/
	 
   
	 @page {
      size: 24.13cm 24.13cm;

        margin: 250mm;
        margin-right: 450mm;
    }
	
}
</style>