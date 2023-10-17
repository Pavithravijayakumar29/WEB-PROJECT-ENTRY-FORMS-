<div class="table-responsive">
    <table class="table table-hover" id="tableExport" style="width:100%;">
    <thead>
        <tr>
            <th>Sno</th>
            <th>Stock Entry Date</th>
            <th>Stock Number</th>
            <th>Dealer Name</th>
            <!-- <th>Opening Stock</th>
            <th>Closing Stock</th> -->
            <th class="text-center">Status</th>
            <?php if(($user_rights_edit_1==1) || ($user_rights_delete_1==1)){ ?>
                <th class="text-center">Action</th>
            <?php } ?>
        </tr>

    </thead>
    <tbody>
    <?php
    $i1=1;
    foreach($sales_order_stock_main as $sales_order_stock_main1)
    {
        ?>
    <tr>
        <td><?php echo $i1;$i1++; ?></td>
        <td><?php echo $sales_order_stock_main1['entry_date']; ?></td>
        <td><?php echo $sales_order_stock_main1['order_no']; ?></td>
        <td><?php echo $sales_order_stock_main1['dealer_name']; ?></td>
        <td align="center"><?php if($sales_order_stock_main1['status']=="1"){ ?><div class="badge badge-success">Active</div><?php }else{ ?><div class="badge badge-warning">In Active</div><?php } ?></td>
        <?php if(($user_rights_edit_1==1) || ($user_rights_delete_1==1)){ ?>
        <td align="center">
        <?php if($user_rights_edit_1==1){ ?>
        <a class="btn btn-icon icon-left btn-info hover-gradient" data-toggle="tooltip" style="cursor: pointer"  title="Edit" onclick="open_model('Update Party Opening Stock Entry','<?php echo $sales_order_stock_main1['id']; ?>')"><i class="far fa-edit"></i>Edit</a>
        <?php } ?>
        <?php if($user_rights_delete_1==1){ ?>
        <a class="btn btn-icon icon-left btn-danger" data-toggle="tooltip" style="cursor: pointer" title="Delete" onclick="delete_row('<?php echo $sales_order_stock_main1['id']; ?>')"><i class="fas fa-trash"></i>Delete</a>
        <?php } ?>
        </td>
        <?php } ?>
    </tr>
    <?php } ?>
    </tbody>
    </table>
</div>
<script>
$(function () {
    $('#tableExport').DataTable({
        "dom": 'lBfrtip',
        "buttons": [
            {
                extend: 'excel',
                text: 'Excel',
                exportOptions: {
                    columns: [0, 1, 2,3,4,5,6,7,8]
                }
            },
            {
                extend: 'pdf',
                text: 'PDF',
                //text: '<i class="far fa-file-pdf"></i>',
                exportOptions: {
                    columns: [0, 1, 2,3,4,5,6,7,8]
                }
            },
            {
                extend: 'print',
                text: 'Print',
                exportOptions: {
                    columns: [0, 1, 2,3,4,5,6,7,8]
                }
            }
        ]
    });
});
</script>
