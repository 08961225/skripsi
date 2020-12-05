<?php
defined('BASEPATH') or exit('No direct script access allowed');

class General_model extends CI_Model
{
    public function update($data, $where, $tabel)
    {
		$this->db->where($where);
		$update = $this->db->update($tabel, $data);
		// echo $this->db->affected_rows();
		if($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
    }
    public function delete($tabel, $where)
    {
		$this->db->where($where);
		$this->db->delete($tabel);
		// echo $this->db->affected_rows();
		if($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
    }
}
