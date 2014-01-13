<?php
/**
 * @category    VirtualPiggy
 * @package     VirtualPiggy_VirtualPiggy
 */
class VirtualPiggy_VirtualPiggy_Model_User_Parent
        extends VirtualPiggy_VirtualPiggy_Model_User
{

    protected $_token;
    protected $_address;
    protected $_childrens;
    protected $_paymentMethods;
    protected $_selectedChildren;
    
    /**
     * Get address from Virtual Piggy
     * 
     * @return dtoAddress
     */
    public function getAddressDto(){
        $paymentService = $this->_getHelper()->getVirtualPiggyPaymentService();
        return $paymentService->GetParentAddress($this->_token);
    }
    /*
     * @return array
     */
    public function getChildrens(){
        if(is_null($this->_childrens)){
            $paymentService = Mage::helper("virtualpiggy")->getVirtualPiggyPaymentService();
            $_childrens=$paymentService->GetAllChildren($this->getToken());
            $childrens=array();
            foreach ($_childrens as $_children) {
                $children=Mage::getModel("virtualpiggy/user_children");
                $children->setChildrenIdentifier($_children->Token);
                $children->setName($_children->Name);
                $childrens[]=$children;
            }
            $this->_childrens=$childrens;
        }
        if(count($this->_childrens)<1){
            Mage::throwException("parent_configuration");
        }
        return $this->_childrens;
    }
    
    /*
     * @return VirtualPiggy_VirtualPiggy_Model_User_Children
     */
    public function getSelectedChildren(){
        if(is_null($this->_selectedChildren)){
            $selectedChildrenIdentifier=$this->getData("selected_children");
            foreach ($this->getChildrens() as $children) {
                if($children->getChildrenIdentifier()==$selectedChildrenIdentifier){
                    $this->_selectedChildren=$children;
                    break;
                }
            }
        }
        return $this->_selectedChildren;
    }
    
    /**
     * Get address from Virtual Piggy selected children and change it to magento format
     * 
     * @return Varien_Object
     */
    public function getSelectedChildrenAddress(){
        $addressDto=$this->getSelectedChildrenAddressDto();
        return $this->getAddress($addressDto);
    }
    
    /**
     * Get address from Virtual Piggy selected children and change it to magento format
     * 
     * @return dtoAddress
     */
    public function getSelectedChildrenAddressDto(){
        $selectedChildren=$this->getSelectedChildren();
        $paymentService = Mage::helper("virtualpiggy")->getVirtualPiggyPaymentService();
        $addressDto=$paymentService->getParentChildAddress($this->getToken(),$selectedChildren->getChildrenIdentifier());
        return $addressDto;
    }
    
    
    /*
     * @return array
     */
    public function getPaymentMethods(){
        if(is_null($this->_paymentMethods)){
            $paymentService = Mage::helper("virtualpiggy")->getVirtualPiggyPaymentService();
            $_paymentMethods=$paymentService->GetPaymentAccounts($this->getToken());
            $paymentMethods=array();
            foreach ($_paymentMethods as $_paymentMethod) {
                $paymentMethod=new Varien_Object(array(
                    "token"=>$_paymentMethod->Token,
                    "name"=>$_paymentMethod->Name,
                    "url"=>$_paymentMethod->Url,
                    "type"=>$_paymentMethod->Type,
                ));
                $paymentMethods[]=$paymentMethod;
            }
            $this->_paymentMethods=$paymentMethods;
        }
        if(count($this->_paymentMethods)<1){
            Mage::throwException("parent_configuration");
        }
        return $this->_paymentMethods;
    }

}

?>
