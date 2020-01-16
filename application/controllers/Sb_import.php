<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sb_import extends CI_Controller{
	
	public function __construct()
	{
		parent::__construct();
		checkLogin();
		checkAdmin();
		$this->load->model('m_sb_import');
		$this->load->model('m_sb_barang');
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
		$data['profil']=$this->m_sb_login->get_profil();
		redirect('Sb_import/listing');
	}
	
	public function listing2($jenis)
	{
		$data['profil']=$this->m_sb_login->get_profil();
		$jenis=str_replace('_', ' ', $jenis);
		$data['import'] = $this->m_sb_import->getAllImport($jenis);
		$data['content'] = 'sb_import/list_sb_import';
		$this->load->view('template',$data);
	}
	
	public function listing($jenis)
	{
		$this->load->library('pagination');
		$jenis2 = $jenis;
		$jenis=str_replace('_', ' ', $jenis);
		
		$data['jumlah'] = $this->m_sb_import->get_all_sb_import_count($jenis);
		
		$config['base_url'] = base_url().'index.php/sb_import/listing/'.$jenis2;
		$config['total_rows'] = $data['jumlah']->jumlah;
		$config['per_page'] = 10;  
		$config['uri_segment'] = 4;
		
		$this->pagination->initialize($config);
		
		$uri = $this->uri->segment(4);
		
		$data['import'] = $this->m_sb_import->get_all_sb_import_limit($jenis, $config['per_page'],$uri);
		$data['content'] = 'Sb_import/list_sb_import';
		$data['profil']=$this->m_sb_login->get_profil();
		$this->load->view('template',$data);
	}
	
	public function add()
	{
		$data['profil']=$this->m_sb_login->get_profil();
		$data['content'] = 'sb_import/form_sb_import';
		$this->load->view('template',$data);
	}
	
	public function save()
	{
		$data['profil']=$this->m_sb_login->get_profil();
		$doc_id = $this->input->post('doc_id');
		$this->m_sb_import->saveBarang($doc_id);
		$jenis_doc = $this->input->post('jenis_doc');
		$jenis_doc = str_replace(' ', '_', $jenis_doc);
		redirect('Sb_import/listing/'.$jenis_doc);
	}
	
	public function ubah_status($doc_id, $jenis_doc)
	{
		$data['profil']=$this->m_sb_login->get_profil();
		$this->db->query("update sb_doc_import_hd 
			set status='Finish' where doc_id='$doc_id'");
		redirect('Sb_import/listing/'.$jenis_doc);
	}
	
	public function finish()
	{
		$data['profil']=$this->m_sb_login->get_profil();
		
		$data = array (
			'status'	=> 'Finish',
			'no_bukti'	=> $this->input->post('no_bukti'),
			'tgl_bukti'	=> $this->input->post('tgl_bukti')
		);
		$this->db->where('doc_id',$this->input->post('doc_id'));
		$this->db->update('sb_doc_import_hd',$data);
		redirect('Sb_import/listing/'.$this->input->post('jenis_doc'));
	}
	
	public function delete($doc_id,$jenis)
	{
		$data['profil']=$this->m_sb_login->get_profil();
		$this->m_sb_import->del_sb_import($doc_id);
		redirect('Sb_import/listing/'.$jenis);
	}
	
	public function edit($jenis_doc,$doc_id)
	{
		$data['profil']=$this->m_sb_login->get_profil();
		$data['import_hd'] = $this->m_sb_import->get_sb_import_hd($doc_id);
		$data['import_dt'] = $this->m_sb_import->get_sb_import_dt($doc_id);
		$data['supplier'] = $this->m_sb_supplier->get_sb_supplier($data['import_hd']->supplier_code);
		$data['content'] = 'Sb_import/form_sb_import';
		$this->load->view('template',$data);
	}
	
	public function lihat_detail($doc_id)
	{
		$data['profil']=$this->m_sb_login->get_profil();
		$data['import_dt'] = $this->m_sb_import->get_sb_import_dt($doc_id);
		$data['content'] = 'Sb_import/list_sb_import_dt';
		$this->load->view('Sb_import/list_sb_import_dt',$data);
	}
	
	public function get_barang()
	{
		$data['profil']=$this->m_sb_login->get_profil();
		$data['barang'] = $this->m_sb_barang->get_barang_dan_saldo();
		$data['content'] = 'sb_import/list_sb_import_barang';
		$this->load->view('sb_import/list_sb_import_barang',$data);
	}
	
	public function get_supplier()
	{
		$data['profil']=$this->m_sb_login->get_profil();
		$data['supplier'] = $this->m_sb_supplier->get_all_sb_supplier();
		$data['content'] = 'sb_import/list_sb_import_supplier';
		$this->load->view('sb_import/list_sb_import_supplier',$data);
	}
	
	public function get_Sb_supplier()
	{
		 if(isset($_GET['term'])){
			$supplier_code = strtolower($_GET['term']);
			$this->m_sb_import->get_sb_supplier($supplier_code);
		}
	}
	
	public function search($jenis)
	{
		$jenis=str_replace('_', ' ', $jenis);
		
		$this->db->select('a.*, b.supplier_name, 
					(
						select count(*)
						from sb_doc_import_dt
						where doc_id=a.doc_id
					)as jumlah
		');
		$this->db->from ('sb_doc_import_hd a');
		$this->db->join ('sb_supplier b', 'a.supplier_code=b.supplier_code');
		$this->db->like('a.'.$this->input->post('jenis'), $this->input->post('search'));
		$this->db->where('a.jenis_doc', $jenis);
		$this->db->where('a.status', 'Unfinish');
		
		
		
		$query = $this->db->get();
		
		echo "<tr>
				<th>No Dokumen</th>
				<th>Tanggal Dokumen</th>
				<th>No Bukti</th>
				<th>Tanggal Bukti</th>
				<th>Supplier</th>
				<th>Valas</th>
				<th>Jumlah</th>
				<th>Status</th>
				<th>Edit</th>
				<th>Delete</th>
			</tr>";
		$i = 0;
		foreach($query->result()as $row){			
			echo"<tr><td>".$row->no_doc."</td>
				<td>".$row->tgl_doc."</td>
				<td>".$row->no_bukti."</td>
				<td>".$row->tgl_bukti."</td>
				<td>".$row->supplier_code."</td>
				<td>".$row->valas."</td>
				<td><a href='javascript:0' onClick='openWin(\" ".base_url()."index.php/Sb_import/lihat_detail/".$row->doc_id."\",\"popupdetail\",\"600\",\"500\")'>".$row->jumlah."</a></td>
				<td><a onclick=\"modalEdit('$row->doc_id');\" class='btn btn-success btn-small' style='height:27px; font-size:10px;' data-toggle='modal' data-target='#myModal1'>Finish</a></td>
				<td><a class='btn btn-primary btn-small' style='height:27px; font-size:11px;' href='".base_url()."index.php/Sb_import/edit/".$row->doc_id."'>Edit</a></td>
				<td><a class='btn btn-danger btn-small' style='height:27px; font-size:11px;' onclick='return confirm(\"Are you sure ?\")' href='".base_url()."index.php/Sb_import/delete/".$row->doc_id."'>Delete</a></td></tr>
				";
		$i++;
		}
	}
}	