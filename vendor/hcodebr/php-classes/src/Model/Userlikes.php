<?php 

namespace Hcode\Model;

use \Hcode\DB\Sql;
use \Hcode\Model;
use \Hcode\Mailer;
use \Hcode\Model\User;

class Userlikes extends Model 
{

	const SESSION = "Userlikes";
    const SESSION_ERROR = "UserlikesError";

	public static function getFromSession()
	{


		$userlikes = new Userlikes();

        if (isset($_SESSION[Userlikes::SESSION])) 
        {

			return $_SESSION[Userlikes::SESSION];

        } 

		

	}

	public function setToSession($results)
	{

		$_SESSION[Userlikes::SESSION] = $results;

	}	

	public function get(int $iduser)
	{

		$sql = new Sql();

		$results = $sql->select("SELECT * FROM tb_userlikes WHERE iduser = :iduser", [
			':iduser'=>$iduser
		]);

		if (count($results) > 0) {

			$this->setData($results[0]);

		}

	}
	public function addLike($idtopic, Topiclikes $topiclikes)
    {
		$sql = new Sql();
		$user = User::getFromSession();

        $results = $sql->select("CALL sp_likes_save(:idtopiclikes, :iduser, :idtopic, :desnumlikes)", [
			":idtopiclikes"=>$topiclikes->getidtopiclikes(),
			":iduser"=>$user->getiduser(),
			":idtopic"=>$idtopic,
			":desnumlikes"=>$topiclikes->getdesnumlikes()+1
		]);
		
		$this->setToSession($results);

	}
	
	
}


?>