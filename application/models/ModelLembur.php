<?php

class ModelLembur extends CI_model
{

	public function get_data()
	{
		$id = $this->session->userdata('nik');
		$date = date("Y-m-d");
		$this->db->where("nik", $id);
		$this->db->where("tanggal", $date);
		$result = $this->db->get("lembur");
		if ($result->num_rows() > 0) {
			return $result->row();
		} else {
			return FALSE;
		}
	}

	public function insert_data($data, $table)
	{
		// Insert attendance record
		$this->db->insert($table, $data);

		// Update total_absen in rekap_absen table
		//   $this->updateRekapAbsen($data['nik'], $data['status_absen']);

		$this->db->trans_complete(); // End transaction

		return $this->db->trans_status(); // Return transaction status


		// return $this->db->insert($table, $data);
	}
	public function updateRekapAbsen($id)
	{
		$date = date("mY");
		
		$lembur = $this->db->get_where('lembur', array('id' => $id))->row();

		$waktu_mulai = new DateTime($lembur->waktu);
		$waktu_selesai = new DateTime($lembur->waktu_pulang);
		
		$durasi_lembur = $waktu_mulai->diff($waktu_selesai);
		$rounded_hours = round($durasi_lembur->h + $durasi_lembur->i / 60 + $durasi_lembur->s / 3600);		

		$existingRecord = $this->db->get_where('data_kehadiran', array('nik' => $lembur->nik, 'bulan' => $date))->row();
		if ($existingRecord) {
 			$this->db->where(array('nik' => $lembur->nik, 'bulan' => $date));
			 $this->db->set('lembur', $existingRecord->lembur + $rounded_hours);
			 $this->db->update('data_kehadiran');
		}
	}


	public function update_data($table, $data, $whare)
	{
		$this->db->update($table, $data, $whare);
	}

	public function delete_data($whare, $table)
	{
		$this->db->where($whare);
		$this->db->delete($table);
	}

	public function insert_batch($table = null, $data = array())
	{
		$jumlah = count($data);
		if ($jumlah > 0) {
			$this->db->insert_batch($table, $data);
		}
	}

	public function cek_login()
	{
		$username = set_value('username');
		$password = set_value('password');

		$result = $this->db->where('username', $username)
			->where('password', md5($password))
			->limit(1)
			->get('data_pegawai');
		if ($result->num_rows() > 0) {
			return $result->row();
		} else {
			return FALSE;
		}
	}
}
