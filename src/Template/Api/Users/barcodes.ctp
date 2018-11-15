<?php
if(count($barcodes)>0){
    foreach($barcodes as $barcode){?>
Restaurant: <?php echo $barcode->restaurant->name; ?>
Table Number: <?php echo $barcode->table_number; ?>
       <img src="<?php echo $this->request->getAttribute('webroot').$barcode->barcode_image; ?>" /> <br/>
    <?php }
}
?>
