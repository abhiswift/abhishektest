<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Invoice_model extends CI_Model
{

    function generate_invoice($order_no = "")
    {
        $order_details = $this->Apimodel->getOrderDetailsByno($order_no);
        

        if(!empty($order_details))
        {
            $data['order_details'] = $order_details;
            

            if($order_details->order_type==1){
                $product_details = $this->Apimodel->fetchOrdersById($order_no);
                $data['product_details'] = $product_details;
                $html = $this->load->view('pdf-template/invoice', $data, true); 
            }else{
                $check_subs_type = $this->Apimodel->check_subscription_type($order_no);
                if(!empty($check_subs_type)){
                    $total_stock = $this->Apimodel->updateUserSubscriptionstock($check_subs_type->user_id);
                    $data['total_stock'] = $total_stock;
                    $html = $this->load->view('pdf-template/invoice_subscription_without_pay', $data, true);
                }else{
                    $subs_details = $this->Apimodel->fetchSubscribeOrderdetail($order_no);
                    $data['subs_details'] = $subs_details;
                    $html = $this->load->view('pdf-template/invoice_subscription', $data, true);
                }
            }
            
            include_once (APPPATH.'third_party/mpdf/vendor/autoload.php');

            $pdf = new \Mpdf\Mpdf();
            $pdf->AddPage();
            $pdf->WriteHTML($html);
            $pdf_url = 'uploads/invoice/invoice-'.$order_no.'.pdf';
            $content = $pdf->Output($pdf_url,'F');

            $update_data = array("invoice" => $pdf_url);
            $this->db->where("id", $order_no);
            $this->db->update("wami_order", $update_data);


            $response = array("status" => "Y", "message" => "Invoice successfully generated.");
        }
        else
        {
            $response = array("status" => "N", "message" => "Invalid Try.");
        }

        return $response;
    }
}
?>