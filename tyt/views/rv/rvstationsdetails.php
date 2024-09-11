<link rel="stylesheet" href="<?=HTTP_PATH?>public/plugins/jQueryUI/jquery-ui.css">
</head>
  <body class="hold-transition skin-yellow sidebar-mini"><div class="wrapper">
    <?php  include VIEWS_PATH.'/include/supper-header.php'; ?>
      
      <!-- Left side column. contains the logo and sidebar -->
       <?php  include VIEWS_PATH.'/include/supper-navi.php'; ?>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            IV Detail of
            <small class=""><?=$data['ivheader'][0]->iv_no?></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?=HTTP_PATH?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">IV From BMD</a></li>
            <li class="active">Add items stock <span class=""><?=$data['ivheader'][0]->iv_no?></span></li>
          </ol>
        </section>
        
        <!-- Main content -->
        <section class="content">
            <?php  include VIEWS_PATH.'/include/admin-alert.php';  ?>
            <div class="row"> 
                <div class="col-xs-12">
                    <?php $token =token::genarate(); ?>
                    <div class="box box-yellow">
                   <?php //if form header not added
                   if(count($data['ivheader'])==1){?>
                    <div class="box-body">
                        <form class="form-horizontal"  method="post" enctype="multipart/form-data">
                          <input type="hidden" name="token" value="<?=$token?>" />
                          <input type="hidden" value="<?=$data['ivheader'][0]->iv_id?>" name="iv_id" /> 
                            
                          <div class="form-group">
                                <label class="col-sm-2">Receive Category<sup class="text-red">*</sup></label>
                                <div class="col-sm-4">
                                    <select name="rv_type_id" class="select2 form-control"  <?= ($data['rv_created'])?'disabled="disabled"':''; ?> >
                                       <option></option>
                                       <?php foreach ($data['category'] as $key => $value) { ?>
                                       <option value="<?=$value->item_cat_id?>" <?= ($data['ivheader'][0]->iv_type==$value->item_cat_id)?'selected="selected"':''; ?> ><?=$value->cat_name?></option>
                                       <?php } ?>
                                   </select>
                                  </div>

                                <label class="col-sm-2">RV No<sup class="text-red">*</sup></label>
                                <div class="col-sm-4">
                                    <input type="text" name="rv_no" maxlength="100" value="<?= input::get('rv_no'); ?>"  <?= ($data['rv_created'])?'disabled="disabled"':''; ?> class=" form-control ">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2">RV Date<sup class="text-red">*</sup></label>
                                <div class="col-sm-4">
                                    <input type="text" id="rv_date" class="form-control" name="rv_date" value="<?=  input::get('rv_date')?>"  <?= ($data['rv_created'])?'disabled="disabled"':''; ?>/>
                                </div>
                             <label class="col-sm-2">IV No<sup class="text-red">*</sup></label>
                                <div class="col-sm-4">
                                    <input type="text" name="iv_no" maxlength="100" value="<?=$data['ivheader'][0]->iv_no;?>" class=" form-control "  <?= ($data['rv_created'])?'disabled="disabled"':''; ?>>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2">IV Date<sup class="text-red">*</sup></label>
                                <div class="col-sm-4">
                                    <input type="text" id="iv_date" class="form-control" name="iv_date" value="<?= $data['ivheader'][0]->iv_date;?>"  <?= ($data['rv_created'])?'disabled="disabled"':''; ?>/>
                                </div>
                             <label class="col-sm-2">IV From</label>
                                <div class="col-sm-4"> 
                                  <input type="text" name="iv_from" value="<?=$data['station'][0]->station_name?>" class="form-control"  <?= ($data['rv_created'])?'disabled="disabled"':''; ?>>
                                   
                                </div>
                            </div>

                              <?php if($data['rv_created']==false) { ?>
                            <div class="form-group">
                                <div class="col-sm-offset-9"> 
                                    <input type="submit" name="save" value="save" class="btn btn-sm btn-primary" />    
                                </div>
                            </div>  
                              <?php } ?>
                    </form> 
                    </div>
                   <?php } ?>
                  </div>

                   <div class="box box-yellow">
                    <div class="box-header">
                        <h3 class="box-title">
                          <label class="label label-primary "> IV No : <?=$data['ivheader'][0]->iv_no?></label>
                          <label class="label label-success "></label>
                        </h3> 
                        <span class="pull-right"> <h3 class="box-title"> <label class="label label-info"> Date : <?=$data['ivheader'][0]->iv_date?></label></h3></span>
                    </div> 
                    <div class="box-body no-padding">
                        <table class="table table-condensed">
                        <tr>
                        <th>No</th>
                        <th >Item</th>
                        <th class="text-right">Quantity</th>                      
                        <th>Batch NO</th>
                        <th>EXP Date</th> 
                        
                        <th width='20%' class="text-right">Action</th>
                        </tr> 
                        <?php   
                        $total= $i=0; foreach ($data['details'] as $key=>$value ) { $i++;
                
                         ?>
                          <tr>
                            <td><?=$i?></td>
                            <td><?=$value->item_name?></td>
                            <td class="text-right" ><?=$value->issue_qty.' '.$value->unit_name?></td>
                            <td><?=$value->batch_no?></td>
                            <td><?=$value->expire_date?></td>
                            
                            <td  class="text-right">
                                <?php
                                if($data['rv_created']==true) {
                                if($value->added_to_stock!=1){ ?>
                                <form class="form-horizontal" method="post" enctype="multipart/form-data">   
                                  <input type="hidden" name="add_item" value="1" />
                                  <input type="hidden" name="iv_header" value="<?=$data['ivheader'][0]->iv_id?>" />
                                  
                                  <input type="hidden" name="token" value="<?=$token?>" />
                                  <input type="hidden" name="tbl_id" value="<?=$value->tbl_id?>" />
                                  <input type="hidden" name="rv_header_id" value="<?=input::get('rv_header_id')?>">  
                                  <input type="hidden" name="item_code" value="<?=$value->item_code?>" />
                                  <input type="hidden" name="receive_qty" value="<?=$value->issue_qty?>" />
                                  <input type="hidden" name="batch_no" value="<?=$value->batch_no?>" />
                                  <input type="hidden" name="expire_date" value="<?=$value->expire_date?>" /> 
                                  <input type="submit" name="save" value="Add to stock" class="btn btn-sm btn-primary" />                                 
                                </form>
                                <?php } } ?>
                            </td>
                          </tr>
                        <?php  } ?> 
                      </table>
                    </div> 


                </div>    
            </div>
            </div>
            
            
            
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->   
      
      <?php  include VIEWS_PATH.'/include/admin-footer.php'; ?>
      <script src="<?=HTTP_PATH?>public/plugins/jQueryUI/jquery-ui.js" type="text/javascript"></script>
        <script>
                      $('.select2').select2({
            placeholder:'Select'});
           var nowTemp = new Date();
          var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);

          $('#rv_date').datepicker({
            dateFormat:'yy-mm-dd',
            maxDate: now,
            changeYear:true,
            changeMonth:true
          });

          $('#iv_date').datepicker({
            dateFormat:'yy-mm-dd',
            maxDate: now,
            changeYear:true,
            changeMonth:true
          });
         
        </script>



