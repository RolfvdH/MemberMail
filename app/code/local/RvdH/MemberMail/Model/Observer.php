<?php

class RvdH_MemberMail_Model_Observer
{

	public function sendMemberMail()
	{
        $datePlusMonth = date ("Y-m-d", strtotime("+2 months"));
        $datePlusMonthDutch = date("d-m-Y", strtotime($datePlusMonth));

        $collection = Mage::getModel("customer/customer")
            ->getCollection()->addAttributeToSelect("*")
            ->addFieldToFilter('membermail_date', array('like' => $datePlusMonth.'%'));

        
        $body .= '<table>
                    <tr>
                        <th>'.Mage::helper('membermail')->__('Customer Number').'</th>
                        <th>'.__('Name').'</th>
                        <th>'.Mage::helper('core')->__('Email').'</th>
                        <th>'.Mage::helper('core')->__('Telephone').'</th>
                    </tr>';

        foreach($collection as $customer)
        {   
            $body .= '<tr>';
            $body .= '<td>'.$customer->getId().'</td>';
            $body .= '<td>'.$customer->getFirstname().' '.$customer->getMiddlename().' '.$customer->getLastname().'</td>';
            $body .= '<td>'.$customer->getEmail().'</td>';
            $body .= '<td>'.$customer->getPrimaryBillingAddress()->getTelephone().'</td>';
            $body .= '</tr>';
        }

        $body .= "</table>";

		$mail = Mage::getModel('core/email')
     ->setToEmail('rolf@ceesvanderhorst.nl')
     ->setBody('Deze maand verlopen de volgende lidmaatschappen:<br/><br/>'. $body)
     ->setSubject('Te verlopen lidmaatschappen per '.$datePlusMonthDutch)
     ->setFromEmail('no-reply@materiaalservice.nl')
     ->setFromName('Materiaalservice Admin')
     ->setType('html');
     
    $mail->send();

	}
}