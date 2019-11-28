<?php 

namespace Hcode\Model;

use \Hcode\DB\Sql;
use \Hcode\Model;
use \Hcode\Mailer;

class Topic extends Model 
{


	public static function listAll()
	{
		$sql = new Sql();

		return  $sql->select("SELECT * FROM tb_topics ORDER BY destopic");
    }
    
    public function save()
    {
        $sql = new Sql();
		
		$results = $sql->select("
		CALL sp_topics_save(:idtopic, :destopic, :desheader, :descap, :iduser, :desperson, :descompany, :desserie, :desrelease, :vltotalcompany)", 
		array(
			":idtopic"=>$this->getidtopic(),
			":destopic"=>$this->getdestopic(),
			":desheader"=>$this->getdesheader(),
			":descap"=>$this->getdescap(),
			":iduser"=>$this->getiduser(),
			":desperson"=>$this->getdesperson(),
			":descompany"=>$this->getdescompany(),
			":desserie"=>$this->getdesserie(),
			":desrelease"=>$this->getdesrelease(),
			":descompany"=>$this->getdescompany(),
			":vltotalcompany"=>$this->getvltotalcompany()
		));

		$this->setData($results[0]);

		// Topic::updateFile();

	}
	
	public function get($idtopic)
	{
		$sql = new Sql();

		$results = $sql->select("SELECT * FROM tb_topics WHERE idtopic = :idtopic", [
			":idtopic"=>$idtopic
		]);
		$this->setData($results[0]);


	}

	public function delete()
	{
		$sql = new Sql();

		$sql->query("DELETE FROM tb_topics WHERE idtopic = :idtopic", [
			":idtopic"=>$this->getidtopic()
		]);

		// Topic::updateFile();
	}
	public static function updateFile()
	{
		$categories = Topic::listAll();

		$html = [];
		foreach ($categories as $row) {
			array_push($html, '<li><a href="/categories/'. $row["idtopic"] . '">'. $row["destopic"] .'</a></li>');

		}

		file_put_contents($_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "views" . DIRECTORY_SEPARATOR . "categories-menu.html", implode('', $html));
	}

	public function  getProducts($related = true)
	{
		$sql = new Sql();

		if ($related)
		{
			return $sql->select("
			SELECT * FROM tb_products WHERE idproduct IN(
				SELECT a.idproduct
				FROM tb_products a
				INNER JOIN tb_productscategories b ON a.idproduct = b.idproduct
				WHERE b.idtopic = :idtopic
			);
			", [
				":idtopic"=>$this->getidtopic()
			]);
		} 
		else
		{
			return $sql->select("
			
			SELECT * FROM tb_products WHERE idproduct NOT IN(
				SELECT a.idproduct
				FROM tb_products a
				INNER JOIN tb_productscategories b ON a.idproduct = b.idproduct
				WHERE b.idtopic = :idtopic
			);
			", [
				":idtopic"=>$this->getidtopic()
			]);
		}
	}

	public function getProductsPage($page = 1, $itemsPerPage = 3)
	{
		
		$start = ($page - 1) * $itemsPerPage;

		$sql = new Sql();
		$results = $sql->select("
		
			SELECT SQL_CALC_FOUND_ROWS *
			FROM tb_products a
			INNER JOIN tb_productscategories b ON a.idproduct = b.idproduct
			INNER JOIN tb_topics c ON c.idtopic = b.idtopic
			WHERE c.idtopic = :idtopic
			LIMIT $start, $itemsPerPage;
		
		", [
			":idtopic"=>$this->getidtopic()
		]);

		$resultTotal = $sql->select("SELECT FOUND_ROWS() AS nrtotal;");

		return [
			'data'=>Product::checkList($results),
			'total'=>(int)$resultTotal[0]["nrtotal"],
			'pages'=>ceil($resultTotal[0]["nrtotal"] / $itemsPerPage)
		];

	}

	public function addProduct(Product $product)
	{
		$sql = new Sql();
		$sql->query("INSERT INTO tb_productscategories (idtopic, idproduct) VALUES(:idtopic, :idproduct)", [	
			":idtopic"=>$this->getidtopic(),
			":idproduct"=>$product->getidproduct()
		]);
	}
	public function removeProduct(Product $product)
	{
		$sql = new Sql();
		$sql->query("DELETE FROM  tb_productscategories WHERE idtopic =  :idtopic AND idproduct = :idproduct", [	
			":idtopic"=>$this->getidtopic(),
			":idproduct"=>$product->getidproduct()
		]);
	}

	public static function getPage($page = 1, $itemsPerPage = 10)
	{
		
		$start = ($page - 1) * $itemsPerPage;

		$sql = new Sql();
		$results = $sql->select("
		
			SELECT SQL_CALC_FOUND_ROWS *
			FROM tb_topics  
			ORDER BY idtopic DESC
			LIMIT $start, $itemsPerPage;
		");

		$resultTotal = $sql->select("SELECT FOUND_ROWS() AS nrtotal;");

		return [
			'data'=>$results,
			'total'=>(int)$resultTotal[0]["nrtotal"],
			'pages'=>ceil($resultTotal[0]["nrtotal"] / $itemsPerPage)
		];

	}
	public static function getPageSearch($search, $page = 1, $itemsPerPage = 10) // LIKE = como ou mais ou menos igual
																				 //  = exatamente igual ao especificado 
	{
		
		$start = ($page - 1) * $itemsPerPage;

		$sql = new Sql();
		$results = $sql->select("
		
			SELECT SQL_CALC_FOUND_ROWS *
			FROM tb_topics 
			WHERE destopic LIKE :search  
			ORDER BY destopic
			LIMIT $start, $itemsPerPage;
		", [
			":search"=>"%".$search."%"
		]);

		$resultTotal = $sql->select("SELECT FOUND_ROWS() AS nrtotal;");

		return [
			'data'=>$results,
			'total'=>(int)$resultTotal[0]["nrtotal"],
			'pages'=>ceil($resultTotal[0]["nrtotal"] / $itemsPerPage)
		];

	}
	
}


?>