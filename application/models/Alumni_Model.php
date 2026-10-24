<?php
defined('BASEPATH') or exit('No direct script access allowed');

#[AllowDynamicProperties]
class Alumni_model extends CI_Model
{
    private $table = 'tbl_alumni_tracker';

    public function get_all()
    {
        return $this->db->get($this->table)->result();
    }

    public function get($id)
    {
        return $this->db->get_where($this->table, ['ID' => $id])->row();
    }

    public function insert($data)
    {
        if ($this->db->insert($this->table, $data)) {
            $insert_id = $this->db->insert_id();
            $name = $data['FULL_NAME'] ?? ($data['NAME'] ?? 'Record ID: ' . $insert_id);
            log_audit("SAVED ALUMNI RECORD", "Name: " . $name);
            return $insert_id;
        }
        return false;
    }

    public function update($id, $data)
    {
        $this->db->where('ID', $id);
        $updated = $this->db->update($this->table, $data);
        if ($updated) {
            $name = $data['FULL_NAME'] ?? ($data['NAME'] ?? 'ID: ' . $id);
            log_audit("UPDATED ALUMNI RECORD", "Name/ID: " . $name);
        }
        return $updated;
    }

    public function delete($id)
    {
        $alumni = $this->get($id);
        $name = $alumni ? ($alumni->FULL_NAME ?? ($alumni->NAME ?? 'ID: ' . $id)) : ('ID: ' . $id);
        $this->db->where('ID', $id);
        $deleted = $this->db->delete($this->table);
        if ($deleted) {
            log_audit("DELETED ALUMNI RECORD", "Name/ID: " . $name);
        }
        return $deleted;
    }
}
