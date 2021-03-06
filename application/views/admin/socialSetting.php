

  <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
    <br><br>
    <?php if($section=='list'){ ?>
    <div class="alert alert-dark" role="alert">
      <h5>Social Settings  <a href="<?php echo base_url();?>admin/setting/social/create" class=" btn btn-primary btn-sm float-right">Add New Social API</a></h5>
   </div>
   <?php echo $this->session->flashdata('alert');?>
   <div class="container">
     <table class="table">
       <thead class="thead-dark">
       <tr>
         <th scope="col">#</th>
         <th scope="col">Setting Name</th>
         <th scope="col">Json</th>
         <th scope="col">Created/Updated</th>
         <th scope="col">Status</th>
         <th scope="col"></th>
         <th></th>
      </tr>
      </thead>
      <tbody>
        <?php $i = 1;foreach($list as $r){ ?>
      <tr>
        <td scope="row"><?php echo $i;?></td>
        <td><?php echo $r['setting_name'];?></td>
        <td><?php echo substr($r['json_data'],0,50);?>....<a href="<?php echo base_url();?>admin/setting/social/view/<?php echo $r['id'];?>">Show</a></td>
        <td><?php echo date('d,M Y',strtotime($r['created']));?><br><?php echo date('d,M Y',strtotime($r['updated']));?></td>
        <td><?php echo getStatusName($r['status']);?></td>
        <td>
          <a href="<?php echo base_url();?>admin/setting/social/view/<?php echo $r['id'];?>" class="btn btn-primary btn-sm">View</a> |
          <a href="<?php echo base_url();?>admin/setting/social/edit/<?php echo $r['id'];?>" class="btn btn-primary btn-sm">Edit</a> |
          <a href="<?php echo base_url();?>admin/setting/social/delete/<?php echo $r['id'];?>" class="btn btn-primary btn-sm">Del</a>
        </td>
      <?php $i++;} ?>
     </tr>
   </tbody>
     </table>
   </div>
 <?php }elseif($section=='create'){ ?>
   <div class="alert alert-dark" role="alert">
     <h5>Create New Social</h5>
  </div>
  <div class="container">
  <?php echo form_open('admin/setting/social/create') ;?>
   <div class="form-group">
     <label for="exampleInputEmail1">Social Name</label>
     <input type="text" class="form-control" placeholder="Enter Social Name" name="setting_name"/>
     <small id="emailHelp" class="form-text text-muted">Use social name specific to the page layout</small>

   </div>
   <div class="form-group">
   <label for="exampleInputPassword1">JSON</label>
     <?php $array = [
                      "api_key" => "",
                      "api_secret" => "" ,
                      "api_client" => "" ,
                      "callback" => "",
                      "image" => ""
                      ];
       ?>
     <textarea class="form-control" name="json_data"><?php echo json_encode($array,true);?></textarea>
   </div>
   <div class="form-group">
   <label for="exampleInputPassword1">Status</label>
     <select class="form-control" name="status">
       <?php foreach($status as $s){ ?>
       <option value="<?php echo $s['id'];?>"><?php echo $s['status_name'];?></option>
     <?php } ?>
     </select>
   </div>

   <input type="submit" class="btn btn-primary" value="Submit" name="create" />
  <?php echo form_close() ;?>
</div>
<?php }elseif($section=='edit'){ foreach($one as $r){};?>
   <div class="alert alert-dark" role="alert">
     <h5>Edit Social Setting</h5>
  </div>
  <div class="container">
  <?php echo form_open('admin/setting/social/edit/'.$this->uri->segment(5)) ;?>
   <div class="form-group">
     <label for="exampleInputEmail1">Social Name</label>
     <input type="text" class="form-control" placeholder="Enter Frontend Name" name="setting_name" value="<?php echo $r['setting_name'];?>"/>
     <small id="emailHelp" class="form-text text-muted">Use social specific to that page layout</small>
   </div>
   <div class="form-group">
   <label for="exampleInputPassword1">JSON</label>
     <textarea class="form-control" name="json_data"><?php echo $r['json_data'];?></textarea>
   </div>
   <div class="form-group">
   <label for="exampleInputPassword1">Status</label>
     <select class="form-control" name="status">
       <?php foreach($status as $s){ ?>
       <option value="<?php echo $s['id'];?>"><?php echo $s['status_name'];?></option>
     <?php } ?>
     </select>
   </div>

   <input type="submit" class="btn btn-primary" value="Submit" name="edit" />
  <?php echo form_close() ;?>
  </div>
<?php }elseif($section=='view'){ ?>
    <div class="alert alert-dark" role="alert">
      <h5>Social Detail</h5>
   </div>
   <div class="container">
     <?php
     $json = json_encode($one[0],true);
     //echo jsonReadableHuman($json);
     echo str_replace(array("{", "}", '","'), array("{<br />&nbsp;&nbsp;&nbsp;&nbsp;", "<br />}", '",<br />&nbsp;&nbsp;&nbsp;&nbsp;"'),$json);
     ?>
   </div>
  <?php } ?>
  </main>
