<?php   // este documento es obsolote se ajunto info a query
require ("./../include/query.php");

function search_tutor_gen(){
    $objConecion= new only_query();
    $sql = "SELECT ID, Name, Escuela, Carrera, Semestre, Url, Tipo FROM Users_tutores Where Tipo=1";
    $res=$objConecion->searchSql_Assoc($sql);
    return $res;
}

function search_tutor_select($mat){
    $objConecion= new only_query();
    $sql = "SELECT Mat_User.ID_Materias, Users_tutores.Name, Users_tutores.ID, Users_tutores.Escuela,Users_tutores.Semestre, Users_tutores.Url, Users_tutores.Tipo FROM Mat_User,Users_tutores WHERE Mat_User.ID_Tutores=Users_tutores.ID AND Mat_User.ID_Materias=$mat;";
    $res=$objConecion->searchSql_Assoc($sql);
    return $res;
}
//search_tutor_select(2);
//$res=search_tutor_gen();

//print_r ($res);
?>
