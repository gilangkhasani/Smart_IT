<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class myprint extends CI_Controller{
 
 public function __construct()
 {
   parent::__construct();
   $this->load->model('m_sb_mutasi');
 }
 
public function index()
{
   $this->load->view('myindex');
}
/////////////////////////////////////////////////////////
private function _gen_pdf($html,$paper='A4')
{
 ob_end_clean();
 $CI =& get_instance();
 $CI->load->library('MPDF56/mpdf');
 $mpdf=new mPDF();
 $mpdf->AddPage('L', // L - landscape, P - portrait
            '', '', '', '',
            5, // margin_left
            5, // margin right
            5, // margin top
            5, // margin bottom
            18, // margin header
            12); // margin footer
 $mpdf->debug = true;
 $mpdf->WriteHTML($html);
 $mpdf->Output();
 }
/////////////////////////////////////////////////////////
public function doprint($pdf=false)
{
 $data['tes'] = 'ini print dari HTML ke PDF';
 $data['profil'] = $this->m_sb_mutasi->get_profile();
 $output = $this->load->view('page_prints',$data, true);
 return $this->_gen_pdf($output);
}
}
?>