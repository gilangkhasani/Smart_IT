<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sb_supplier extends CI_Controller{

	public function __construct()
	{
		parent::__construct();
		checkLogin();
		checkAdmin();
		$this->load->model('m_sb_supplier');
		$this->load->model('m_sb_login');
		$this->output->set_header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
        $this->output->set_header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        $this->output->set_header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
        $this->output->set_header('Cache-Control: post-check=0, pre-check=0', FALSE);
        $this->output->set_header('Pragma: no-cache');
	}
	
	public function index()
	{
		redirect('Sb_supplier/listing');
	}
	
	public function listing2()
	{
		$data['profil']=$this->m_sb_login->get_profil();
		$data['supplier'] = $this->m_sb_supplier->get_all_sb_supplier();
		$data['content'] = 'Sb_supplier/list_sb_supplier';
		$this->load->view('template',$data);
	}
	
	public function listing()
	{
		$this->load->library('pagination');
		
		$config['base_url'] = base_url().'index.php/sb_supplier/listing';
		$config['total_rows'] = $this->db->count_all('sb_supplier');
		$config['per_page'] = 10;  
		
		$this->pagination->initialize($config);
		
		$uri = $this->uri->segment(3);
		
		$data['supplier'] = $this->m_sb_supplier->get_all_sb_supplier_limit($config['per_page'],$uri);
		$data['content'] = 'sb_supplier/list_sb_supplier';
		$data['profil']=$this->m_sb_login->get_profil();
		$this->load->view('template',$data);
	}
	
	public function add()
	{
		$data['profil']=$this->m_sb_login->get_profil();
		$data['content'] = 'Sb_supplier/form_sb_supplier';
		$this->load->view('template',$data);
	}
	
	public function save()
	{
		$supplier_codes = $this->input->post('supplier_codes');
		$supplier_code = $this->input->post('supplier_code');
		$hasil = $this->m_sb_supplier->get_sb_supplier($supplier_code);
		
		if($hasil->supplier_code == "" || $supplier_codes != ""){
			$this->m_sb_supplier->save_sb_supplier($supplier_codes);
			redirect('Sb_supplier/listing');
		} else {
			$this->session->set_flashdata('supplier',' Kode Supplier Sudah Ada Silahkan Isi Kode Supplier yang lain !!!');
			redirect('Sb_supplier/listing');
		}
	}
	
	public function update_save()
	{
		$supplier_code = $this->input->post('supplier_codes');
		$this->m_sb_supplier->save_sb_supplier($supplier_code);
		redirect('Sb_supplier');
	}
	
	public function search_supplier()
	{
		$supplier_code = $this->input->post('supplier_code');
		$query = $this->db->query("SELECT * from sb_supplier where supplier_code = '$supplier_code'");
		$find = $query->num_rows();
		echo $find;
	}
	
	public function edit($supplier_code)
	{
		$data['profil']=$this->m_sb_login->get_profil();
		$data['supplier'] = $this->m_sb_supplier->get_sb_supplier($supplier_code);
		$data['content'] = 'Sb_supplier/form_sb_supplier';
		$this->load->view('template',$data);
	}
	
	public function delete($supplier_code)
	{
		$this->m_sb_supplier->del_sb_supplier($supplier_code);
		redirect('Sb_supplier');
	}
	
	public function get_Sb_supplier()
	{
		 if(isset($_GET['term'])){
			$negara_code = strtolower($_GET['term']);
			$this->m_sb_supplier->get_sb_suppliers($negara_code);
		}
	}
	
	public function search()
	{
		$this->db->select('*');
		$this->db->from ('sb_supplier');
		$this->db->like($this->input->post('jenis'), $this->input->post('search'));
		
		
		
		$query = $this->db->get();
		echo "<tr>
				<th>Supplier Code</th>
				<th>Supplier Name</th>
				<th>Supplier Address</th>
				<th>Negara Code</th>
				<th>NPWP</th>
				<th>No Izin TPB</th>
				<th>Modify Date</th>
				<th>Modify By</th>
				<th>Edit</th>
			</tr>";
		$i = 0;
		foreach($query->result()as $row){			
			echo"<tr><td>".$row->supplier_code."</td>
				<td>".$row->supplier_name."</td>
				<td>".$row->supplier_address."</td>
				<td>".$row->negara_code."</td>
				<td>".$row->npwp."</td>
				<td>".$row->no_izin_tpb."</td>
				<td>".$row->modify_date."</td>
				<td>".$row->modify_by."</td>
				<td><a onclick=\"modalEdit('$row->supplier_code','$row->supplier_name','$row->supplier_address','$row->negara_code','$row->npwp','$row->no_izin_tpb');\" class='btn btn-primary btn-small' href='' style='height:27px; font-size:11px;' data-toggle='modal' data-target='#myModal1'>Edit</a></td>
				</tr>
				";
		$i++;
		}
	}
}	