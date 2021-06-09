<?php
session_start();
require('../class/config.php');
require('../library/pagination.php');
// error_reporting(0);

$so = $mysqli->query("select dealer.*,so.*,so.id so_id,so.transaction_date so_date,
ifnull(concat(dd.first_name,' ',dd.middle_name,' ',dd.last_name),'n/a') Mother_BOMA  from official_receipt so
inner join dealer on so.dealer = dealer.id
left  join dealer dd on dd.id = dealer.Mother_ID
where so.id = {$_GET['id']}");
// $so_details = $mysqli->query("select * from official_receipt where dealer = {$_GET['id']}");

?>
<!DOCTYPE html>

<html>

<head>

  <meta charset="utf-8">

  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <title>WERT GLOBAL BRANDS </title>

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
<div class="wrapper">
  <!-- Main content -->
  <section class="invoice">
    <!-- title row -->
     
 	  <!-- title row -->
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
	   <h3>Acknowledgement Receipt</h3>
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
		
		<?php
		$header = $so->fetch_object();
		?>
		
        <div class="col-sm-4 invoice-col">
          To
          <address>
            <strong><?=$header->first_name;?> <?=$header->last_name;?></strong><br>
            <?=$header->primary_address;?> ,<br>
            
            Mobile: <?=$header->mobile_number;?><br>
            Email: <?=$header->email_address;?>          </address>
			 Mother ID :
		<address>
            <strong><?=$header->Mother_BOMA;?> </strong><br>
           
         </address>   
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          <br>
          <b>AR ID:</b> <?=$header->so_id;?><br>
          <b>Date:</b> <?=date("m/d/Y",strtotime($header->so_date)); ?><br>
          <!--<b>Account:</b> 968-34567-->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      <!-- Table row -->
      <div class="row">
        <div class="col-xs-6 table-responsive">
          <table class="table table-striped">
            <thead>
            <tr>
              
              <th>DR #</th>
              <!-- th>HSN/SAC</th -->
              <th>Outstanding Balance</th>
              <th>Payment Applied</th>
              <th>Remaining Outstanding Balance</th>
              <th>Due Date</th>
            </tr>
            </thead>
            <tbody>
			
			<?php $si = $mysqli->query("select official_receipt_details.*,so.outstanding_balance,so.due_date,
				so.total_price - (so.dealer_discount + so.additional_discount) dgs_less_additional_discount
				from official_receipt_details 
			
				inner join so on so.id = official_receipt_details.so
				where official_receipt = {$_GET['id']}
				and so.status = 'confirmed'
				"); 
				if($si->num_rows > 0):
				while($si_d = $si->fetch_object()):
			  ?>
			  <tr>
                <td><i class="fa fa-fw fa"></i><?=$si_d->so;?></td>
                <td><i class="fa fa-fw fa"></i><?=number_format($si_d->dgs_less_additional_discount,2);?></td>
                <td><i class="fa fa-fw fa"></i><?=number_format($si_d->amount,2);?></td>
                <td><i class="fa fa-fw fa"></i><?=number_format($si_d->outstanding_balance,2);?></td>
                <td><i class="fa fa-fw fa"></i><?=$si_d->due_date;?></td>
              </tr>
              <?php
				endwhile;
				endif;
			  ?>
           
            </tbody>
          </table>
        </div>
        <!-- /.col -->
      
        <div class="col-xs-6">
          <p class="lead"><!--Amount Due 16/01/2020--></p>
          <div class="table-responsive">
            <table class="table">
              <tr>
                <th style="width:50%">Mode of payment:</th>
                <td><i class="fa fa-fw fa"></i><?=$header->mode_of_payment;?></td>
              </tr>
			  <?php if($header->mode_of_payment == 'CHECK'){?>
			  <tr>
                <th style="width:50%">Check Information:</th>
                <td><i class="fa fa-fw fa"></i><?=$header->check_date;?></td>
                <td><i class="fa fa-fw fa"></i><?=$header->check_number;?></td>
              </tr>
			  <?php
			  }?>
              <tr>
                <th style="width:50%">Total Amount:</th>
                <td><i class="fa fa-fw fa"></i>PHP <?=number_format($header->amount,2);?></td>
              </tr>
              <tr>
                <th style="width:50%">Change:</th>
                <td><i class="fa fa-fw fa"></i>PHP 0.00</td>
              </tr>
              <tr>
                <th style="width:50%">Next Due Date:</th>
				<?php
				// next due date.. 
				$next_due_date = $mysqli->query("SELECT * FROM so WHERE outstanding_balance > 0 and dealer = {$header->dealer} LIMIT 1" );
				if($next_due_date->num_rows > 0){
					$next_due_date->due_date = date("m/d/Y",strtotime($next_due_date->fetch_object()->due_date));
				}else{
					
					$next_due_date->due_date = 'N/A';
				}
				
				?>
                <td><i class="fa fa-fw fa"></i><?=$next_due_date->due_date;?></td>
				
				
              </tr>
			 
            </table>
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
