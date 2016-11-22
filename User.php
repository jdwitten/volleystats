<php?

class User
{
	private $first_name;
	private $last_name;
	private $user_name;
	private $user_id;
	private $password;
	private $email;

	//Constructor 
	public function __construct($fname, $lname, $uname, $pass, $uid, $email)
	{
		$this->first_name = $fname;
		$this->last_name = $lname;
		$this->user_name = $uname;
		$this->password = $pass;
		$this->user_id = $uid;
		$this->email = $email;
	}

	//Getters for the user class

	public function getFirstName(){return $this->first_name;}
	public function getLastName(){return $this-> last_name;}
	public function getUserName(){return $this-> user_name;}
	public function getUserId(){return $this-> user_id;}
	public function getPassword(){return $this-> password;}
	public function getEmail(){return $this-> email;}

	public function getUserJSON()
	{
		$user = array("first_name"=>$this->first_name, "last_name"=>$this->last_name, 
					  "user_name"=>$this->user_name, "password"=>$this->password, 
					  "user_id"=>$this->user_id,"email"=>$this->email);

		return json_encode($user);
	}


}




?>