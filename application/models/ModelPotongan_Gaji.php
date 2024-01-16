<?php
Class ModelPotongan_Gaji extends CI_Model
{
  function TampilPotongan() 
    {
        $this->db->order_by('id', 'ASC');
        return $this->db->from('parameter_gaji')
          ->get()
          ->result();
    }

    function Getpotongan($potongan = '')
    {
      return $this->db->get_where('parameter_gaji', array('id' => $potongan))->row();
    }
    function HapusPotongan($potongan)
    {
         $this->db->delete('parameter_gaji',array('id' => $potongan));
    }
}