<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Supper Out</title>
</head>

<body style='background:url("<?php echo 'http://' . $_SERVER['SERVER_NAME'].$this->request->getAttribute('webroot'); ?>files/emails/back.jpg") repeat #dddddd;background-size:160px'>
<div style="padding:15px 0;background:url('<?php echo "http://" . $_SERVER['SERVER_NAME'].$this->request->getAttribute('webroot'); ?>files/emails/back.jpg') repeat #dddddd;margin:0px auto;font-weight:400;background-size:160px">
  <div style="width: 560px;margin: auto;text-align:center;padding-top:20px;padding-bottom:20px;border-bottom:2px solid #FF6D59;background-image: url(bg-splash.png);background-size: 100%;background-repeat: no-repeat;background-position: center;border-top-left-radius:  5px;border-top-right-radius: 5px;">
      <img src="<?php echo "http://" . $_SERVER['SERVER_NAME'].$this->request->getAttribute('webroot'); ?>files/emails/logo.png" alt="img" class="CToWUd">
  </div>
    <div style="margin:0px auto;background:#fffefb;width:560px;text-align:center;overflow: hidden;box-shadow: 0 0 10px #bfbfbf;padding: 20px 0;"><b>Número do pedido: <?= h('#'.sprintf('%04d', $orderdata['order_number'])); ?></b></div>
  <table width="560" border="0" cellpadding="5" cellspacing="0" style="margin:0px auto;background:#fffefb;text-align:center;border-bottom-left-radius: 5px;overflow: hidden;box-shadow: 0 0 10px #bfbfbf;padding-top: 20px;border-bottom-right-radius: 5px;">
    <thead>
        <tr>
            <th>Nome</th>
            <th style=" width: 124px;">Quantidade</th>
            <th style="width: 124px;">Preço</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if(!empty($orderdata['order_items'])){

           foreach ($orderdata['order_items'] as $key => $value) {
          
        ?>
        <tr>
            <td><?php echo $value['menu']['name']; ?></td>  
            <td><?php echo $value['quantity']; ?></td>
            
            <td><?php
                if($value['refill']==1){
                    if($value['menu']['freeavailable']==1){
                        echo '0 (Recarga Grátis)';
                    } else{
                        echo '$'.$value['quantity'] * $value['menu']['price'].' (Reenchimento pago)';
                    }
                }else{
                    echo '$'.$value['quantity'] * $value['menu']['price'];
                }
                 ?>
            </td>
        </tr>
        <?php 
         } 
        }
         ?>

        <tr>
            <td colspan="3" style="text-align: right;">Subtotal</td>
            <td>$<?php echo $orderdata['subtotal']; ?></td>
        </tr>
        <tr>
            <td colspan="3" style="text-align: right;">Desconto</td>
            <td>$<?php echo $orderdata['orderdiscount']; ?></td>
        </tr>
        <tr>
            <td colspan="3" style="text-align: right;">Gratificação</td>
            <td>$<?php echo $orderdata['gratuity']; ?></td>
        </tr>
        <tr>
            <td colspan="3" style="text-align: right;">Imposto</td>
            <td>$<?php echo $orderdata['tax']; ?></td>
        </tr>
        <tr>
            <td colspan="3" style="text-align: right;">Total</td>
            <td>$<?php echo $orderdata['totalamount']; ?></td>
        </tr>
        <tr>
            <td colspan="4"><p style="margin:0px;">&nbsp;</p></td>
        </tr>
        <tr>
            <td align="center" colspan="4" style="border-top: 1px solid #ececec;"><p style="color:#000;font-weight:500">Thank You,<br><b>Supper Out</b>
                <br/>
                Nome do restaurante: <?php echo $orderdata['restaurant']['name']; ?>
                </p>
            </td>
        </tr>
    </tbody>
</table>
</div>
</body>
</html>