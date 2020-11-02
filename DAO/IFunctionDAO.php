<?php
namespace DAO;
use Models\Functions as Functions;

interface IFunctionDAO
{    
  
    public function Add($cinema, $auditoriumId, Functions $newFunction);
    public function chekExistence ($movieId,$date);
    public function getAll();
    public function getAuditorium($id);
    public function delete($id);
    public function retrieveData();

}
?>