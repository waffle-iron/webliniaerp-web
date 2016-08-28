<?php
        /*$ch = curl_init();
        $file = 'assets/imagens/produtos/0.jpg';
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_setopt($ch, CURLOPT_SAFE_UPLOAD, false);
        curl_setopt($ch, CURLOPT_URL, 'http://localhost/prestashop/api/images/products/1');
        curl_setopt($ch, CURLOPT_POST, true);
        //curl_setopt($ch, CURLOPT_PUT, true); Pour modifier une image
        curl_setopt($ch, CURLOPT_USERPWD, '264TQ78ZW8I5VHXSW8TADMS637XZEE8P:');
        curl_setopt($ch, CURLOPT_POSTFIELDS, array('image' => new CURLFile($file) ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        var_dump($result);*/

       /* $ch = curl_init();
        $file = 'assets/imagens/produtos/0.jpg';
        
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_setopt($ch, CURLOPT_SAFE_UPLOAD, false);
        curl_setopt($ch, CURLOPT_URL, 'http://264TQ78ZW8I5VHXSW8TADMS637XZEE8P@localhost/prestashop/api/images/products/1');
        $args['image'] = $file;
        @curl_setopt($ch, CURLOPT_POSTFIELDS, array('image' => "@".realpath($file) ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);

       header("Content-type: text/xml");

        echo  $result ;*/
?>