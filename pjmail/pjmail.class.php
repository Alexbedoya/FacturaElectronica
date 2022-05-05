<?php
/**
 * Logiciel : PJ-MAIL
 * 
 * Envoie de mail - utilise la classe simplemail
 * Distribué sous la licence GPL.
 * 
 * @author		Laurent MINGUET <webmaster@spipu.net>
 * @version		1.2 - 13/12/2007
 */
	
if (!defined('__CLASS_PJ_MAIL__'))
{
	define('__CLASS_PJ_MAIL__', true);

	require_once(dirname(__FILE__).'\\_simplemail\\class.mail.php');
	
	class PJmail extends simplemail
	{
		var $old_sendmail_from	= null;
		var $env_name			= '';
		
		/**
		* Constructeur
		*
		* @return	null
		*/
		function PJmail()
		{
			$this->simplemail();
		}
		
		/**
		* attacher un fichier binaire en pièce jointe
		* 
		* @param	string	nom du fichier
		* @param	string	contenu binaire du fichier
		* @return	null
		*/
		function addbinattachement($filename, $source)
		{
			array_push($this->attachement , array('filename'=>$filename, 'source'=>$source));
		}
		
		function setAllFrom($email, $name)
		{
			$this->addfrom($email, $name);
			$this->returnpath	= $this->hfrom;
			$this->Xsender		= $this->hfrom;
			$this->ErrorsTo		= $this->hfrom;
			$this->old_sendmail_from = ini_set('sendmail_from', $email);
		}

		/**
		* surcharge de la fonction d'origine de simplemail afin d'include les attachements de fichier binaire
		* 
		* @param	array	tableau des attachements
		* @param	string	séparateur
		* @return	null
		*/
		function writeattachement(&$attachement,$B)
		{
			$message = '';
			if ( !empty($attachement) )
			{
				foreach($attachement as $AttmFile)
				{
					$patharray = explode ("/", $AttmFile['filename']);
					$FileName = $patharray[count($patharray)-1];
					
					$message .= "\n--".$B."\n";
					
					if (!empty($AttmFile['cid']))
					{
						$message .= "Content-Type: {$AttmFile['contenttype']};\n name=\"".$FileName."\"\n";
						$message .= "Content-Transfer-Encoding: base64\n";
						$message .= "Content-ID: <{$AttmFile['cid']}>\n";
						$message .= "Content-Disposition: inline;\n filename=\"".$FileName."\"\n\n";
					}
					else
					{
						$message .= "Content-Type: application/octetstream;\n name=\"".$FileName."\"\n";
						$message .= "Content-Transfer-Encoding: base64\n";
						$message .= "Content-Disposition: attachment;\n filename=\"".$FileName."\"\n\n";
					}
					
					// ****************************************************
					// Modification pour récupérer la source dans le tableau si elle est renseigner
					if (!isset($AttmFile['source']))
					{
						$fd=fopen ($AttmFile['filename'], "rb");
						$FileContent=fread($fd,filesize($AttmFile['filename']));
						fclose ($fd);
					}
					else
					{
						$FileContent = $AttmFile['source'];					
					}
					// FIN Modification
					// ****************************************************
					
					$FileContent = chunk_split(base64_encode($FileContent));
					$message .= $FileContent;
					$message .= "\n\n";
				}
				$message .= "\n--".$B."--\n";
			}
			return $message;
		}
		
		/**
		* surcharge de la fonction d'origine de simplemail afin d'annuler le retour à la ligne automatique
		* 
		* @param	string	contenu
		* @return	string	contenu modifié
		*/
		function BodyLineWrap($Value)
		{
			return $Value;
		}
		
		/**
		* surcharge de la fonction d'origine de simplemail afin de traiter les erreurs
		* 
		* @return	string	erreur PHP eventuelle
		*/
		function sendmail() 
		{
			ob_start();
			parent::sendmail();
			$erreur = trim(strip_tags(ob_get_clean()));

			if ($this->old_sendmail_from)
				ini_set('sendmail_from', $this->old_sendmail_from);

			if ($erreur)
			{
				return $erreur;
			}
			return null;
		}
	}
}
?>