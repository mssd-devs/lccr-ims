<?php
defined('BASEPATH') or exit('No direct script access allowed');

#[AllowDynamicProperties]
class FacultyEvaluation_Model extends CI_Model
{
    private function clean($data)
    {
        return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
    }

    public function save($data = [])
    {
        $insert = [
            'instructor_name'     => $this->clean($data['instructor_name']),
            'course_title'        => $this->clean($data['course_title']),
            'class_schedule'      => $this->clean($data['class_schedule']),
            'academic_period'     => $this->clean($data['academic_period']),
            'explicit_reason'     => $this->clean($data['explicit_reason'] ?? ''),
            'implicit_reason'     => $this->clean($data['implicit_reason'] ?? ''),
            'teacher_strength'    => $this->clean($data['teacher_strength']),
            'teacher_improvement' => $this->clean($data['teacher_improvement']),
        ];

        // explicit 1–15
        for ($i = 1; $i <= 15; $i++) {
            $insert['explicit_' . $i] = $data['explicit_' . $i] ?? NULL;
        }

        // implicit 16–29
        for ($i = 16; $i <= 29; $i++) {
            $insert['implicit_' . $i] = $data['implicit_' . $i] ?? NULL;
        }

        $saved = $this->db->insert('tbl_evaluation', $insert);
        if ($saved) {
            $details = "Instructor: " . $insert['instructor_name'] . " (" . $insert['course_title'] . ")";
            log_audit("SUBMITTED FACULTY EVALUATION", $details);
        }
        return $saved;
    }

    public function get_evaluation_by_id($id)
    {
        return $this->db->get_where('tbl_evaluation', ['ID' => $id])->row();
    }
}
