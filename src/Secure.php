<?php
/**
 * Created by PhpStorm.
 * User: c.fowoue
 * Date: 29/05/2017
 * Time: 18:07
 *
 * NOTICE OF LICENSE
 *
 * Part of the Rinvex Country Package.
 *
 * This source file is subject to The MIT License (MIT)
 * that is bundled with this package in the LICENSE file.
 *
 * Package: Rinvex Country Package
 * License: The MIT License (MIT)
 */

namespace Cedvict\Secure;


class Secure
{
    private $publicKeyPath;
    private $privateKeyPath;
    private $publicKey;
    private $privateKey;
    private $passphrase;

    public function __construct($pbkeypath, $prkeypath)
    {
        $this->publicKeyPath = $pbkeypath;
        $this->privateKeyPath = $prkeypath;
        $this->publicKey = $this->extractPublicKey();
        $this->privateKey = $this->extractPrivateKey();
    }

    private function extractPublicKey()
    {
        $handle = fopen($this->publicKeyPath,"r");
        $pubKeyContent = fread($handle, filesize($this->publicKeyPath));
        fclose($handle);
        return openssl_get_publickey($pubKeyContent);
    }

    private function extractPrivateKey()
    {
        $handle = fopen($this->privateKeyPath,"r");
        $privKeyContent = fread($handle, filesize($this->privateKeyPath));
        fclose($handle);
        return openssl_get_privatekey($privKeyContent, $this->passphrase);
    }

    public function getPublicKey()
    {
        return $this->publicKey;
    }

    public function getPrivateKey()
    {
        return $this->privateKey;
    }

    public function encryptData($source)
    {
        openssl_public_encrypt($source, $cryptText, $this->publicKey );
        /*uses the already existing key resource*/
        return(base64_encode($cryptText));
    }


    public function decryptData($source)
    {
        /*
         * NOTE:  Here you use the returned resource value
         */
        $decoded_source = base64_decode($source);
        openssl_private_decrypt($decoded_source, $newsource, $this->privateKey);
        return($newsource);
    }

}