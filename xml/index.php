<?php

	$xml = new DomDocument("1.0");
	$xml -> formatOutput = true;
	/*create element using createElement();
	append child to parent using appendChild();*/

	$books = $xml -> createElement("books");
	$xml -> appendChild($books);
		//parent -> appendChild(child)

	$book = $xml -> createElement("book");
	$book -> setAttribute("id",1);
	$books -> appendChild($book);

	$name = $xml -> createElement("name", "java");
	$book -> appendChild($name);

	$price = $xml -> createElement("price", "200");
	$book -> appendChild($price);

	$book = $xml -> createElement("book");
	$book -> setAttribute("id",2);
	$books -> appendChild($book);

	$name = $xml -> createElement("name", "PHP");
	$book -> appendChild($name);

	$price = $xml -> createElement("price", "220");
	$book -> appendChild($price);

	echo "<xmp>".$xml->saveXML()."</xmp>";  

	$xml -> save("books_report.xml") or die ("Error, Unable to create XML File");
?>