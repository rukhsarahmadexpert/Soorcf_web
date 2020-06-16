<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-bar-chart"></i> Item Category Management
        <small>Add, Edit, Delete</small>
      </h1>
    </section>
    <section class="content">
        <?php if(isset($this->session->userdata['myfinal']['item_category_listing']['p_add']) && $this->session->userdata['myfinal']['item_category_listing']['p_add']==1 || $this->session->userdata['role']==1) { ?>
        <div class="row">
            <div class="col-xs-12 text-right">
                <div class="form-group">
                    <a class="btn btn-primary" href="<?php echo base_url(); ?>add_new_item_category"><i class="fa fa-plus"></i> Add New</a>
                </div>
            </div>
        </div>
        <?php } ?>
        <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Item Category List</h3>
                    <div class="box-tools">
                        <form action="<?php echo base_url() ?>item_category_listing" method="POST" id="searchList">
                            <div class="input-group">
                              <input type="text" name="searchText" value="<?php echo $searchText; ?>" class="form-control input-sm pull-right" style="width: 150px;" placeholder="Search" />
                              <div class="input-group-btn">
                                <button class="btn btn-sm btn-default searchList"><i class="fa fa-search"></i></button>
                              </div>
                            </div>
                        </form>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover">
                    <tr>
                        <th>Category Name</th>
                        <th class="text-center">Actions</th>
                    </tr>
                    <?php
                    if(!empty($servicesRecords))
                    {
                        foreach($servicesRecords as $record)
                        {
                            //echo "<pre>";print_r($record);die;
                    ?>
                    <tr>
                        <td><?php echo $record->item_category_name ?></td>
                        <td class="text-center">
                            
                            <?php if(isset($this->session->userdata['myfinal']['item_category_listing']['p_update']) && $this->session->userdata['myfinal']['item_category_listing']['p_update']==1 || $this->session->userdata['role']==1) { ?>
                            <a class="btn btn-sm btn-info" href="<?php echo base_url().'edit_item_category/'.$record->item_category_id; ?>" title="Edit"><i class="fa fa-pencil"></i></a>
                            <?php } ?>

                            <?php if(isset($this->session->userdata['myfinal']['item_category_listing']['p_delete']) && $this->session->userdata['myfinal']['item_category_listing']['p_delete']==1 || $this->session->userdata['role']==1) { ?>
                            <a class="btn btn-sm btn-danger deleteServices" href="<?php echo base_url().'delete_item_category/'.$record->item_category_id; ?>" title="Delete" onclick="return confirm('Are you sure you want to delete this record?');"><i class="fa fa-trash"></i></a>
                            <?php } ?>

                        </td>
                    </tr>
                    <?php
                        }
                    }
                    else{ ?>
                        <td><?php echo "no recodrs found"; ?></td>
                    <?php
                    }
                    ?>
                  </table>
                  
                </div><!-- /.box-body -->
                <div class="box-footer clearfix">
                    <?php echo $this->pagination->create_links(); ?>
                </div>
              </div><!-- /.box -->
            </div>
        </div>
    </section>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('ul.pagination li a').click(function (e) {
            e.preventDefault();            
            var link = jQuery(this).get(0).href;            
            var value = link.substring(link.lastIndexOf('/') + 1);
            jQuery("#searchList").attr("action", baseURL + "item_category_listing/" + value);
            jQuery("#searchList").submit();
        });
    });
</script>
