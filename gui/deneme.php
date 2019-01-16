<?php
ini_set('display_errors', 1);
$string='<?xml version="1.0" encoding="utf-8"?>
<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
  <soap:Body>
    <DivideResponse xmlns="http://tempuri.org/">
      <DivideResult>int</DivideResult>
    </DivideResponse>
  </soap:Body>
</soap:Envelope>';

$your_xml_response = $string;
$clean_xml = str_ireplace(['SOAP-ENV:', 'soap:'], '', $your_xml_response);
$xml = simplexml_load_string($clean_xml);


print_r($xml);