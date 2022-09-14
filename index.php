<?php
 class DataBase{
public $connection ; // string connection 
public $sql ; //sql string want to use it in database 
public function __construct($hostName,$userName,$password , $database)
{//constractor
$this->connection = mysqli_connect($hostName,$userName,$password , $database);
// echo "<pre>";
// print_r($this->connection);
// echo "</pre>";
}
public function select($table , $column){
$this->sql = "SELECT $column from `$table` ";
return $this; // return object  have a properties  and functions 
}
//======
public function delete($table ){
$this->sql = "DELETE  from `$table` ";
return $this;
}
//======
public function insert($table , $data ){
  $keys=array_keys($data);// array of keys 
  $column = implode(",",$keys);//array to string a,b,c 
  // $values = implode(",",$values); // test,testBody,imgtest,5
  //$values = array_values($data);//array of values
  $values = "";
  foreach ($data as $value ) { // valuse of data 
    $values .= " '$value', "; // 'value1','val2','val3',
  }
  //test,testBody,imgtest,5, // we want to delete , from the end 
  //$values = rtrim($values,","); // first solution
  $values = substr($values,0 , strlen($values)-2);
  // print_r($column);
  // print_r($values);
$this->sql = "INSERT  INTO   `$table` ($column) VALUES ($values) ";
return $this;
}
//======
public function update($table , $data ){
$updateKeyAndValue = "";
  foreach ($data as $key => $value ) { // valuse of data 
    $updateKeyAndValue .= " `$key` = '$value'  ,"; // 'value1','val2','val3',
  }
  //$updateKeyAndValue = rtrim($updateKeyAndValue,","); // first solution
  $updateKeyAndValue = substr($updateKeyAndValue,0 , strlen($updateKeyAndValue)-2);

$this->sql = " UPDATE  `$table` SET  $updateKeyAndValue";
return $this;
}
//======

public function where($column , $opreator , $value){
    $this->sql .= " WHERE `$column` $opreator '$value'  ";
    return $this;
    }
//======
public function andWhere($column , $opreator , $value){
    $this->sql .= " AND `$column` $opreator '$value'  ";
    return $this;
    }
//======
public function orWhere($column , $opreator , $value){
    $this->sql .= " OR  `$column` $opreator '$value'  ";
    return $this;
    }
//======
public function join($join , $table ,$pkey ,$fkey ){
$this->sql .=" $join join `$table` ON $pkey = $fkey  ";
return $this;

}
//======


    //fetch_all
public function all( ){
  $result=  mysqli_fetch_all(mysqli_query($this->connection , $this->sql));
echo "<pre>";
print_r($result);
echo "</pre>";
}
//======
            //fetch_assoc
public function row( ){
  $result=  mysqli_fetch_assoc(mysqli_query($this->connection , $this->sql));
    echo "<pre>";
print_r($result);
echo "</pre>";
}
// =====
public function excute(){
     mysqli_query($this->connection , $this->sql);// Execute the code
     return mysqli_affected_rows($this->connection);// return 0  or one 
   

}

}
//end of the class 
//===========
$database = new DataBase('localhost','root','','eraasoftworkshop');
// $database->select("todos","*")->all();
// echo "<hr>";
// $database->select("todos","*")->where("id" ,"=" ,2)->all();
//$database->delete("todos")->where("id" ,"=" ,15)->excute();
// $database->insert("todos",["task"=>"tasktest",
// "body"=>"testBody" , 
// "img"=>"imgtest" , 
// "user_id"=>5])->all();
// $database->update("todos",
// ["task"=>"tasktest18",
// "body"=>"testBody18" , 
// "img"=>"imgtest18" ])->where("id","=",18)-> all();
$database ->select("todos","*")-> join("inner" , "user" ,"user.id","todos.user_id" )->all();



?>