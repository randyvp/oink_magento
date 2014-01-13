<?php
/**
 * @package VirtualPiggy.Services.Implementations
 */
class MerchantPaymentServiceConfiguration implements IPaymentServiceConfiguration
{
    public function GetServiceConfiguration()
    {
        $config = new dtoPaymentGatewayConfiguration();
        /* ================================
        Define all variables to be used for client soap call
        ================================ */
        $config->HeaderNamespace = "vp";
        $config->propMerchantIdentifier  = "MerchantIdentifier";
        $config->propApiKey = "APIkey";
        $config->TransactionServiceEndpointAddress = "https://development.virtualpiggy.com/Services/TransactionService.svc";
        $config->TransactionServiceEndpointAddressWsdl = "https://development.virtualpiggy.com/services/TransactionService.svc?wsdl";
        $config->ParentServiceEndpointAddress = "https://development.virtualpiggy.com/services/JSON/ParentService.svc";
        $config->ParentServiceEndpointAddressWsdl = "https://development.virtualpiggy.com/services/JSON/ParentService.svc?wsdl";
        
        $config->MerchantIdentifier = "03d081e1-2d57-4c98-8f1b-bbb83d4ab14a";
        $config->APIkey  = "gadgetboom123";
        $config->Currency = "USD";
        $config->DefaultShipmentMethod = "Delivery";
        return $config;
    }
}   
?>
