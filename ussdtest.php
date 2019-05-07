<?php


        #We obtain the data which is contained in the post url on our server.
        $text=       $_GET['USSD_STRING'];
        $phonenumber=$_GET['MSISDN'];
        $serviceCode=$_GET['serviceCode'];



$level1=0;

        $level = explode("*", $text);        

            $level1=count($level);

//shared database for tranfering funds across the banking systems

            $con = mysqli_connect("localhost", "root", "", "sharedresource_db");

        if($con=== false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}




//database for client company

        $conn = mysqli_connect("localhost", "root", "", "ussdtest");

        if($conn=== false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}


    if(isset($text))
    {

if($text=="")
{

      $sql= " SELECT  mobile_no FROM user_info WHERE mobile_no=$phonenumber ";

   $result=mysqli_query($conn,$sql);  
    //$row = mysqli_fetch_row($result);
   $row=mysqli_fetch_array($result);
   
   if($phonenumber!=$row[0])
   {
echo  " Hi,welcome to daystar banking system.</br>
    1. Open account ";

  

   }
   else
   {

    $sql= " SELECT  firstname FROM user_info WHERE mobile_no=$phonenumber ";

   $result=mysqli_query($conn,$sql);  
    //$row = mysqli_fetch_row($result);
   $row=mysqli_fetch_array($result);

 echo "    Hi,".$row[0].  "  ,welcome to daystar M -banking system.</br>
     Please enter your four digit pin ";  


      }

}


  choose ();  

    }



//sdfghjk
    function choose()
    {

        global $level,$phonenumber,$conn;
 $sql= " SELECT  mobile_no FROM user_info WHERE mobile_no=$phonenumber ";

   $result=mysqli_query($conn,$sql);  
    //$row = mysqli_fetch_row($result);
   $row=mysqli_fetch_array($result);
       if($phonenumber!=$row[0])
       {
        optionone ();       
       }       
 
       
       else 
       {
        optionthree();
       }



    }


// functio  to 
    function optionone ()
    {

global $level,$phonenumber,$conn;

 $sql= " SELECT  mobile_no FROM user_info WHERE mobile_no=$phonenumber ";

   $result=mysqli_query($conn,$sql);  
    //$row = mysqli_fetch_row($result);
   $row=mysqli_fetch_array($result);

if(isset($level[0]) && $level[0]!="" && !isset($level[1]) && $phonenumber!=$row[0])
{
      switch ($level[0])
{

    case 1: 
    //openaccount ();
    //echo " daudi ";

    echo" Please enter your first name";
    break;
         
    // The response user gets when one does not exist in the system
    default:
    echo"Please choose either 1 ";
}    

}
else if(isset($level[1]) && $level[1]!="" && !isset($level[2]))
{
echo"Please enter your national id no";
}else if(isset($level[2]) && $level[2]!="" && !isset($level[3] ))
{
    echo"Please enter your preffered four digit password";
}
else if(isset($level[3]) && $level[3]!="" && !isset($level[4]))
{
    echo"Please enter your gender";
}
else if(isset($level[4]) && $level[4]!="" && !isset($level[5]))
{

echo "Please confirm that this are your details,<br/>firstname - $level[1] <br/>
national_id- $level[2]<br/>password- $level[3]<br/>
gender- $level[4]

<br/> 
1. Correct <br/>
2. Incorrect";

$firstname=$level[1];
$national_id=$level[2];
$password=$level[3];
$gender=$level[4];
echo $firstname ;

}
else if(isset($level[5]) && $level[5]!="" && !isset($level[6]))
{

    if($level[4]!='F')
    {
        $gend='Mr.';
    }
    else{

        $gend='Mrs.';
    }
switch ($level[5])
{

    case 1:
    echo  "hello    " .$gend. " " .$level[1]. ",your account has been successfully created.<br/>
    Your phonenumber will act as your ac no <br/>
    Please log out of this session to login to your account";
    insert ();
    break;

    case 2:
    echo " Please log out of this session to create  your account";
    break ;

    default :
    echo "Please choose either 1 or 2";
}

}
    }

 function insert ()
    {


global $conn,$phonenumber,$level;
global $firstname,$national_id,$gender,$password;
//INSERT INTO user_info VALUES ('$firstname','$national_id','md5($password).','$gender','');
$sql="INSERT INTO user_info (firstname,nationalid,gender,mobile_no,password)
 VALUES ('$level[1]','$level[2]','$level[4]','$phonenumber','$level[3]')";
 mysqli_query($conn,$sql);


    }


    function  optionthree()
    {


global $phonenumber,$conn,$level;
        $sql1= "SELECT   password  FROM user_info WHERE mobile_no=$phonenumber";
        $result1=mysqli_query($conn,$sql1) or die(mysqli_error($conn));

   $row=mysqli_fetch_array($result1);

   if(isset($level[0]) && $level[0]!="" && !isset($level[1]) )
   {

switch ($level[0])
{
    case  $row[0] :

    mainmenu ();
    //echo"Choose your transaction<br/>
   // 1. Deposit <br/> 2. Withdraw <br/> 3. Check balance <br/> 4. Loans ";


    //mainmenu ();
    break;

    default :
    echo"Input the correct password";

}

   }
   else if(isset($level[1]) && $level[1]!="" && !isset($level[2]))
   {

 switch ($level[1])
{

    case 1:
    echo"Deposit from        <br/> 
          1. mpesa<br/>
          2. Airtel";


     //  deposit ();
    break;

    case 2:
    //withdraw ();
    echo"Please enter amount to withdraw";
    break;
 
    case 3:    
  //  checkbalance ();
    checkbalance ();
    break;

    case 4:
     echo"1. Long term loan <br/> 
       2. Short term loan";
  
    //echo"loans";
    break;

    default:
    echo "Choose again";


}


  loans ();
   }   
  else if( isset($level[2]) && $level[2]!="" && $level[1]==1 && !isset($level[3]))
   {


    switch ($level[2])
    {

        case 1:
        echo"Please enter amount to deposit from mpesa";
        break;

        case 2:
        echo"Please enter amount to deposit from Airtel";
        break;

        default:
        echo"Please choose either 1 or 2";

    }
   }

   else if(isset($level[2]) && $level[2]!="" && $level[1]==2 && !isset($level[3]))
   {

   $withdrawam= $level[2];
withdraw();
  //  echo"withdraw from here";
   }



   // code to transact the deposit
   else if(isset($level[3]) && $level[3]!="" && !isset($level[4]))
   {

  
deposit ();



    


   } 

}



  function mainmenu ()
{
    echo"Choose your transaction<br/>
    1. Deposit <br/> 2. Withdraw <br/> 3. Check balance <br/> 4. Loans";

}

