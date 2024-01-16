<?php

class ModelPresensi extends CI_model
{

	public function get_data()
	{
		$id = $this->session->userdata('nik');
		$date = date("Y-m-d");
		$this->db->where("nik", $id);
		$this->db->where("tanggal", $date);
		$result = $this->db->get("presensi");
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
	public function updateRekapAbsen($nik)
	{

		$date = date("mY");
		$existingRecord = $this->db->get_where('data_kehadiran', array('nik' => $nik, 'bulan' => $date))->row();
		if ($existingRecord) {
			// If a record exists, update total_absen by incrementing it
			$this->db->where(array('nik' => $nik, 'bulan' => $date));
			$this->db->set('hadir', 'hadir + 1', FALSE);
			$this->db->update('data_kehadiran');
		} else {
			$nama_pegawai = $this->session->userdata('nama_pegawai');
			$nama_jabatan = $this->session->userdata('nama_jabatan');
			$jenis_kelamin = $this->session->userdata('jenis_kelamin');


			$this->db->insert(
				'data_kehadiran',
				array(
					'nik' => $nik,
					'bulan' => $date,
					'hadir' => 0,
					'jenis_kelamin' => $jenis_kelamin,
					'nama_pegawai' => $nama_pegawai,
					'nama_jabatan' => $nama_jabatan
				)
			);
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
