<?php
namespace DAO;


interface IFunctionDAO
{    
  
    public function Add($newFunction);
    public function chekExistence ($movieId,$date);
    public function getAll();
    public function getAuditorium($id);
    public function delete($id);
    public function retrieveData();
    public function GetJsonFilePath();
}
?>