function deposit()
{
global $level,$conn,$phonenumber;

 $sql="SELECT balance FROM  shared_info WHERE mobile_no=$phonenumber";
$result=mysqli_query($conn,$sql);

$row=mysqli_fetch_array($result);

$sql2="SELECT balance FROM user_info WHERE  mobile_no=$phonenumber";
$result2=mysqli_query($conn,$sql2);
$row2=mysqli_fetch_array($result2);

if($level[3]>$row[0])
{
    echo"Sorry,the transaction cannot be completed.You do not  have sufficient funds to make the transfer";
}
else if(($level[3]+$row2[0])>140000)
{
     $accepted_amount=140000-$row2[0];
    echo"Sorry,that deposit amount is too high.Plese enter an amount less than $accepted_amount ";
}
else
{


//update of balance for the banks db
    $newbalance=$row2[0]+$level[3];
$updatebalance="UPDATE user_info SET balance=$newbalance WHERE mobile_no=$phonenumber";
$update=mysqli_query($conn,$updatebalance);

//update of balance for the shared_info db
 $newbalance1=$row[0]-$level[3];
$updatebalance1="UPDATE shared_info SET balance=$newbalance1 WHERE mobile_no=$phonenumber";
$update1=mysqli_query($conn,$updatebalance1);





$sql2="SELECT balance FROM user_info WHERE  mobile_no=$phonenumber";
$result2=mysqli_query($conn,$sql2);
$row2=mysqli_fetch_array($result2);
echo"Transaction was successful,Your account balance is $row2[0]";
   // deposit ();


}
}


function withdraw()
{

global $withdrawam,$level,$conn,$phonenumber;

$sqlwithdraw="SELECT balance FROM user_info WHERE  mobile_no=$phonenumber";
$result3=mysqli_query($conn,$sqlwithdraw);
$row3=mysqli_fetch_array($result3);

$rem=$row3[0] - $level[2];


if($rem<1000)
{
  echo"Sorry.you do not have sufficient funds to withdraw the amount.";
 
}
else
{

  $sqltran="UPDATE user_info SET balance=$rem WHERE mobile_no=$phonenumber";
  $updatesqltran=mysqli_query($conn,$sqltran);


// checking balance from shared info db so as to update it 
  $sqlwithdraws="SELECT balance FROM shared_info WHERE  mobile_no=$phonenumber";
$result4=mysqli_query($conn,$sqlwithdraws);
$row4=mysqli_fetch_array($result4);

$newbal=$row4[0] + $level[2];


  $sqltran2="UPDATE shared_info SET balance=$newbal WHERE mobile_no=$phonenumber";
  $updatesqltran4=mysqli_query($conn,$sqltran2);


  echo"Transaction successful,Your new account balance is $rem";
  
}


}

function checkbalance ()
{


global $phonenumber,$conn,$level;
    $sql2="SELECT balance FROM user_info WHERE  mobile_no=$phonenumber";
$result2=mysqli_query($conn,$sql2);
$row2=mysqli_fetch_array($result2);
    echo"Your account balance is  ksh. $row2[0]";
}

function  loans()
{
  global $level,$phonenumber,$conn;
  if($level[1]=4   && isset($level[2]) && $level[2]!="" && !isset($level[3])  )
{

switch ($level[2])
{
 case 1:
 //echo"$details[1]";
 longterm ();
 break;

 case 2:
 shortterm ();
 break;

 default :



}



}

}


function loans2()
{


}

function longterm  ()
{

  echo"Please enter the amount you would like";
}
   






?>